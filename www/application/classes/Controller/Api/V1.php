<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_V1 extends Controller
{

    protected $_file = '';

    protected $_xml = null;

    protected $_sttg = null;

    public function before()
    {
        parent::before();

        $this->_sttg = new Model_Settings();
        $remote_addr = $this->_sttg->get('sync_remote_addr');

        //if (!($this->request->method() === Request::POST))
        {
          //  throw new HTTP_Exception_404();
        }
        if(!$this->_sttg->get('sync'))
        {
            throw new HTTP_Exception_404();
        }
       // elseif(!$remote_addr)
        {
         //   throw new HTTP_Exception_404();
        }

        if ($remote_addr)
        {
            if ($_SERVER['REMOTE_ADDR'] !== $remote_addr)
            {
                throw new HTTP_Exception_404();
            }
        }

        $this->_file = APPPATH.'download/xml/missed_requests.xml';
        $this->_xml = new SimpleXMLElement("<xml version=\"1.0\" encoding=\"utf-8\"/>");
    }


    /**
     * метод для тестов. Сюда тупо слать запросы
     */
    public function action_test()
    {
        $post = $this->request->post();

        $this->response->body(
            var_export(
                $post
                    ? $post
                    : 'post is empty'
            )
        );
    }

    /**
     * задать ip адрес куда стучатся сайту с запросами
     */
    public function action_set_remote_host()
    {
        $result = $this->_sttg->set('fat_client',
            $this->request->post('remote_host')
        );

        if ($result)
        {
            $this->_response();
        }
        else
        {
            $this->_response('error', 'error in database');
        }
    }

    /**
     *  метод ПОДТВЕРЖДАЕТ что ты забрал данные по методу get_missed_data
     */
    public function action_missed_data_ok()
    {
        if (file_exists($this->_file))
        {
            if (unlink($this->_file))
            {
               $this->_response();
            }
            else
            {
                $this->_response('error', 'какието проблемы');
            }
        }
    }

    /**
     * забрать все данные,
     * которые не дошли до толстого клиента.
     * После того как успешно их забрал обратиться к методу missed_data_ok
     */
    public function action_get_missed_data()
    {
        if (file_exists($this->_file))
        {
            $xml = simplexml_load_file($this->_file);

            $info = $xml->root->addChild('info');
            $info->addAttribute('status', 'success');
            $this->response->headers('Content-Type', 'application/xml');
            $this->response->body($xml->asXML());
        }
        else
        {
            $this->_response('error', 'file not found');
        }

    }

    /**
     * response aga
     * @param string $status
     * @param string $msg
     */
    protected function _response($status = 'success', $msg = 'all be okay')
    {
        $root = $this->_xml->addChild('root');
        $info = $root->addChild('info');
        $info->addAttribute('status', $status);
        $info->addAttribute('msg', $msg);

        $this->response->headers('Content-Type', 'application/xml');
        $this->response->body($this->_xml->asXML());
    }


}
