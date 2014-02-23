<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Base extends Controller_Template
{
    public $template = 'admin/layout';

    public function before()
    {
        parent::before();

        $this->template->title = 'Admin';
        $this->template->description = 'admin';
        $this->template->content = '';
    }


}