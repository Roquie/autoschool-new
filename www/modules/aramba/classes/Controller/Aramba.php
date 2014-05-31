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
                $to = explode(', ', rtrim($this->request->post('to'), ', '));

                $format_tels = array();
                foreach($to as $k => $v)
                {
                    $format_tels[] = Text::format_phone($v);
                }

                $status = Aramba::factory()
                    ->to($format_tels)
                    ->msg($this->request->post('message'))
                    ->send();

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