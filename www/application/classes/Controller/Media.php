<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Media extends Controller
{

    public function action_download()
    {
        $path = $this->request->param('path');

        $this->response->send_file(APPPATH.'download/'.$path);
    }

    public function action_backup_download()
    {
        if (Auth::instance()->logged_in('admin'))
        {
            $path = $this->request->param('path');

            $this->response->send_file(APPPATH.'backups/'.$path);
        }
        else
        {
            HTTP::redirect('users/login');
        }
    }

}
