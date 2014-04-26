<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Messages extends Controller_Admin_Base
{

    public function before()
    {
        parent::before();

        $no_ajax = array(
            'Index'
        );

        if (!in_array($this->request->action(), $no_ajax))
        {
            $post = $this->request->post();
            $this->auto_render = false;

            if (!Request::initial()->is_ajax() && !Security::is_token($post['csrf']))
                throw new HTTP_Exception_404();
        }

    }

    public function action_index()
    {
        $list_users = Model::factory('User')->get_user_list(false, true);
        $list_groups = Model::factory('Groups')->find_all();

        $this->template->content = View::factory('admin/messages/index', compact('list_users', 'list_groups'));
    }

    public function action_users_by_group()
    {
        $post = $this->request->post();
        $u = new Model_User();

        $list_users =
            ($post['group_id'] == 0)
            ? $u->get_user_list(false)
            : $u->by_group_id($post['group_id']);

        $this->ajax_data(
            View::factory('admin/html/listeners', compact('list_users'))->render()
        );
    }

    public function action_get_messages()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('user_id');

            $listener = ORM::factory('Listeners', $id);

            $messages = $listener->getMessage();

            $profile = false;

            $admin_avatar = Kohana::$config->load('settings.admin_avatar');

            $this->ajax_data(
                View::factory('admin/html/messages', compact('messages', 'listener' , 'profile', 'admin_avatar'))->render()
            );
        }

    }

    public function action_add_message()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();
            //fix xss
            $post = Arr::map('Security::xss_clean',
                Arr::map('trim', $this->request->post())
            );

            unset($post['csrf']);

            try
            {
                ORM::factory('Messages')->values($post)->create();
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');

                $this->ajax_msg(array_shift($errors), 'error');
            }

            $admin_avatar = Kohana::$config->load('settings.admin_avatar');

            $this->ajax_data(
                View::factory('admin/html/message', compact('post', 'admin_avatar'))->render(),
                'Сообщение отправлено'
            );
        }

    }


}