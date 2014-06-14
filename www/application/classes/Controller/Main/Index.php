<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Index extends Controller_Main_Base
{

    public function action_create_backup()
    {
        $setting = new Model_Settings();
        $this->auto_render = false;

        try
        {
            $name = Database::instance()->create_backup();

            if ($setting->get('backup_email'))
            {
                $message = View::factory('tmpmail/template', array(
                      'mail_content' => View::factory('tmpmail/admin/backup_ok',
                              array(
                                   'backup_path' => $name,
                              ))
                 ));

                try
                {
                    Email::factory('Резервное копирование успешно выполнено',$message, 'text/html')
                        ->to(array(
                                  'vik.melnikov@gmail.com',
                                  'roquie0@gmail.com',
                                  'auto@mpt.ru'
                             ))
                        ->from('autompt1@gmail.com', 'Резервное копирование')
                        ->send();

                }
                catch(Swift_SwiftException $e)
                {
                    //die($e->getMessage());
                }
            }
        }
        catch(Exception $e)
        {
            if ($setting->get('backup_email'))
            {
                try
                {
                    $message = View::factory('tmpmail/template', array(
                          'mail_content' => View::factory('tmpmail/admin/backup_bad',
                                  array(
                                       'error_msg' => $e->getMessage(),
                                       'error_line' => $e->getLine(),
                                       'trace' => $e->getTraceAsString(),
                                  ))
                     ));

                    Email::factory('Ошибка резервного копирования', $message, 'text/html')
                        ->to(array(
                                  'vik.melnikov@gmail.com',
                                  'roquie0@gmail.com',
                                  'auto@mpt.ru'
                             ))
                        ->from('autompt1@gmail.com', 'Резервное копирование')
                        ->send();
                }
                catch(Swift_SwiftException $e)
                {
                    //die($e->getMessage());
                }
            }
        }



        /*$scopes = array(
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


        $client->setAccessToken($setting->get('backup_gaccess_token'));

        $this->upload_file($service, 'humans.txt', 'none', File::mime_by_ext('txt'));*/



    }

    /*protected function upload_file($service, $path, $description = 'none', $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
    {

        $file = new Google_DriveFile();

        $file->setTitle(basename($path));
        $file->setDescription($description);
        $file->setMimeType($mimeType);

        try {
            $createFile = $service->files->insert($file, array(
                                                              'data' => file_get_contents($path),
                                                              'mimeType' => $mimeType,
                                                         ));
            return $createFile;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }*/


    public function action_index()
    {
        //генерация кода для моделей. Не включать - затрет Users;
        //Gmodeler::init();

/*
        //create hashes
        $u = new Model_User();

        foreach($u->find_all() as $k => $v)
        {
            DB::update('users')->where('id', '=', $v->id)->set(array('hash' => md5(uniqid())))->execute();
        }*/

   /*     $l = new Model_Listeners();
        foreach($l->find_all() as $k => $v)
        {
            DB::update('listeners')->where('id', '=', $v->id)->set(array('tel' => Text::format_phone($v->tel)))->execute();
        }*/

        $this->template->content = View::factory('main/index');
    }




}