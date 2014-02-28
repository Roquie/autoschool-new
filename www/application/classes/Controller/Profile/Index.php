<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Index extends Controller_Profile_Base
{
    public function action_index()
	{
        $a = Auth::instance();
        $group = ORM::factory('Groups', $a->get_user()->id)
                    ->find()
                    ->as_array();

		$this->template->content = View::factory('profile/index', compact('group'));
	}
	



}