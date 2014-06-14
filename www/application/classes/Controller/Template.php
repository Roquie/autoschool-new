<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template
{
/*
    public function action_before()
    {
        parent::before();

        View::bind_global('message', Session::instance()->get_once('message'));
        View::bind_global('message_type', Session::instance()->get_once('message_type'));
    }*/

    /**
     * @param        $text
     * @param string $type
     *
     * @param null   $redirect_url
     *
     * @return bool
     */
    public function msg($text, $type = 'success', $redirect_url = null)
    {
        Session::instance()
               ->set('message', $text)
               ->set('message_type', $type);


        HTTP::redirect(
            !$redirect_url ? $this->request->current()->url() : $redirect_url, 303
        );

        return true;
    }

}
