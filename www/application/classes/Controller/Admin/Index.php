<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Admin_Base
{

    public function action_index()
	{
        //$this->auto_render = false;

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Group')->find_all();
        $instructors = Model::factory('Office')->getStaffs('инструктор');
        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();

        $this->template->content = View::factory('admin/index', compact('list_users', 'instructors', 'list_groups', 'edu', 'national', 'type_doc'));
	}

}