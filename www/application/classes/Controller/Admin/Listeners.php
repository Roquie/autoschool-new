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
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('user_id');

            $result = ORM::factory('Listeners', $id);

            Session::instance()->set('checked_user', $result->user_id);

            $data['listener'] = $result->as_array();
            if ($data['listener']['is_individual'] == 1)
                $data['contract'] = $result->indy->find()->as_array();
            else
                $data['contract'] = $data['listener'];
            $data['listener']['data_rojdeniya'] = (is_null($data['listener']['data_rojdeniya'])) ? null : date('d.m.Y', strtotime($data['listener']['data_rojdeniya']));
            $data['listener']['document_data_vydachi'] = (is_null($data['listener']['document_data_vydachi'])) ? null : date('d.m.Y', strtotime($data['listener']['document_data_vydachi']));
            $data['listener']['date_contract'] = (is_null($data['listener']['date_contract'])) ? null : date('d.m.Y', strtotime($data['listener']['date_contract']));
            $data['listener']['data_med'] = (is_null($data['listener']['data_med'])) ? null : date('d.m.Y', strtotime($data['listener']['data_med']));
            $this->ajax_data($data);
        }
    }

    public function action_users_by_group()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');
        if ($this->request->method() === Request::POST && Security::is_token($csrf))
        {
            $post = $this->request->post();
            $list_users = ((int)$post['group_id'] === 0) ? Model::factory('User')->get_user_list(false) : Model::factory('User')->by_group_id($post['group_id']);
            $this->ajax_data(
                View::factory('admin/html/listeners', compact('list_users'))->render()
            );
        }
    }

    public function action_update_user()
    {
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();
            unset($post['csrf']);

/*            try
            {
                ORM::factory('Nationality')
                    ->values($post)
                    ->create();

                HTTP::redirect('/admin/other/natandedu');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $this->_nat_and_edu->errors = $e->errors('validation');
            }*/
            $this->ajax_msg('Сохранение данных пока не доступно');
        }
    }

}