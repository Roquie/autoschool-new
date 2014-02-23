<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Base extends Controller_Template
{
    public $template = 'main/layout';

    public function before()
    {
        parent::before();

        $this->template->title = 'Main index';
        $this->template->description = 'Main';
        $this->template->content = '';
    }


}