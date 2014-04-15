<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_V1 extends Controller
{


    public function action_test()
    {
        $post = $this->request->post();

        $this->response->body(
            var_export(
                $post
                    ? $post
                    : 'post is empty'
            )
        );
    }


}
