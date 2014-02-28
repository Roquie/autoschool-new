<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Users extends Controller_Main_Base
{
    public function action_login()
    {
        $post = $this->request->post();
        $a = Auth::instance();


        if ($a->logged_in('user'))
        {
            HTTP::redirect('/profile');
        }
        elseif($a->logged_in('admin'))
        {
            HTTP::redirect('/admin');
        }

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            try
            {
                $status = $a->login($this->request->post('email'), $this->request->post('password'), (bool)$this->request->post('remember'));

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

        $this->template->content = View::factory('main/login', compact('errors'));
    }

    public function action_social_login()
    {
        $a = Auth::instance();

        if ($this->request->method() === Request::POST)
        {
            $s = file_get_contents(
                'http://ulogin.ru/token.php?token=' . $this->request->post('token') . '&host=' . URL::base()
            );
            $user = json_decode($s, true);

            if (isset($user['verified_email']))
            {

                try
                {
                    $human = ORM::factory('User', array('email' => $user['email']));

                    if ($human->loaded())
                    {
                        $roles = $human->roles->find_all();

                        foreach ($roles as $k => $v) {
                            if ($v->name === 'user')
                            {
                                $a->force_login($user['email']);
                                HTTP::redirect('/profile');
                            }
                            elseif ($v->name === 'admin')
                            {
                                $a->force_login($user['email']);
                                HTTP::redirect('/admin');
                            }

                        }

                    }
                    else
                    {
                        $errors = array('no_user' => Kohana::message('users', 'no_user'));
                    }

                }
                catch(Database_Exception $e)
                {
                    $errors = array('error_social_login', Kohana::message('users', 'error_social_login'));
                }
            }
            else
            {
                $errors = array('no_verifed_email' => Kohana::message('users', 'no_verifed_email'));
            }
        }

        $this->template->content = View::factory('main/login', compact('errors'));
    }

    public function action_register()
    {
        $a = Auth::instance();
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $post['photo'] = 'img/photo.jpg';

            $newpass = Text::random();

            $valid = new Validation(Arr::map('trim', $post));
            $valid->rule('famil', 'not_empty');
            $valid->rule('famil', 'alpha', array(':value', true));
            $valid->rule('famil', 'min_length', array(':value', 2));
            $valid->rule('famil', 'max_length', array(':value', 50));
            $valid->rule('imya', 'not_empty');
            $valid->rule('imya', 'alpha', array(':value', true));
            $valid->rule('imya', 'min_length', array(':value', 2));
            $valid->rule('imya', 'max_length', array(':value', 50));
            $valid->rule('ot4estvo', 'not_empty');
            $valid->rule('ot4estvo', 'alpha', array(':value', true));
            $valid->rule('ot4estvo', 'min_length', array(':value', 2));
            $valid->rule('ot4estvo', 'max_length', array(':value', 50));
            $valid->rule('mob_tel', 'not_empty');

            if ($valid->check())
            {
                try
                {
                    $users = ORM::factory('User');
                    $pk = $users
                             ->create_user(
                                array(
                                    'photo' => $post['photo'],
                                    'password' => $newpass,
                                    'password_confirm' => $newpass,
                                    'email' => $post['email']
                                ),
                                array(
                                    'photo',
                                    'password',
                                    'email',
                                ))
                             ->pk();

                    try
                    {
                        DB::insert('Statements')
                            ->columns(array('famil', 'imya', 'ot4estvo', 'mob_tel', 'user_id'))
                            ->values(array(
                                'famil' => $post['famil'],
                                'imya' => $post['imya'],
                                'ot4estvo' => $post['ot4estvo'],
                                'mob_tel' => $post['mob_tel'],
                                'user_id' => $pk
                            ))->execute();
                    }
                    catch(Database_Exception $e)
                    {
                        $errors = $e->getMessage();
                    }


                    try
                    {
                        Email::factory('Регистрация в Автошколе МПТ', '<p>Ваш логин: '.$post['email'].'</p> <p>Ваш пароль : '. $newpass.' </p>', 'text/html')
                             ->to($post['email'])
                             ->from('auto@mpt.ru', 'Автошкола МПТ')
                             ->send();
                    }
                    catch(Swift_SwiftException $e)
                    {
                        die($e->getMessage());
                    }

                    $role = array(1, 3);
                    $users->add('roles', $role);

                    $a->force_login($post['email']);
                    HTTP::redirect('/profile');
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                }
            }
            else
            {
                $errors = $valid->errors('register');
            }

        }

        $this->template->content = View::factory('main/register', compact('errors', 'post'));
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

            if (isset($user['verified_email']))
            {
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
                            'photo',
                            'password',
                            'email',
                        ));

                    $role = array(1, 3);
                    $users->add('roles', $role);

                    try
                    {
                        Email::factory('Регистрация в Автошколе МПТ', '<p>Ваш логин: '.$user['email'].'</p> <p>Ваш пароль : '. $pass.' </p>', 'text/html')
                             ->to($user['email'])
                             ->from('autompt@gmail.ru', 'Автошкола МПТ')
                             ->send();
                    }
                    catch(Swift_SwiftException $e)
                    {
                        die($e->getMessage());
                    }

                    $a->force_login($data['email']);
                    HTTP::redirect('/profile');
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                }
            }
            else
            {
                $errors = array('no_verifed_email' => Kohana::message('users', 'no_verifed_email'));
            }
        }

        $this->template->content = View::factory('main/register', compact('errors'));
    }


    public function action_logout()
    {
        !Auth::instance()->logout() ?: HTTP::redirect('/');
    }


}
