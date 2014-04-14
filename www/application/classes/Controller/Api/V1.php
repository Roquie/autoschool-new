<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_V1 extends Controller
{


    public function action_test()
    {
        $post = $this->request->post();

        $this->ajax_msg($post);
    }


}
