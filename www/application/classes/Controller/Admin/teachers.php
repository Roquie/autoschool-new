<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Teachers extends Controller_Admin_Base
{

    public function action_index()
    {
        $this->template->content = View::factory('admin/teachers/index');
    }

    public function action_all()
    {
        $this->template->content = View::factory('admin/teachers/all');
    }





}