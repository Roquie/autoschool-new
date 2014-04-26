<?php defined('SYSPATH') OR die('No direct script access.');


class Sync
{
    protected $_host = null;

    protected $_sql_str = '';

    protected $_file = '';

    /**
     * @param $sql_str
     */
    public function __construct($sql_str)
    {
        $this->_sql_str = $sql_str;
        $this->_file = APPPATH.'download/xml/missed_requests.xml';

        $fat_client = Kohana::$config->load('settings.fat_client');
        $this->_host = empty($fat_client) ? true : $fat_client;
    }

    /**
     * создание файла xml
     */
    protected function _create_xml($is_ok = true)
    {
        $xml = new SimpleXMLElement("<xml version=\"1.0\" encoding=\"utf-8\"/>");
        $root = $xml->addChild('root');

        if ($is_ok)
        {
            $root->addChild('query', $this->_sql_str);

            return $xml->asXML();
        }
        else
        {
            if (file_exists($this->_file))
            {
                $load_xml = simplexml_load_file($this->_file);
                $load_xml->root->addChild('query', $this->_sql_str);
                return $load_xml->saveXML($this->_file);
            }
            else
            {
                $root->addChild('query', $this->_sql_str);

                return $xml->saveXML($this->_file);
            }
        }
    }

    /**
     * отправка sql запросов толстому клиенту
     */
    public function send()
    {
        if (Kohana::$config->load('settings.sync'))
        {
            try
            {
                Request::factory($this->_host)
                    ->method(Request::POST)
                    ->body($this->_create_xml())
                    ->headers('Content-Type', 'text/xml')
                    ->execute();
            }
            catch(Exception $e)
            {
                $this->_create_xml(false);
            }
        }

    }
} 