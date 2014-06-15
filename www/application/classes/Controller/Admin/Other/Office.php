<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_Office extends Controller_Admin_Other_Base
{


    public function action_index()
    {

        $a = Auth::instance();
        $admin = $a->get_user();

        $info = ORM::factory('User', $admin->id)->admin;

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

                $this->msg('Должность добавлена');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $this->msg(array_shift($errors), 'danger');
            }
        }

        $this->_other->content = View::factory('admin/other/office', compact('office', 'info'));
    }

    /**
     * Удаление должности
     */
    public function action_remove()
    {
        $csrf = pack('H*', $this->request->query('csrf'));

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');

            try
            {
                $of = ORM::factory('Office', $id);

                if ($of->loaded())
                {
                    $of->delete();
                    $this->msg('Должность '.$of->name.' удалена', 'danger', 'admin/other/office');
                }
                else
                {
                    $this->msg(Kohana::message('validation', 'office_not_found'), 'success', 'admin/other/office');
                }
            }
            catch (Database_Exception $e)
            {
                $this->msg('Ошибка удаления. Возможно имеются связанные данные.', 'danger', 'admin/other/office');
            }
        }

        $this->_other->content = View::factory('admin/other/office', compact('office'));
    }



}