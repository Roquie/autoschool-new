<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template
{

    public function action_before()
    {
        parent::before();

        View::bind_global('message', Session::instance()->get_once('message'));
        View::bind_global('message_type', Session::instance()->get_once('message_type'));
    }

    /**
     * @param        $text
     * @param string $type
     *
     * @return bool
     */
    public function msg($text, $type = 'success')
    {
        Session::instance()
               ->set('message', $text)
               ->set('message_type', $type);


        HTTP::redirect(
            $this->request->current()->url()
        );

        return true;
    }

}
