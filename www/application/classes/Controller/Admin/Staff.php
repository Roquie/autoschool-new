<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Staff extends Controller_Admin_Base
{

    public function action_index()
    {
        $type_doc = ORM::factory('Documents')->find_all();

        $office = new Model_Office();


        $this->template->content =
            View::factory('admin/staff/index', compact('list_groups', 'edu', 'national', 'type_doc'))
                ->set('positions', $office->find_all())
                ->set('list_staff', $this->_get_names_staffs());
    }

    /**
     * фильт по должностям
     */
    public function action_position_filter()
    {
        $this->auto_render = false;

        $post = $this->request->post();

        if ($this->request->method() === Request::POST && Security::is_token($post['csrf']))
        {

            $list_staff = array();

            if ($post['position_id'] == 0)
            {
                $list_staff = $this->_get_names_staffs();
            }
            else
            {
                $office = new Model_Office($post['position_id']);
                $humans = $office->staff->find_all();

                foreach ($humans as $key => $value)
                {
                    $list_staff[$value->id] = Text::format_name($value->famil, $value->imya, $value->otch);
                }
            }

            $this->ajax_data(
                View::factory('admin/html/staff', compact('list_staff'))->render()
            );
        }

    }

    protected function _get_names_staffs()
    {
        $staff = new Model_Staff();
        $staffs = $staff->find_all();

        $names = array();

        if ($staffs->count() > 0)
        {
            foreach ($staffs as $key => $value)
            {
                $names[$value->id] = Text::format_name($value->famil, $value->imya, $value->otch);
            }

            return $names;
        }

        return false;
    }

    /**
     * инфа о сотруднике
     */
    public function action_get_info()
    {
        $this->auto_render = false;

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $staff = new Model_Staff($post['staff_id']);
            $position = $staff->office->find_all();

            $data = $staff->as_array();

            if ($position->count() > 0)
            {
                foreach ($position as $k =>$v)
                {
                    $office_staff_id = $v->id;
                }

                //$data['office_staff_id'] = $office_staff_id;
            }

            $data['document_data_vydachi'] = Text::check_date($data['document_data_vydachi']);

            $this->ajax_data($data);
        }
    }

    public function action_to_update()
    {
        $this->auto_render = false;

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $post['document_data_vydachi'] = Text::getDateUpdate($post['document_data_vydachi']);
            if (isset($post['vrem_reg']))
            {
                $post['vrem_reg'] = 1;
            }
            else
            {
                $post['vrem_reg'] = 0;
            }

            try
            {
                $staff = new Model_Staff( (int)$post['update_staff_id'] );
                unset($post['csrf'], $post['update_staff_id']);

                $staff->values($post);
                $staff->update();

                $this->ajax_msg('Данные успешно обновлены');
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->ajax_msg(array_shift($errors), 'error');
            }
        }
    }

    public function action_create()
    {
        $this->auto_render = false;

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $post['document_data_vydachi'] = Text::check_date($post['document_data_vydachi']);

            if (isset($post['vrem_reg']))
            {
                $post['vrem_reg'] = 1;
            }
            else
            {
                $post['vrem_reg'] = 0;
            }

            unset($post['csrf'], $post['update_staff_id']);
            try
            {
                if (isset($post['position_id']) && $post['position_id'] != 0)
                {
                    $staff = new Model_Staff();
                    $staff->values($post);
                    $staff->create();

                    $staff->add('office', $post['position_id']);

                    $this->ajax_msg('Сотрудник добавлен с присвоением должности ...');
                }
                else
                {
                    $staff = new Model_Staff();
                    $staff->values($post);
                    $staff->create();

                    $this->ajax_msg('Сотрудник добавлен');
                }


            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->ajax_msg(array_shift($errors), 'error');
            }
        }
    }

    public function action_remove()
    {
        $this->auto_render = false;

        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $staff = new Model_Staff($post['staff_id']);

            if ($staff->loaded())
            {
                $staff->delete();

                $this->ajax_msg('Сотрудник удален');
            }
            else
            {
                $this->ajax_msg('Сотрудник не найден', 'error');
            }
        }
    }






}