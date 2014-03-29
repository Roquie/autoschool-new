<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files_Print extends Controller_Admin_Base
{
    protected $_convert_url = 'http://am3-word-view.officeapps.live.com/wv/WordViewer/request.pdf?WOPIsrc=http%3A%2F%2Fam3-15-view-wopi%2Ewopi%2Elive%2Enet%3A808%2Foh%2Fwopi%2Ffiles%2F%40%2FwFileId%3FwFileId%3D';

    public function before()
    {
        parent::before();
        $this->auto_render = false;
    }

    public function action_statement()
    {
       /*
       // а так тоже работает, полет какашкиной мысли))

       $lol = new Controller_Admin_Files_Download($this->request, $this->response);
        $file = $lol->action_create_statement();*/

        $response = Request::factory('admin/files/download/create_statement')
                           ->execute();

        $file = json_decode($response)->file;

        $this->response->body(
            Request::factory($this->_convert_url.urlencode(URL::site('viewdoc/'.$file)).'&type=printpdf')
                ->headers('Content-type: application/pdf')->method(Request::GET)->execute()
        );
    }

    public function action_contract()
    {
        $response = Request::factory('admin/files/download/create_contract')
                           ->execute();

        $file = json_decode($response)->file;

        HTTP::redirect($this->_convert_url.urlencode(URL::site('viewdoc/'.$file)).'&type=printpdf');
    }

    public function action_ticket()
    {
        $response = Request::factory('admin/files/download/create_ticket')
                           ->execute();

        $file = json_decode($response)->file;

        HTTP::redirect($this->_convert_url.urlencode(URL::site('viewdoc/'.$file)).'&type=printpdf');
    }




}