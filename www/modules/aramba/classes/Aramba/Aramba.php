<?php
/**
 * Developer: Roquie
 * 
 * All rights reserved (c)
 */

class Aramba_Aramba
{
    protected $_to = '';
    protected $_msg = '';
    protected $_from = '';

    protected $_apikey = '';

    public static function factory()
    {
        return new Aramba();
    }

    public function __construct()
    {
        $this->_apikey = Kohana::$config->load('aramba.apikey');
        $this->_from = Kohana::$config->load('aramba.from');

        if (!$this->_apikey || !$this->_from)
        {
            throw new InvalidArgumentException('\'Apikey\' or \'from\' required field ...');
        }

    }

    public function get_balance()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,'https://api.aramba.ru/balance');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ApiKey '.$this->_apikey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        return $response;
    }

    public function to($to)
    {
        $this->_to = implode(',', (array)$to);

        return $this;
    }

    public function msg($msg)
    {
        $this->_msg = $msg;

        return $this;
    }

    public function from($value)
    {
        $this->_from = $value;

        return $this;
    }

    public function send()
    {
        $smstemplate= array(
            'PhoneNumber' => $this->_to,   // номер получателя
            'Text' => $this->_msg,
            'SenderId' => $this->_from,          // ваше имя отправителя, должно быть зарегистрировано в личном кабинете
            'SendDateTime' => '', //RFC3339
            'UseRecepientTimeZone' => 'true' //True — если СМС отправляются по местному времени абонента (boolean)
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,'https://api.aramba.ru/singleSms');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ApiKey '.$this->_apikey));

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($smstemplate));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        $logfile = MODPATH.'aramba/logs/aramba/'.date('d.m.Y_H:i:s').'.log';
        file_put_contents($logfile, $response);

        return $code == 200 || $code == 201 ? true : false;
    }


}

