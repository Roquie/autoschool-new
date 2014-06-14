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

        $mergered = array_merge
        (
            $a->get_user()->as_array(),
            $user->listener->as_array()
        );

        Session::instance()->set('checked_user', $a->get_user()->id);

        View::bind_global('user', $mergered);

        $styles = array(
            URL::site('public/global/css/bstrap.html5b.fawesome.min.css'),
            URL::site('public/main/css/validation.css'),
            URL::site('public/global/css/pageslide.css'),
            URL::site('public/global/css/twitter.css'),
            URL::site('public/global/css/datepicker.css'),
            URL::site('public/main/css/main.css'),
            URL::site('public/main/css/flexslider.css'),
        );

        View::set_global('message', Session::instance()->get_once('message'));
        View::set_global('message_type', Session::instance()->get_once('message_type'));

        $this->template->styles = $styles;

        $this->template->title = 'Профиль. Автошкола МПТ.';
        $this->template->description = 'Офигенное описание, это же профиль в Автошколе МПТ!!!!';
        $this->template->navbar = View::factory('main/navbar');
        $this->template->content = null;
        $this->template->footer = View::factory('main/footer');


    }


}