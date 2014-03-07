<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Groups extends Controller_Admin_Base
{
    protected $_group = null;

    public function before()
    {
        parent::before();

        $groups = Model::factory('Groups')->find_all(); // список всех групп
        $this->_group = new View('admin/html/groups/template', compact('groups'));
        $this->_group->content = null;
    }

    public function action_index()
    {
        $group = Model::factory('Groups')->find(); // информация по первой группе из базы
        $this->_group->content = View::factory('admin/html/groups/group', compact('group'));
    }

    public function after()
    {
        $this->template->content = $this->_group->render();
        parent::after();
    }
}