<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Base extends Controller_Template
{
    public $template = 'admin/layout';

    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('admin'))
        {
            throw new HTTP_Exception_404();
        }


        $a = Auth::instance();
        $admin = $a->get_user();

        $info = ORM::factory('Administrators')->where('user_id', '=', $admin->id)->find();

        $this->template->title = 'Администратор "МПТ Автошкола"';
        $this->template->navbar = View::factory('admin/navbar', compact('admin', 'info'));
        $this->template->description = 'Main';
        $this->template->content = null;


    }


}