<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Aramba extends Controller
{

    public function action_get_balance()
    {
        $this->ajax_msg(
            Aramba::factory()->get_balance()
        );
    }

    public function action_send_sms()
    {
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $errors = array();

            //validation ...
            if (!Valid::not_empty($this->request->post('to')))
            {
                $errors[] = ' - Напишите номер или несколько номеров для отправки';
            }

            if (!Valid::not_empty($this->request->post('message')))
            {
                $errors[] = ' - Введите сообщение';
            }

            if (empty($errors))
            {
                //remove spaces
                $string = preg_replace('/\s+/', '', $this->request->post('to'));
                //explode string by ','
                $to = explode(',', rtrim($string, ','));
                //remove trash in string
                $format_tels = array_map('Text::removeThanDigits', $to);

                //send many sms
                $status = Aramba::factory()
                                ->to($format_tels)
                                ->msg($this->request->post('message'))
                                ->send();
                //sms status

                if ($status)
                {
                    $this->ajax_msg('Смс-ки отправлены');
                }
                else
                {
                    $this->ajax_msg('Возникла какая-то ошибка, см. логи ...', 'error');
                }
            }
            else
            {
                $this->ajax_data($errors, null, 'error');
            }
        }
    }



}