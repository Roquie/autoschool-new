<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Index extends Controller_Main_Base
{


    public function action_index()
	{
		$this->template->content = 'main index';
	}
	



}