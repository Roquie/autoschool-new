<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_Group extends Controller_Admin_Other_Base
{

    public function action_index()
    {
        $groups = Model::factory('Group')->find_all(); // список всех групп
        $staffs = Model::factory('Office')->getStaffs(array(
            'instructors' => 'инструктор',
            'teachers' => 'преподаватель'
        ));
        $this->_other->content = View::factory('admin/other/group', compact('groups', 'staffs'));
    }

    public function action_getGroup()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('id');

            $result = ORM::factory('Group', $id);

            $data = $result->as_array();


            /**
             * Инструктора группы
             */
            $staffs = $result->staff->find_all();

            foreach ($staffs as $key => $value) {
                $data['instructors'][] = $value->id;
            }

            /**
             * Расписание занятий
             */
            $staffs = $result->timelessons->find_all();

            foreach ($staffs as $key => $value) {
                $data['lessons'][] = $value->as_array();
            }

            $data['data_start'] = Text::check_date($data['data_start']);
            $data['data_end'] = Text::check_date($data['data_end']);

            $this->ajax_data($data);
        }
    }

    public function action_edit()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

/*        $post = $this->request->post();
        $this->ajax_data($post);

        exit;*/

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();

            $instructors = $post['instructors'];

            $lessons = $post['lessons'];

            unset($post['instructors'], $post['lessons']);

            try
            {
                ORM::factory('Group', $post['group_id'])
                    ->values($post)
                    ->update();
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $error = array_shift($errors);
                $this->ajax_msg('<strong>Данные группы:</strong> '.$error, 'error');
            }

            $staff_group = ORM::factory('StaffGroup');

            foreach($staff_group->find_all() as $option)
            {
                $option->delete();
            }

            foreach ($instructors as $key => $value)
            {
                ORM::factory('StaffGroup')
                    ->values(array(
                        'group_id' => $post['group_id'],
                        'staff_id' => $value
                    ))->create();
            }

            try
            {
                $timelessons = ORM::factory('Timelessons')
                                    ->where('group_id', '=', $post['group_id'])
                                    ->find_all();

                foreach($timelessons as $option)
                {
                    $option->delete();
                }

                foreach ($lessons as $key => $value)
                {
                    $value['group_id'] = $post['group_id'];
                    ORM::factory('Timelessons')
                        ->values($value)
                        ->create();
                }

            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $error = array_shift($errors);
                $this->ajax_msg('<strong>Раписание занятий:</strong> '.$error, 'error');
            }

            $this->ajax_msg('Данные успешно сохранены');
        }
    }

    public function action_add()
    {

    }


}