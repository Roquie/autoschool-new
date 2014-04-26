<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_V1 extends Controller
{

    protected $_file = '';

    protected $_xml = null;

    public function before()
    {
        parent::before();

        $settings = new Model_Settings();
        $remote_addr = $settings->get('sync_remote_addr');

        if (!$settings->get('sync') && !$remote_addr)
        {
            throw new HTTP_Exception_404();
        }
        else
        {
            if ($remote_addr)
            {
                if ($_SERVER['REMOTE_ADDR'] !== $remote_addr)
                {
                    throw new HTTP_Exception_404();
                }
            }
        }

        $this->_file = APPPATH.'download/xml/missed_requests.xml';
        $this->_xml = new SimpleXMLElement("<xml version=\"1.0\" encoding=\"utf-8\"/>");
    }

/*    public function action_test_me()
    {

          $lol=  Request::factory('api/v1/data_ok')
                ->method(Request::POST)

                ->execute();
          //  echo $lol;
          $xml = new SimpleXMLElement($lol);
          $xml->saveXML('asdasdasd.xml');

    }*/

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

    protected function _response($status = 'success', $msg = '')
    {
        $root = $this->_xml->addChild('root');
        $info = $root->addChild('info');
        $info->addAttribute('status', $status);
        $info->addAttribute('msg', $msg);

        $this->response->headers('Content-Type', 'application/xml');
        $this->response->body($this->_xml->asXML());
    }


}
