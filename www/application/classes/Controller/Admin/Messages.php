<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Messages extends Controller_Admin_Base
{

    public function before()
    {
        parent::before();

        $no_ajax = array(
            'Index'
        );

        if (!in_array($this->request->action(), $no_ajax)) {
            $this->post = $this->request->post();
            //@todo раскоменить когда полностью будет работать
            //if (Kohana::$environment === Kohana::PRODUCTION)
                if (!Request::initial()->is_ajax())
                    throw new HTTP_Exception_404();
        }

    }

    public function action_index()
    {
        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Groups')->find_all();
        $this->template->content = View::factory('admin/messages/index', compact('list_users', 'list_groups'));
    }

    public function action_users_by_group()
    {
        $this->auto_render = false;
        $csrf = $this->post['csrf'];
        if ($this->request->method() === Request::POST && Security::is_token($csrf))
        {
            $list_users = ((int)$this->post['group_id'] === 0) ? Model::factory('User')->get_user_list(false) : Model::factory('User')->by_group_id($this->post['group_id']);
            $this->ajax_data(
                View::factory('admin/html/listeners', compact('list_users'))->render()
            );
        }
    }

    public function action_get_messages()
    {
        $this->auto_render = false;
        $csrf = $this->post['csrf'];
        if ($this->request->method() === Request::POST && Security::is_token($csrf))
        {

            $this->ajax_data(
                View::factory('admin/html/listeners', compact('list_users'))->render()
            );
        }
    }


}