<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_Edu extends Controller_Admin_Other_Base
{


    public function action_index()
    {
        $edu = ORM::factory('Education')
                  ->order_by('id', 'desc')
                  ->find_all();

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            unset($post['csrf']);
            try
            {
                ORM::factory('Education')
                    ->values($post)
                    ->create();

                HTTP::redirect('/admin/other/edu');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $error = array_shift($errors);
            }
        }

        $this->_other->content = View::factory('admin/other/edu', compact('edu', 'error'));
    }

    /**
     * Удаление образования
     */
    public function action_remove()
    {
        $csrf = pack('H*', $this->request->query('csrf'));

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');

            $nat = ORM::factory('Education', $id);

            if ($nat->loaded())
            {
                $nat->delete();
                HTTP::redirect('/admin/other/edu');
            }
            else
            {
                $error = Kohana::message('validation', 'edu_not_found');
            }
        }

        $this->_other->content = View::factory('admin/other/edu', compact('edu', 'error'));
    }



}