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

                $this->msg('Образование добавлено');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
            }
        }

        $this->_other->content = View::factory('admin/other/edu', compact('edu'));
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

            $edu = ORM::factory('Education', $id);

            if ($edu->loaded())
            {
                $edu->delete();
                $this->msg('Образование '.$edu->name.' удалено', 'danger', 'admin/other/edu');
            }
            else
            {
                $this->msg(Kohana::message('validation', 'edu_not_found'), 'danger', 'admin/other/edu');
            }
        }

        $this->_other->content = View::factory('admin/other/edu');
    }



}