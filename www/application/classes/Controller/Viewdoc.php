<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Viewdoc extends Controller
{
    public function action_temp_view()
    {
        $path = $this->request->param('path');

        $this->response->send_file(
            APPPATH.'download/'.$path,
            null,
            array('delete' => true)
        );
    }




}
