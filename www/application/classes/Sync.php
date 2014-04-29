<?php defined('SYSPATH') OR die('No direct script access.');


class Sync
{
    protected $_host = null;

    protected $_sql_str = '';

    protected $_file = '';

    protected $_type = null;

    protected $_last_insert_id = null;

    /**
     * @param $sql_str
     */
    public function __construct($type, $sql_str, $last_insert_id = null)
    {
        $this->_sql_str = $sql_str;
        $this->_type = $type;
        $this->_last_insert_id = $last_insert_id;
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
            if ($this->_last_insert_id)
            {
                $query = $root->addChild('query', $this->_sql_str);
                $query->addAttribute('type', $this->_type_word_assoc($this->_type));
                $query->addAttribute('last_insert_id', $this->_last_insert_id);
            }
            else
            {
                $query = $root->addChild('query', $this->_sql_str);
                $query->addAttribute('type', $this->_type_word_assoc($this->_type));
            }

            return $xml->asXML();
        }
        else
        {
            if (file_exists($this->_file))
            {
                $load_xml = simplexml_load_file($this->_file);

                if ($this->_last_insert_id)
                {
                    $query = $load_xml->root->addChild('query', $this->_sql_str);
                    $query->addAttribute('type', $this->_type_word_assoc($this->_type));
                    $query->addAttribute('last_insert_id', $this->_last_insert_id);
                }
                else
                {
                    $query = $load_xml->root->addChild('query', $this->_sql_str);
                    $query->addAttribute('type', $this->_type_word_assoc($this->_type));
                }

                return $load_xml->saveXML($this->_file);
            }
            else
            {
                if ($this->_last_insert_id)
                {
                    $query = $root->addChild('query', $this->_sql_str);
                    $query->addAttribute('type', $this->_type_word_assoc($this->_type));
                    $query->addAttribute('last_insert_id', $this->_last_insert_id);
                }
                else
                {
                    $query = $root->addChild('query', $this->_sql_str);
                    $query->addAttribute('type', $this->_type_word_assoc($this->_type));
                }

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

    protected function _type_word_assoc($type)
    {
        switch($type)
        {
            case 1:
                $assoc = 'SELECT';
            break;

            case 2:
                $assoc = 'INSERT';
            break;

            case 3:
                $assoc = 'UPDATE';
            break;

            case 4:
                $assoc = 'DELETE';
            break;

            default:
                $assoc = 'unknown';
            break;
        }

        return $assoc;
    }
} 