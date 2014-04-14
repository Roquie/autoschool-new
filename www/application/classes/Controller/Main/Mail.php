<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Mail extends Controller_Main_Base
{


    public function action_send()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $valid = new Validation(Arr::map('trim', $post));
            $valid->rule('name', 'not_empty')
                  ->rule('name', 'alpha', array(':value', true))
                  ->rule('message', 'not_empty')
                  ->rule('message', 'min_length', array(':value', 10))
                  ->rule('message', 'max_length', array(':value', 5000))
                  ->rule('email', 'not_empty')
                  ->rule('email', 'email')
                  ->rule('captcha', 'not_empty')
                  ->rule('captcha', 'Captcha::valid')
                  ->rule('file_name', 'min_length', array(':value', 5))
                  ->rule('file_name', 'max_length', array(':value', 2000));

            if ($valid->check())
            {
                $message = View::factory('tmpmail/template', array(
                'mail_content' => View::factory('tmpmail/main/contacts',
                        array(
                               'message' => $post['message'],
                               'name' => $post['name'],
                               'email' => $post['email']
                             ))
                ));

                $path = APPPATH.'uploads/';

                if (!empty($_FILES['file']['name']))
                {

                    $valid = new Validation($_FILES);
                    $valid->rule('file', 'Upload::valid')
                          ->rule('file', 'Upload::not_empty')
                          ->rule('file', 'Upload::type', array(':value', array('docx','doc', 'pdf', 'jpg', 'jpeg,', 'png', 'gif', 'tiff', 'psd', 'txt', 'rtf', 'zip', 'rar', '7z', 'pages')))
                          ->rule('file', 'Upload::size', array(':value', '5M'));

                    if ($valid->check())
                    {
                        $status = Upload::save($_FILES['files'], $_FILES['file']['name'], APPPATH.'uploads/', 0444);
                        $file_name = $_FILES['file']['name'];

                        if ($status)
                        {
                            try
                            {
                                Email::factory('Автошкола МПТ', $message, 'text/html')
                                     ->to(array(
                                               'vik.melnikov@gmail.com',
                                               'roquie0@gmail.com',
                                             //  'auto@mpt.ru'
                                          ))
                                     ->from($post['email'], $post['name'])
                                     ->attach_file($path.$file_name)
                                     ->send();

                            }
                            catch(Swift_SwiftException $e)
                            {
                                die($e->getMessage());
                            }

                            $success = 'Спасибо. Письмо отправлено!';

                            chmod($path.$file_name, 0775);
                            unlink($path.$file_name);
                        }
                        else
                        {
                            $error = 'Ошибка загрузки файла.';
                        }

                    }
                    else
                    {
                        $errors = $valid->errors('upload');
                        $error = array_shift($errors);
                    }


                }
                else
                {
                    try
                    {
                        Email::factory('Автошкола МПТ', $message, 'text/html')
                             ->to(array(
                                       'vik.melnikov@gmail.com',
                                       'roquie0@gmail.com',
                                       //  'auto@mpt.ru'
                                  ))
                             ->from($post['email'], $post['name'])
                             ->send();
                    }
                    catch(Swift_SwiftException $e)
                    {
                        die($e->getMessage());
                    }

                    $success = 'Спасибо. Письмо отправлено!';

                }



            }
            else
            {
                $errors = $valid->errors('upload');
                $error = array_shift($errors);
            }
        }

        $this->template->content = View::factory('main/feedback', compact('captcha', 'error', 'success'));
    }




}