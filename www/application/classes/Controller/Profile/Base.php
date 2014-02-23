<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Base extends Controller_Template
{
    public $template = 'profile/layout';


    public function before()
    {
        parent::before();

        $this->template->title = 'profile index';
        $this->template->description = 'profile';
        $this->template->content = '';
    }


}