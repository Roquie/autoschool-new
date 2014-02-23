<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Index extends Controller_Main
{
    public $template = 'main/layout';


    public function action_index()
	{
		$this->template->content = 'all be okay, goto programming boss!';
	}
	



}