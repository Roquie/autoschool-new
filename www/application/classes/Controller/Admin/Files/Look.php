<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files_Look extends Controller_Admin_Base
{
    protected $_temp_file = null;

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
            'group_practice',
            'listmed',
            'list_books',
            'ekz_protokol',
            'distrib',
            'distrib_all_info',
        );

        if (in_array($this->request->action(), $access))
        {
            $response = Request::factory('admin/files/download/create_'.$this->request->action())
                               ->execute();

            $this->ajax_data(
                array(
                     'file' => json_decode($response)->file,
                     'url' => URL::site('viewdoc'),
                )
            );
        }

    }

    public function action_other()
    {
        $url = $this->request->query('url');

        $this->ajax_data(
            array(
                 'file' => '',
                 'url' => $url,
            )
        );
    }

}
