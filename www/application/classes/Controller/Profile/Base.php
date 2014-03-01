<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Base extends Controller_Template
{
    public $template = 'main/layout';


    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('user'))
        {
            throw new HTTP_Exception_404();
        }

        $a = Auth::instance();
        $user = ORM::factory('User', $a->get_user()->id);

        $mergered = array_merge(
            $a->get_user()->as_array(),
            $user->statement->as_array()
        );

        View::bind_global('user', $mergered);

        $this->template->title = 'profile index';
        $this->template->description = 'profile';
        $this->template->navbar = View::factory('main/navbar');
        $this->template->content = null;
        $this->template->footer = View::factory('main/footer');


    }


}