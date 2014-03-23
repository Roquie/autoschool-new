<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Media extends Controller
{

    public function action_download()
    {
        $path = $this->request->param('path');

        $this->response->send_file(APPPATH.'download/'.$path);
    }

}
