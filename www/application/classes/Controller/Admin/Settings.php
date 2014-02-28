<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Base
{

    public function action_index()
    {
        $this->template->content = View::factory('admin/html/settings/smtp');
    }

    public function action_administrators()
    {
        $admins = array();
        $info = array();
        $data = $this->request->post();
        $tmp = $this->request->query('csrf');
        $csrf = empty($tmp) ? $this->request->post('csrf') : $tmp;

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $admin_id = $this->request->query();

            $admin = ORM::factory('User', $admin_id['id']);

            if ($admin->loaded())
            {
                $admin->delete();
                HTTP::redirect(Request::initial()->uri());
            }
            else
            {
                $errors = Kohana::message('users', 'admin_not_found');
            }
        }
        else if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $data['photo'] = 'img/photo.jpg';
            $newpass = Text::random();
            try
            {
                $users = ORM::factory('User');
                $pk = $users
                    ->create_user(
                        array(
                            'photo' => $data['photo'],
                            'password' => $newpass,
                            'password_confirm' => $newpass,
                            'email' => $data['email']
                        ),
                        array(
                            'photo',
                            'password',
                            'email',
                        ))
                    ->pk();

                ORM::factory('Administrators')
                    ->values(array(
                        'family_name' => $data['family_name'],
                        'first_name' => $data['first_name'],
                        'user_id' => $pk
                    ))
                    ->save();

                try
                {
                    Email::factory('Регистрация в Автошколе МПТ', '<p>Ваш логин: '.$data['email'].'</p> <p>Ваш пароль : '. $newpass.' </p>', 'text/html')
                        ->to($data['email'])
                        ->from('auto@mpt.ru', 'Автошкола МПТ')
                        ->send();
                }
                catch(Swift_SwiftException $e)
                {
                    die($e->getMessage());
                }

                $role = array(1, 2);
                $users->add('roles', $role);
                HTTP::redirect(Request::initial()->uri());
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $res = ORM::factory('User')->order_by('id', 'desc')->find_all();

        foreach($res as $v) {
            $roles = $v->roles->find_all();
            foreach($roles as $role) {
                if ($role->name === 'admin') {
                    $info = ORM::factory('Administrators')->where('user_id', '=', $v->id)->find()->as_array();
                    $admins[] = array(
                        'id' => $v->id,
                        'email' => $v->email,
                        'info' => $info
                    );
                }
            }
        }

        $this->template->content = View::factory('admin/html/settings/admins', compact('errors', 'data', 'admins'));
    }

    public function action_upload()
    {
        $this->template->content = View::factory('admin/html/settings/upload');
    }

}