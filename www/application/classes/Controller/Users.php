<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Users extends Controller_Main_Base
{
    public function action_login()
    {
        $post = $this->request->post();
        $a = Auth::instance();

        !$a->logged_in() ?: HTTP::redirect('/');

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            try
            {
                $status = $a->login($post['email'], $post['password'], (bool)$post['remember']);
                if ($status)
                    HTTP::redirect('/');
                else
                    $errors = array('no_user' => Kohana::message('users', 'no_user'));
            }
            catch (ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }
        else
        {
            throw new HTTP_Exception_404();
        }

        $this->template->content = View::factory('main/login-signup', compact('errors'));
    }

    /**
     * @todo: переписать с учетом новых данных
     * @throws HTTP_Exception_404
     */
    public function action_register()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
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
        else
        {
            throw new HTTP_Exception_404();
        }

        $this->template->content = View::factory('main/login-signup', compact('errors_reg'));
    }

    public function action_forgot()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $pass = Text::random();

            $data = array(
                'email' => $this->request->post('email'),
                'password' => $pass,
                'password_confirm' => $pass,
            );

            try
            {
                $users = ORM::factory('User')->where('email', '=', $data['email'])->find();
                if ($users->loaded())
                {
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
                        die($e->getMessage());
                    }

                    $success = Kohana::message('users', 'forgot_ok');
                }
                else
                {
                    $errors = array('forgot_not_found' => Kohana::message('users', 'forgot_not_found'));
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $this->template->content = View::factory('main/forgot', compact('errors', 'success'));
    }

    public function action_social()
    {
        $a = Auth::instance();

        if ($this->request->method() === Request::POST)
        {
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

                $a->force_login($data['email']);
                HTTP::redirect('/');
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors_valid = $e->errors('validation');
                $errors_auth = array('found_user' => Kohana::message('auth', 'found_user'));
                $errors = array_merge($errors_auth, $errors_valid);
            }
            if (isset($errors['found_user']))
            {
                $a->force_login($data['email']);
                HTTP::redirect('/');
            }
        }

        $this->template->content = View::factory('main/login-signup', compact('errors_social'));
    }


    public function action_logout()
    {
        !Auth::instance()->logout() ?: HTTP::redirect('/');
    }


}
