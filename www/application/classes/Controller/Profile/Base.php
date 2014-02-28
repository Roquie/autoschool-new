<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Base extends Controller_Template
{
    public $template = 'profile/layout';


    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('user'))
        {
            throw new HTTP_Exception_404();
        }
        if ($this->auto_render)
        {
            $this->template->title = 'profile index';
            $this->template->description = 'profile';
            $this->template->content = '';
        }

    }


}