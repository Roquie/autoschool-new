<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Users extends Controller_Main_Base
{
    public function action_login()
    {
        if(Auth::instance()->logged_in())
            HTTP::redirect('/');

        if ($this->request->method() === Request::POST) {

            $valid = new Validation($this->request->post());
            $valid->rule('csrf', 'not_empty');
            $valid->rule('csrf', 'Security::check', array(':value'));

            if ($valid->check()) {
                try
                {
                    $status = Auth::instance()->login(
                        $this->request->post('email'),
                        $this->request->post('password'),
                        (bool)$this->request->post('remember')
                    );
                    if ($status)
                        HTTP::redirect('/');
                    else
                        $errors = array('no_user' => Kohana::message('auth', 'no_user'));
                }
                catch (ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                }
            }
        }
        $this->template->content =
            View::factory('main/login-signup')
                ->bind('errors', $errors);

    }

    public function action_register()
    {
        if ($this->request->method() === Request::POST) {

            $valid = new Validation($this->request->post());
            $valid->rule('csrf', 'not_empty');
            $valid->rule('csrf', 'Security::check', array(':value'));

            if ($valid->check()) {
                $post = $this->request->post();
                $post['photo'] = 'img/photo.jpg';
                try
                {
                    $users = ORM::factory('User');
                    $users->create_user(
                        $post,
                        array(
                         'username',
                         'lastname',
                         'photo',
                         'password',
                         'email',
                    ));

                    $role = ORM::factory('role')->where('name', '=', 'login')->find();
                    $users->add('roles', $role);
                    try
                    {
                        Email::factory('Регистрация в Поспорим.ру', '<p>Ваш логин: '.$post['email'].'</p> <p>Ваш пароль : '. $post['password'].' </p>', 'text/html')
                             ->to($post['email'])
                             ->from('info@posporim.ru', 'Поспорим.ру')
                             ->send();
                    }
                    catch(Swift_SwiftException $e)
                    {
                        die($e->getMessage());
                    }

                    Auth::instance()->force_login($post['email']);
                    HTTP::redirect('/');
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                }
            }
        }

        $this->template->content =
            View::factory('main/login-signup')
                 ->bind('errors_reg', $errors);
    }

    public function action_signup()
    {
        $this->template->content =  View::factory('main/login-signup');
    }

    public function action_forgot()
    {

        $this->auto_render = false;
        if ($this->request->method() === Request::POST) {

            $valid = new Validation($this->request->post());
            $valid->rule('csrf', 'not_empty');
            $valid->rule('csrf', 'Security::check', array(':value'));

            if ($valid->check()) {

                $pass = Text::random();

                $data = array(
                    'email' => $this->request->post('email'),
                    'password' => $pass,
                    'password_confirm' => $pass,
                );
                try
                {
                    $users = ORM::factory('User')->where('email', '=', $data['email'])->find();
                    if ($users->loaded()) {
                        $users->update_user(
                            $data,
                            array(
                                'email',
                                'password',
                            ));

                        try
                        {
                            Email::factory('Новый пароль Поспорим.ру', '<p>Ваш логин: '.$data['email'].'</p> <p>Ваш <b>новый</b> пароль : '. $data['password'].' </p>', 'text/html')
                                ->to($data['email'])
                                ->from('info@posporim.ru', 'Поспорим.ру')
                                ->send();
                        }
                        catch(Swift_SwiftException $e)
                        {
                            $this->ajax_msg($e->getMessage(), 'error');
                        }

                        $this->ajax_msg('Новый пароль выслан Вам на почту');
                    } else {
                        $this->ajax_msg('Пользователь с данным e-mail отсутствует', 'error');
                    }
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                    $this->ajax_msg(array_shift($errors), 'error');
                }
            }
        }
    }

    public function action_social()
    {
        if ($this->request->method() === Request::POST) {
            $s = file_get_contents(
                'http://ulogin.ru/token.php?token=' . $this->request->post('token') . '&host=' . URL::base()
            );
            $user = json_decode($s, true);

            if ((empty($user['photo_big']) || $user['photo_big'] === 'https://ulogin.ru/img/photo_big.png') && !array_key_exists('error', $user))
                $user['photo_big'] = 'img/photo.jpg';

            $pass = Text::random();

            $data = array(
                'username' => $user['first_name'],
                'lastname' => $user['last_name'],
                'photo' => $user['photo_big'],
                'password' => $pass,
                'password_confirm' => $pass,
                'email' => $user['email']
            );

            try
            {
                $users = ORM::factory('User');
                $users->create_user(
                    $data,
                    array(
                        'username',
                        'lastname',
                        'photo',
                        'password',
                        'email',
                    ));

                try
                {
                    Email::factory('Регистрация в Поспорим.ру', '<p>Ваш логин: '.$user['email'].'</p> <p>Ваш пароль : '. $pass.' </p>', 'text/html')
                        ->to($user['email'])
                        ->from('info@posporim.ru', 'Поспорим.ру')
                        ->send();
                }
                catch(Swift_SwiftException $e)
                {
                    die($e->getMessage());
                }

                $role = ORM::factory('role')->where('name', '=', 'login')->find();
                $users->add('roles', $role);

                Auth::instance()->force_login($data['email']);
                HTTP::redirect('/');
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors_valid = $e->errors('validation');
                $errors_auth = array('found_user' => Kohana::message('auth', 'found_user'));
                $errors = array_merge($errors_auth, $errors_valid);
            }
            if (isset($errors['found_user'])) {
                Auth::instance()->force_login($data['email']);
                HTTP::redirect('/');
            }
        }

        $this->template->content =
            View::factory('main/login-signup')
                ->bind('errors_social', $errors);

    }



    public function action_logout()
    {
        if(Auth::instance()->logout())
            HTTP::redirect('/');
    }


}
