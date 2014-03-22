<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Listeners extends Controller_Admin_Base
{

    public function action_distrib()
    {
        $u = new Model_User();
        $list_users = $u->get_user_list(true);

        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();

        $this->template->content =
            View::factory('admin/listeners/distrib', compact('errors', 'success', 'edu', 'national', 'type_doc', 'list_users'))
                ->render();
    }

    public function action_getUser()
    {
        $csrf = $this->request->post('csrf');
        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('user_id');

            $data['listener'] = ORM::factory('Listeners', $id)->as_array();
            $data['listener']['data_rojdeniya'] = date('d.m.Y', strtotime($data['listener']['data_rojdeniya']));
            $data['listener']['document_data_vydachi'] = date('d.m.Y', strtotime($data['listener']['document_data_vydachi']));
            $data['listener']['date_contract'] = date('d.m.Y', strtotime($data['listener']['date_contract']));
            $data['listener']['data_med'] = date('d.m.Y', strtotime($data['listener']['data_med']));
            $this->ajax_data($data);
        }
    }

}