<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template
{
    public $template = 'main/layout';


    public function before()
    {
        parent::before();

        $this->template->title = 'asd';
        $this->template->description = 'asd';
        $this->template->content = '';
		
    }




}