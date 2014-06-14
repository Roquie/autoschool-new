<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Settings extends Controller_Admin_Base
{
    protected $_gclient = null;

    const BACKUP_EVERY_DAY = 0;
    const BACKUP_THREE_DAY = 1;
    const BACKUP_WEEK = 2;
    const BACKUP_TWO_WEEK = 3;
    const BACKUP_MONTH = 4;
    const BACKUP_TWO_MONTH = 5;

    const UPLOAD_TYPE_TEMPLATE = 2;

    public function before()
    {
        parent::before();

        $this->template->success = null;
        /*$this->_gclient = new Google_Client();*/
    }

   /* public function action_backup_google_ok()
    {
        $this->auto_render = false;
        $setting = new Model_Settings();

        $scopes = array(
            'https://www.googleapis.com/auth/drive.file',
        );
        $scriptUri = URL::site('admin/settings/backup_google_ok');

        $client = new Google_Client();
        $service = new Google_DriveService($client);


        $client->setAccessType('online'); // default: offline
        $client->setClientId('1064636737871-2jor44gbnmhdms9cccmj1vnfjfmfbsi7.apps.googleusercontent.com');
        $client->setClientSecret('L04VtCHS35xk3WczPg9yilsp');
        $client->setRedirectUri($scriptUri);
        $client->setScopes($scopes);

        $plus = new Google_Oauth2Service($client);

        if ($this->request->query('code'))
        {
            $client->authenticate($this->request->query('code'));
            $setting->set('backup_gaccess_token', $client->getAccessToken());
            HTTP::redirect('admin/settings/backup');
        }




    }*/



    public function action_backup()
    {
        $setting = new Model_Settings();
        $backup_url = URL::site('index/create_backup');

        $type_tasks = array(
                'Каждый день',
                'Каждые три дня',
                'Еженедельно (в вс)',
                'Каждые две недели (в пт)',
                'Каждый месяц (первого числа)',
                'Каждые два месяца (первого числа)',
        );


        if ($this->request->query('remove') && $this->request->query('csrf'))
        {
            $csrf = pack('H*', $this->request->query('csrf'));

            if (Security::is_token($csrf))
            {
                if (file_exists(APPPATH.'backups/'.$this->request->query('remove')))
                {
                    unlink(APPPATH.'backups/'.$this->request->query('remove'));

                    $this->msg('Архив '.Security::xss_clean($this->request->query('remove')).' удален');
                }
                else
                {
                    HTTP::redirect(
                        $this->request->current()->url()
                    );
                }
            }
        }


        $post = $this->request->post();
        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {

            $this->request->post('email_ok')
                ? $setting->set('backup_email', true) : $setting->set('backup_email', false);

            /*if($this->request->post('google_ok'))
            {
                $setting->set('backup_grive', true);

                $scopes = array(
                    'https://www.googleapis.com/auth/drive.file',
                );
                $scriptUri = URL::site('admin/settings/backup_google_ok');

                $client = new Google_Client();
                $service = new Google_DriveService($client);


                $client->setAccessType('online'); // default: offline
                $client->setClientId('1064636737871-2jor44gbnmhdms9cccmj1vnfjfmfbsi7.apps.googleusercontent.com');
                $client->setClientSecret('L04VtCHS35xk3WczPg9yilsp');
                $client->setRedirectUri($scriptUri);
                $client->setScopes($scopes);

                $plus = new Google_Oauth2Service($client);

                if (!$client->getAccessToken())
                {
                    HTTP::redirect($client->createAuthUrl());
                }

            }
            else
            {
                $setting->set('backup_gaccess_token', false);
                $setting->set('backup_grive', false);
            }*/


            $setting->set('backup', (bool)$this->request->post('backup_status'));

            if (!$setting->get('backup'))
            {
                if (Valid::digit(Text::removeThanDigits($this->request->post('time'))))
                {
                    list($hours, $min) = explode(':', $this->request->post('time'));
                    if (Valid::range($min, 0, 60) && Valid::range($hours, 0, 24))
                    {
                        $setting->set('backup_time', $hours.':'.$min);
                        switch($this->request->post('type_task'))
                        {
                            case self::BACKUP_EVERY_DAY:
                                $setting->set('backup_first_type', self::BACKUP_EVERY_DAY);
                                $this->_set_cron_job($min, $hours, '*', '*', '*', $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;

                            case self::BACKUP_THREE_DAY:
                                $setting->set('backup_first_type', self::BACKUP_THREE_DAY);
                                $this->_set_cron_job($min, $hours, '*/3', '*', '*', $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;

                            case self::BACKUP_WEEK:
                                $setting->set('backup_first_type', self::BACKUP_WEEK);
                                $this->_set_cron_job($min, $hours, '*', '*', 0, $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;

                            case self::BACKUP_TWO_WEEK:
                                $setting->set('backup_first_type', self::BACKUP_TWO_WEEK);
                                $this->_set_cron_job($min, $hours, '*', '*', 'Sun expr `date +\%W` \% 2 > /dev/null ||', $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;

                            case self::BACKUP_MONTH:
                                $setting->set('backup_first_type', self::BACKUP_MONTH);
                                $this->_set_cron_job($min, $hours, 1, '*', '*', $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;

                            case self::BACKUP_TWO_MONTH:
                                $setting->set('backup_first_type', self::BACKUP_TWO_MONTH);
                                $this->_set_cron_job($min, $hours, 1, '*/2', '*', $backup_url);
                                $this->msg('Резервное копирование успешно настроено');
                            break;
                        }
                    }
                    else
                    {
                        $this->msg('Не верно задан формат времени', 'danger');
                    }
                }


            }
            else
            {
                $setting->set('backup_first_type', self::BACKUP_EVERY_DAY);
                $this->_delete_cron_job($backup_url);
                $this->msg('Резервное копирование выключено');
            }

        }

        /*
          $output = shell_exec('crontab -l');
          echo "<pre>$output</pre>";
          exit;
        */

       //$this->auto_render = false;

      /*  $output = shell_exec('crontab -l');
        echo "<pre>$output</pre>";
        $output = shell_exec('crontab -l');

        //file_put_contents('/tmp/crontab.txt', $output.'* /1 * * * * curl http://auto.mpt.ru/index/cron &>/dev/null'.PHP_EOL);
        //echo exec('crontab /tmp/crontab.txt');*/

        //get contents of cron tab
        /*echo 'cron default:  <br><pre>';
        $output = shell_exec('crontab -l');
        echo "</pre><pre>$output</pre>";*/

       /* echo 'set job:  <br><pre>';
        $url = URL::site('index/create_backup');
        $this->_set_cron_job('* /1', '*', '*', '*', '*', $url);*/


       /* $output = shell_exec('crontab -l');
        echo "</pre><pre>$output</pre>";*/

        /*echo 'deleted:  <br><pre>';
        echo $this->_delete_cron_job('auto.mpt.ru/index/cron');*/




      // exit;

       $backup_files = File::listFiles(APPPATH.'backups', 'gz');
       rsort($backup_files);

       $this->template->content = View::factory('admin/settings/backup', compact('backup_files', 'data', 'error', 'success', 'type_tasks'));
    }

    protected function _set_cron_job($minutes = '*', $hours = '*', $days = '*', $months = '*', $day_of_the_week = '*', $url)
    {
        $output = shell_exec('crontab -l');
        $cron_str = "$output $minutes $hours $days $months $day_of_the_week curl $url &>/dev/null \n";

        file_put_contents(
            '/tmp/crontab.txt',
            $cron_str
        );

        shell_exec('crontab /tmp/crontab.txt');

        return $cron_str;
    }

    protected function _delete_cron_job($find_text)
    {
        $output = shell_exec('crontab -l');
        $lol = explode("\n", rtrim($output, "\n"));

        $i=0;
        foreach($lol as $k => $v)
        {
            if (strpos($v, $find_text) !== false)
            {
                unset($lol[$i]);
            }
            $i++;
        }

        $new_cron = implode("\n", $lol);

        file_put_contents('/tmp/crontab.txt', $new_cron);

        return shell_exec('crontab /tmp/crontab.txt');
    }

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
                    {
                        $this->msg('Синхронизация включена');
                    }
                    else
                    {
                        $this->msg('Синхронизация отключена', 'danger');
                    }

                break;

                case 'ip_edit':
                    if (!Valid::not_empty($post['ip_access']))
                    {
                        $setting->set('sync_remote_addr', null);

                        $data = array_merge($data, $post);
                        $this->msg('Доступ к скриптам разрешен для всех хостов');
                    }
                    else
                    {
                        if (Valid::ip($post['ip_access'], 11))
                        {
                            $setting->set('sync_remote_addr', $post['ip_access']);

                            $data = array_merge($data, $post);
                            $this->msg('IP изменен.');
                        }
                        else
                        {
                            $data = array_merge($data, $post);
                            $this->msg('Введите IP правильно', 'danger');
                        }
                    }

                break;
            }

        }

        $this->template->content = View::factory('admin/settings/sync', compact('data'));
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
                        $this->msg('Номер(а) изменены.');
                    }
                    else
                    {
                        $data = array_merge($data, $post);
                        $this->msg('Введите оба телефона правильно', 'danger');
                    }

                break;

                case 'email' :

                    if (Valid::email($post['email']))
                    {
                        $setting->set('email', $post['email']);

                        $data = array_merge($data, $post);
                        $this->msg('Email изменен.');
                    }
                    else
                    {
                        $data = array_merge($data, $post);
                        $this->msg('Введите email правильно', 'danger');
                    }

                break;

                case 'general' :

                    $setting->set('title', $post['title']);
                    $setting->set('address', $post['address']);

                    $data = array_merge($data, $post);
                    $this->msg('Основные данные изменены.');

                break;
            }
        }

        $this->template->content = View::factory('admin/settings/index', compact('data'));
    }

    public function action_smtp()
    {
        $setting = new Model_Settings();

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            if ( ! $setting->get('smtp'))
            {
                $validate = Validation::factory($post);
                $validate->labels(array(
                    'server' => 'Поле "сервер"',
                    'port' => 'Поле "порт"',
                    'login' => 'Поле "e-mail"'
                ))
                    ->rule('server', 'not_empty')
                    ->rule('port', 'not_empty')
                    ->rule('port', 'digit')
                    ->rule('port', 'min_length', array(':value', 1))
                    ->rule('port', 'max_length', array(':value', 65536))
                    ->rule('login', 'not_empty')
                    ->rule('login', 'email')
                    ->rule('password', 'not_empty');

                if ($validate->check())
                {
                    unset($post['csrf']);
                    $setting->set('smtp', true);
                    $setting->set('smtp_data', json_encode($post));

                    $this->msg('Для отправки всех писем включено SMTP');
                }
                else
                {
                    Session::instance()->set('smtp_data', $post);
                    $errors = $validate->errors('validation');
                    $this->msg(array_shift($errors), 'danger');
                }
            }
            else
            {
                //$setting->set('smtp_data', null);
                $setting->set('smtp', false);
                $this->msg('SMTP отключено. Возможны проблемы при отправке писем! Рекомендуется заново его включить!', 'danger');
            }
        }

        if ($setting->get('smtp'))
        {
            Session::instance()->set('smtp_data', json_decode($setting->get('smtp_data'), true));
        }

        $this->template->content = View::factory('admin/settings/smtp')->set('post', Session::instance()->get('smtp_data'));
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

                $this->msg('Администратор удален.', 'danger');
            }
            else
            {
                $this->msg(Kohana::message('users', 'admin_not_found'), 'danger');
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
                            'email' => $data['email'],
                            'hash' => md5(uniqid())
                        ),
                        array(
                            'photo',
                            'password',
                            'email',
                            'hash'
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
                    $this->msg($e->getMessage(), 'danger');
                }

                $role = array(1, 2);
                $users->add('roles', $role);

                $this->msg('Администратор добавлен. Ему выслано уведомление на почту.');
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
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

        $this->template->content = View::factory('admin/settings/admins', compact('data', 'admins'));
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
                $this->msg('Выберите файл, который нужно заменить.');
            }

            $validate = Validation::factory($_FILES)
                                  ->rule('files', 'Upload::valid')
                                  ->rule('files', 'Upload::not_empty')
                                  ->rule('files', 'Upload::type', array(':value', array('docx','doc', 'pdf')))
                                  ->rule('files', 'Upload::size', array(':value', '5M'));

            if ($validate->check())
            {
                $file_info = ORM::factory('Files')->where('id', '=', $file_type_id)->find();
                if ($file_info->loaded())
                {
                    //$file_info->filename,

                    $status = Upload::save($_FILES['files'], $file_info->filename, APPPATH.$file_info->path, 0775);

                    $status ? $this->msg('Файл загружен и успешно заменён.') : $this->msg('Ошибка загрузки', 'danger');
                }
                else
                {
                    $this->msg('Файл не найден', 'danger');
                }
            }
            else
            {
                $errors = $validate->errors('upload');
                $this->msg(array_shift($errors), 'danger');
            }

        }

        $files = ORM::factory('Files')->find_all();
        $this->template->content = View::factory('admin/settings/upload', compact('files'));
    }

}