<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Base extends Controller_Template
{
    public $template = 'main/layout';

    public function before()
    {
        parent::before();

        $styles = array(
            URL::site('public/global/css/bstrap.html5b.fawesome.min.css'),
            URL::site('public/main/css/validation.css'),
            URL::site('public/global/css/pageslide.css'),
            URL::site('public/global/css/twitter.css'),
            URL::site('public/global/css/datepicker.css'),
            URL::site('public/main/css/main.css'),
            URL::site('public/main/css/flexslider.css'),
        );

        $this->template->styles = $styles;

        $this->template->title = 'МПТ Автошкола';
        $this->template->navbar = View::factory('main/navbar');
        $this->template->description = 'Main';
        $this->template->content = null;
        $this->template->footer = View::factory('main/footer');
    }


}