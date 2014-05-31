<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Base extends Controller_Template
{
    public $template = 'admin/layout';

    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('admin') && (Request::initial() === Request::current()))
        {
            //throw new HTTP_Exception_404();
            HTTP::redirect('users/login');
        }

        $a = Auth::instance();
        $admin = $a->get_user();

        $info = ORM::factory('User', $admin->id)->admin;

        $id = Session::instance()->get('checked_user');

        $user = ORM::factory('User', $id)->listener;
        $user->loaded()
            ? $checked_user = Text::format_name($user->famil, $user->imya, $user->otch)
            : $checked_user = '"Не выбрано."';

        $gr_name = ORM::factory('User', $id)->listener->group->name;

        !empty($gr_name) ? $gr_name : '"Не выбрано"';

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Group')->find_all();

        View::set_global('list_users', $list_groups);
        View::set_global('list_groups', $list_groups);

        if (!empty($id))
        {
            $group_id = ORM::factory('User', $id)->listener->group->id;
            $g = new Model_Group($group_id);

            View::set_global('list_checked_listeners', $g->listener->find_all());
        }

        View::set_global('checked_user', $checked_user);
        View::set_global('checked_user_group', $gr_name);

        $this->template->title = 'Администратор "МПТ Автошкола"';
        $this->template->navbar = View::factory('admin/navbar', compact('admin', 'info'));
        $this->template->description = 'Main';
        $this->template->content = null;


    }


}