<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Base
{

    public function action_sync()
    {
        $setting = new Model_Settings();

        $data = array(
            'ip_access' => $setting->get('sync_remote_addr'),
        );

        $post = $this->request->post();
        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            switch ($post['type'])
            {
                case 'on_off':
                    $setting->set('sync', (bool)$post['on_off']);

                    $data = array_merge($data, $post);

                    if ((bool)$post['on_off'])
                        $success = 'Синхронизация включена';
                    else
                        $success = 'Синхронизация отключена';

                break;

                case 'ip_edit':
                    if (!Valid::not_empty($post['ip_access']))
                    {
                        $setting->set('sync_remote_addr', null);

                        $data = array_merge($data, $post);
                        $success = 'Доступ к скриптам разрешен для всех хостов';
                    }
                    else
                    {
                        if (Valid::ip($post['ip_access'], 11))
                        {
                            $setting->set('sync_remote_addr', $post['ip_access']);

                            $data = array_merge($data, $post);
                            $success = 'IP изменен.';
                        }
                        else
                        {
                            $data = array_merge($data, $post);
                            $error = 'Введите IP правильно';
                        }
                    }

                break;
            }

        }

        $this->template->content = View::factory('admin/settings/sync', compact('data', 'error', 'success'));
    }

    public function action_index()
    {
        $setting = new Model_Settings();

        $data = array(
            'telephone_1' => $setting->get('tel1'),
            'telephone_2' => $setting->get('tel2'),
            'email' => $setting->get('email'),
            'title' => $setting->get('title'),
            'address' => $setting->get('address'),
        );

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $post = array_map('Security::xss_clean', $post);

            switch ($post['type'])
            {
                case 'tel' :

                    if (Valid::phone($post['telephone_1'], 11) && Valid::phone($post['telephone_2'], 11))
                    {
                        $setting->set('tel1', $post['telephone_1']);
                        $setting->set('tel2', $post['telephone_2']);

                        $data = array_merge($data, $post);
                        $success = 'Номер(а) изменены.';
                    }
                    else
                    {
                        $data = array_merge($data, $post);
                        $error = 'Введите оба телефона правильно';
                    }

                break;

                case 'email' :

                    if (Valid::email($post['email']))
                    {
                        $setting->set('email', $post['email']);

                        $data = array_merge($data, $post);
                        $success = 'Email изменен.';
                    }
                    else
                    {
                        $data = array_merge($data, $post);
                        $error = 'Введите email правильно';
                    }

                break;

                case 'general' :

                    $setting->set('title', $post['title']);
                    $setting->set('address', $post['address']);

                    $data = array_merge($data, $post);
                    $success = 'Основные данные изменены.';

                break;
            }
        }

        $this->template->content = View::factory('admin/settings/index', compact('data', 'error', 'success'));
    }

    public function action_smtp()
    {
        $data = Kohana::$config->load('settings.smtp');
        if (!empty($data))
            $data = unserialize($data);

        $csrf = $this->request->post('csrf');
        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $data= $this->request->post();
            unset($data['csrf']);
            $values = array_filter($data);
            if (!empty($values))
            {
                $validate = Validation::factory(Arr::map('trim', $data));
                $validate->labels(array(
                    'server' => 'Поле "сервер"',
                    'port' => 'Поле "порт"',
                    'email' => 'Поле "e-mail"'
                ))
                    ->rule('server', 'not_empty')
                    ->rule('port', 'not_empty')
                    ->rule('port', 'digit')
                    ->rule('port', 'min_length', array(':value', 1))
                    ->rule('port', 'max_length', array(':value', 65536))
                    ->rule('email', 'email');

                if ($validate->check())
                {
                    Model::factory('Settings')->set('smtp', serialize($data));
                    HTTP::redirect(Request::initial()->uri());
                }
                else
                {
                    $errors = $validate->errors('validation');
                }
            } else {
                Model::factory('Settings')->set('smtp', 0);
                HTTP::redirect(Request::initial()->uri());
            }
        }
        $this->template->content = View::factory('admin/settings/smtp', compact('data', 'errors'));
    }

    public function action_administrators()
    {
        $admins = array();
        $data = $this->request->post();
        $tmp = $this->request->query('csrf');
        $csrf = empty($tmp) ? $this->request->post('csrf') : pack('H*', $tmp);
        $id = $this->request->query('id');

        /**
         * Delete admin
         */
        if (Security::is_token($csrf) && !empty($id))
        {
            $admin_id = $this->request->query('id');

            $admin = ORM::factory('User', $admin_id);

            if ($admin->loaded())
            {
                ORM::factory('Administrators', array('user_id' => $admin_id))
                    ->delete();

                $admin->delete();

                HTTP::redirect(Request::initial()->uri());
            }
            else
            {
                $errors = array('error' => Kohana::message('users', 'admin_not_found'));
            }
        }
        /**
         * Add admin
         */
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
                    ->create();

                $mail_content = View::factory('tmpmail/admin/add_adm')
                                    ->set('username', $data['first_name'])
                                    ->set('login', $data['email'])
                                    ->set('pass', $newpass);

                $message = View::factory('tmpmail/template', compact('mail_content'));

                try
                {
                    Email::factory('Регистрация в Автошколе МПТ', $message, 'text/html')
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

                    $info = ORM::factory('Administrators')
                        ->where('user_id', '=', $v->id)
                        ->where('is_root', '=', 0)
                        ->find()
                        ->as_array();

                    $info = array_filter($info);

                    if (!empty($info))
                        $admins[] = array(
                            'id' => $v->id,
                            'email' => $v->email,
                            'info' => $info
                        );
                }
            }
        }

        $this->template->content = View::factory('admin/settings/admins', compact('errors', 'data', 'admins'));
    }

    public function action_upload()
    {
        $csrf = $this->request->post('csrf');
        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            //var_export($_FILES);

            $file_type_id = $this->request->post('type_file');

            if (empty($file_type_id))
            {
                $errors = array('empty' => 'Выберите файл, который нужно заменить');
            }
            else
            {
                $validate = Validation::factory($_FILES)
                    ->rule('files', 'Upload::valid')
                    ->rule('files', 'Upload::not_empty')
                    ->rule('files', 'Upload::type', array(':value', array('docx','doc', 'pdf')))
                    ->rule('files', 'Upload::size', array(':value', '5M'));

                if ($validate->check())
                {
                    $file_info = ORM::factory('Files')->where('id', '=', $file_type_id)->find();
                    if ($file_info->filename === $_FILES['files']['name'])
                    {
                        Upload::save($_FILES['files'], $file_info->filename, APPPATH.$file_info->path, 0444);
                    }
                    else
                    {
                        $errors = array('not_equal' => 'Имя загружаемого файла не соответствует выбранному');
                    }
                }
                else
                {
                    $errors = $validate->errors('upload');
                }
            }
        }

        $files = ORM::factory('Files')->find_all();
        $this->template->content = View::factory('admin/settings/upload', compact('files', 'errors'));
    }

}