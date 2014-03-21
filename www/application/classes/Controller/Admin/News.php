<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_News extends Controller_Admin_Base
{


    public function action_index()
    {
        $news = new Model_News();

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Groups')->find_all();
        $this->template->content =
            View::factory('admin/messages/news', compact('list_users', 'list_groups'));
    }




}