<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_National extends Controller_Admin_Other_Base
{

    public function action_index()
    {
        $national = ORM::factory('Nationality')
                       ->order_by('id', 'desc')
                       ->find_all();

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            unset($post['csrf']);

            try
            {
                ORM::factory('Nationality')
                   ->values($post)
                   ->create();

                $this->msg('Гражданство добавлено');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
            }
        }

        $this->_other->content = View::factory('admin/other/nat', compact('national'));
    }

    /**
     * Удаление гражданства
     */
    public function action_remove()
    {
        $csrf = pack('H*', $this->request->query('csrf'));

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');
            $nat = ORM::factory('Nationality', $id);

            if ($nat->loaded())
            {
                $nat->delete();
                $this->msg('Гражданство '.$nat->name.' удалено', 'success', 'admin/other/national');
            }
            else
            {
                $this->msg(Kohana::message('validation', 'nat_not_found'), 'danger', 'admin/other/national');
            }
        }

        $this->_other->content = View::factory('admin/other/nat');
    }


}