<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files_Look extends Controller_Admin_Base
{
    public $_temp_file = null;

    public function before()
    {
        parent::before();
        $this->auto_render = false;

        $access = array(
            'Statement',
            'Contract',
            'Ticket',
        );

        if ($this->request->is_ajax() && in_array($this->request->action(), $access))
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

}