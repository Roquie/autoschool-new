<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Index extends Controller_Main_Base
{


    public function action_index()
	{
        $captcha = Captcha::instance()->render();

		$this->template->content = View::factory('main/index', compact('captcha'));
	}
	



}