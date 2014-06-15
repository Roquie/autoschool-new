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
                $status = $a->login(
                    $this->request->post('tel_or_email'),
                    $this->request->post('password'),
                    (bool)$this->request->post('remember')
                );

                if ($status)
                {
                    if ($a->logged_in('user'))
                    {
                        HTTP::redirect('/profile');
                    }
                    elseif($a->logged_in('admin'))
                    {
                        HTTP::redirect('/admin');
                    }
                }
                else
                {
                    $this->msg(Kohana::message('users', 'no_user'), 'danger');
                }

            }
            catch (ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
            }
        }

        $this->template->content = View::factory('main/login');
    }

    public function action_social_login()
    {
        $a = Auth::instance();

        if ($this->request->method() === Request::POST)
        {
            $s = file_get_contents(
                'http://ulogin.ru/token.php?token=' . $this->request->post('token') . '&host=' . URL::base()
            );

            $user = $s ? json_decode($s, true) : array();
            if (!empty($user) && !isset($user['error']))
            {
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
                            $this->msg(Kohana::message('users', 'no_user'), 'danger', 'users/login');
                        }

                    }
                    catch(Database_Exception $e)
                    {
                        $this->msg(Kohana::message('users', 'error_social_login'), 'danger', 'users/login');
                    }
                }
                else
                {
                    $this->msg(Kohana::message('users', 'no_verifed_email'), 'danger', 'users/login');
                }
            }
            else
            {
                $this->msg('authentication ulogin error', 'danger', 'users/login');
            }
        }

        $this->template->content = View::factory('main/login');
    }

    public function action_register()
    {
        $a = Auth::instance();

        $csrf = $this->request->post('csrf');

        //fix xss
        $post = Arr::map('Security::xss_clean',
            Arr::map('trim', $this->request->post())
        );


        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $newpass = Text::random();

            $valid = new Validation($post);
            $valid->rule('famil', 'not_empty');
            $valid->rule('famil', 'alpha', array(':value', true));
            $valid->rule('famil', 'min_length', array(':value', 2));
            $valid->rule('famil', 'max_length', array(':value', 50));
            $valid->rule('imya', 'not_empty');
            $valid->rule('imya', 'alpha', array(':value', true));
            $valid->rule('imya', 'min_length', array(':value', 2));
            $valid->rule('imya', 'max_length', array(':value', 50));
            //$valid->rule('otch', 'not_empty');
            $valid->rule('otch', 'alpha', array(':value', true));
            $valid->rule('otch', 'min_length', array(':value', 2));
            $valid->rule('otch', 'max_length', array(':value', 50));
            $valid->rule('tel', 'not_empty');
            $valid->rule('tel', 'phone', array(':value', 11));
            $valid->rule('email', 'not_empty');
            $valid->rule('email', 'email');
            $valid->rule('email', function(Validation $array, $field, $value)
                {
                    $l = new Model_User();

                    if ( ! $l->unique($field, $value))
                    {
                        $array->error($field, 'found_email');
                    }

                },
                array(':validation', ':field', ':value')
            );

            if ($valid->check())
            {
                try
                {
                    $users = ORM::factory('User');
                    $pk = $users
                             ->create_user(
                                array(
                                    'password' => $newpass,
                                    'password_confirm' => $newpass,
                                    'email' => $post['email'],
                                    'hash' => md5(uniqid())
                                ),
                                array(
                                    'password',
                                    'email',
                                    'hash'
                                ))
                             ->pk();

                    $users->add('roles', array(1,3));

                    try
                    {
                        DB::insert('listeners')
                            ->columns(array('famil', 'imya', 'otch', 'tel', 'user_id'))
                            ->values(array(
                                'famil' => $post['famil'],
                                'imya' => $post['imya'],
                                'otch' => $post['otch'],
                                'tel' => $post['tel'],
                                'user_id' => $pk
                            ))->execute();
                    }
                    catch(Database_Exception $e)
                    {
                        $errors = $e->getMessage();
                        $this->msg(array_shift($errors), 'danger');
                    }

                    $mail_content = View::factory('tmpmail/profile/registr')
                                        ->set('username', $post['imya'])
                                        ->set('login', $post['email'])
                                        ->set('pass', $newpass);

                    $message = View::factory('tmpmail/template', compact('mail_content'));

                    try
                    {
                        Email::factory('Регистрация в Автошколе МПТ', $message, 'text/html')
                             ->to($post['email'])
                             ->from(Kohana::$config->load('settings.email'), 'Автошкола МПТ')
                             ->send();

                        Session::instance()->delete('register_data');
                        $a->force_login($post['email']);
                        HTTP::redirect('/profile');
                    }
                    catch(Swift_SwiftException $e)
                    {
                        Log::instance()->add(Log::WARNING, __METHOD__.' - '.$e->getMessage());
                        $this->msg('Ошибка отправки письма с логином и паролем. Попробуйте позже.', 'danger');
                    }

                    //$role = array(1, 3);
                    //$users->add('roles', $role);
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                    $this->msg(array_shift($errors), 'danger');
                }
            }
            else
            {
                Session::instance()->set('register_data', $post);
                $errors = $valid->errors('register');
                $this->msg(array_shift($errors), 'danger');
            }

        }

        $this->template->content = View::factory('main/register')->set('post', Session::instance()->get('register_data'));
    }

    public function action_forgot()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $newpass = Text::random();

            $data = array(
              /*  'email' => !Valid::email($this->request->post('tel_or_email')) ?: $this->request->post('tel_or_email'),*/
                'password' => $newpass,
                'password_confirm' => $newpass,
            );

            try
            {
                if (Valid::email($this->request->post('tel_or_email')))
                {
                    $users = ORM::factory('User')->where('email', '=', $this->request->post('tel_or_email'))->find();
                    if ($users->loaded())
                    {
                        $users->update_user(
                            $data,
                            array(
                                /*'email',*/
                                'password',
                            ));


                            $mail_content = View::factory('tmpmail/profile/forgot')
                                                ->set('name', $users->listener->imya)
                                                ->set('login', $this->request->post('tel_or_email'))
                                                ->set('pass', $newpass);

                            $message = View::factory('tmpmail/template', compact('mail_content'));

                            try
                            {
                                Email::factory('Новый пароль, Автошкола МПТ', $message, 'text/html')
                                     ->to($this->request->post('tel_or_email'))
                                     ->from(Kohana::$config->load('settings.email'), 'Автошкола МПТ')
                                     ->send();

                                $this->msg(Kohana::message('users', 'forgot_ok'));
                            }
                            catch(Swift_SwiftException $e)
                            {
                                $this->msg('Ошибка отправки письма с новым паролем. Попробуйте позже.', 'danger');
                            }
                    }
                    else
                    {
                        $this->msg(Kohana::message('users', 'forgot_not_found'), 'danger');
                    }
                }
                else
                {
                    $listener = ORM::factory('Listeners')->where('tel', '=', Text::format_phone($this->request->post('tel_or_email')))->find();
                    if ($listener->user->loaded())
                    {
                        $listener->user->update_user(
                            $data,
                            array(
                                /*'email',*/
                                'password',
                            ));

                        try
                        {
                            Aramba::factory()
                                ->to($listener->tel)
                                ->msg('Ваш новый пароль. Данные для входа в личный кабинет ('.URL::site('users/login').'), логин: '.$listener->tel.', пароль: '.$newpass)
                                ->send();

                            $this->msg('Новый пароль отправлен вам в смс.');
                        }
                        catch(Exception $e)
                        {
                            $this->msg('Ошибка отправки смс с новым паролем. Попробуйте позже.', 'danger');
                        }
                    }
                    else
                    {
                        $this->msg(Kohana::message('users', 'forgot_not_found'), 'danger');
                    }
                }

            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
            }
        }

        $this->template->content = View::factory('main/forgot');
    }

    public function action_social()
    {
        $a = Auth::instance();

        if ($this->request->method() === Request::POST)
        {
            $s = file_get_contents(
                'http://ulogin.ru/token.php?token=' . $this->request->post('token') . '&host=' . URL::base()
            );
            $user = $s ? json_decode($s, true) : array();

            if ((empty($user['photo_big']) || $user['photo_big'] === 'https://ulogin.ru/img/photo_big.png') && !array_key_exists('error', $user))
                $user['photo_big'] = 'public/img/photo.jpg';

            $newpass = Text::random();

            if (!empty($user) && !isset($user['error']))
            {
                if (isset($user['verified_email']))
                {
                    $data = array(
                        'photo' => $user['photo_big'],
                        'password' => $newpass,
                        'password_confirm' => $newpass,
                        'email' => $user['email'],
                        'hash' => md5(uniqid())
                    );

                    try
                    {
                        $users = ORM::factory('User');
                        $pk = $users->create_user(
                            $data,
                            array(
                                 'photo',
                                 'password',
                                 'email',
                                 'hash'
                            ))->pk();

                        try
                        {
                            DB::insert('listeners')
                                ->columns(array('famil', 'imya', 'tel', 'user_id'))
                                ->values(array(
                                      'famil' => $user['last_name'],
                                      'imya' => $user['first_name'],
                                      'tel' => $user['phone'],
                                      'user_id' => $pk
                                ))->execute();
                        }
                        catch(Database_Exception $e)
                        {
                            $errors = $e->getMessage();
                        }

                        $role = array(1, 3);
                        $users->add('roles', $role);

                        $mail_content = View::factory('tmpmail/profile/registr')
                                            ->set('username', $user['first_name'])
                                            ->set('login', $user['email'])
                                            ->set('pass', $newpass);

                        $message = View::factory('tmpmail/template', compact('mail_content'));

                        try
                        {
                            Email::factory('Регистрация в Автошколе МПТ', $message, 'text/html')
                                ->to($user['email'])
                                ->from(Kohana::$config->load('settings.email'), 'Автошкола МПТ')
                                ->send();
                        }
                        catch(Swift_SwiftException $e)
                        {
                            $this->msg('Ошибка отправки письма о том, что вы зарегистрированы. Попробуйте позже.', 'danger');
                        }

                        $a->force_login($data['email']);
                        HTTP::redirect('/profile');
                    }
                    catch(ORM_Validation_Exception $e)
                    {
                        $errors = $e->errors('validation');
                        $this->msg(array_shift($errors), 'danger');
                    }
                }
                else
                {
                    $this->msg(Kohana::message('users', 'no_verifed_email'), 'danger');
                }
            }
            else
            {
                $this->msg('authentication ulogin error', 'danger', 'users/login');
            }

        }

        $this->template->content = View::factory('main/register');
    }

    public function action_logout()
    {
        !Auth::instance()->logout() ?: HTTP::redirect('/');
    }


}
