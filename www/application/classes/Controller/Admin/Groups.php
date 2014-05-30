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

            /*if ($this->request->post('distrib') == '0')
            {
            }*/

            $data = $result->as_array();

            $data['data_start'] = Text::check_date($data['data_start']);
            $data['data_end'] = Text::check_date($data['data_end']);

            $result->staff->find_all();

            //$data['instructors'] = ;

            $this->ajax_data($data);

/*            $data['contract'] = array();

            $data['listener'] = $result->as_array();
            if ((int)$data['listener']['is_individual'] == 1) {
                $data['contract'] = $result->indy->as_array();
                $data['contract']['document_data_vydachi'] = Text::check_date($data['contract']['document_data_vydachi']);
            }

            $data['listener']['data_rojdeniya'] = Text::check_date($data['listener']['data_rojdeniya']);
            $data['listener']['document_data_vydachi'] = Text::check_date($data['listener']['document_data_vydachi']);
            $data['listener']['date_contract'] = Text::check_date($data['listener']['date_contract']);
            $data['listener']['data_med'] = Text::check_date($data['listener']['data_med']);

            $this->ajax_data($data);*/
        }
    }

}