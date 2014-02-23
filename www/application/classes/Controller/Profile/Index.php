<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Index extends Controller_Profile_Base
{
    public function action_index()
	{
		$this->template->content = 'profile index';
	}
	



}