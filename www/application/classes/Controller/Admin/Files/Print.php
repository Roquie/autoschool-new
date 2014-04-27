<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files_Print extends Controller_Admin_Base
{
    protected $_convert_url = 'http://am3-word-view.officeapps.live.com/wv/WordViewer/request.pdf?WOPIsrc=http%3A%2F%2Fam3-15-view-wopi%2Ewopi%2Elive%2Enet%3A808%2Foh%2Fwopi%2Ffiles%2F%40%2FwFileId%3FwFileId%3D';

    public function before()
    {
        parent::before();
        $this->auto_render = false;

        $access = array(
            'statement',
            'contract',
            'ticket',
            'personal_card',
            'pay_doc',
        );

        if (in_array($this->request->action(), $access))
        {
            $response = Request::factory('admin/files/download/create_'.$this->request->action())
                               ->execute();

            HTTP::redirect(
                $this->_convert_url.
                urlencode(
                    URL::site('viewdoc/'.json_decode($response)->file)
                ).'&type=printpdf'
            );
        }

    }

}