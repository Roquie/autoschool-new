<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_Office extends Controller_Admin_Other_Base
{


    public function action_index()
    {
        $office = ORM::factory('Office')
                  ->order_by('id', 'desc')
                  ->find_all();

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            unset($post['csrf']);
            try
            {
                ORM::factory('Office')
                    ->values($post)
                    ->create();

                HTTP::redirect('/admin/other/office');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $error = array_shift($errors);
            }
        }

        $this->_other->content = View::factory('admin/other/office', compact('office', 'error'));
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

            $nat = ORM::factory('Office', $id);

            if ($nat->loaded())
            {
                $nat->delete();
                HTTP::redirect('/admin/other/office');
            }
            else
            {
                $error = Kohana::message('validation', 'edu_not_found');
            }
        }

        $this->_other->content = View::factory('admin/other/office', compact('office', 'error'));
    }



}