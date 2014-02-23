<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Base extends Controller_Template
{
    public $template = 'main/layout';

    public function before()
    {
        parent::before();

        $this->template->title = 'МПТ Автошкола';
        $this->template->navbar = View::factory('main/navbar');
        $this->template->description = 'Main';
        $this->template->content = null;
        $this->template->footer = View::factory('main/footer');

    }


}