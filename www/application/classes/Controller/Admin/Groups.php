<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Groups extends Controller_Admin_Base
{
    protected $_group = null;

    public function before()
    {
        parent::before();

        $groups = Model::factory('Group')->find_all(); // список всех групп
        $this->_group = new View('admin/groups/template', compact('groups'));
        $this->_group->content = null;
    }

    public function action_index()
    {
        $group = Model::factory('Group')->find(); // информация по первой группе из базы
        $this->_group->content = View::factory('admin/groups/group', compact('group'));
    }

    public function after()
    {
        $this->template->content = $this->_group->render();
        parent::after();
    }

    public function action_getGroup()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('id');

            $result = ORM::factory('Group', $id);

            $data = $result->as_array();

            $data['data_start'] = Text::check_date($data['data_start']);
            $data['data_end'] = Text::check_date($data['data_end']);

            $result->staff->find_all();

            $this->ajax_data($data);

        }
    }

}