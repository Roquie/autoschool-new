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

            unset($post['instructors']);

            try
            {
                ORM::factory('Group', $post['group_id'])
                    ->values(/*array(
                        'name' => $post['name'],
                        'data_start' => $post['data_start'],
                        'data_end' => $post['data_end'],
                        'pdd_teacher' => $post['pdd_teacher'],
                        'tyto_teacher' => $post['tyto_teacher'],
                        'med_teacher' => $post['med_teacher']
                    )*/$post)
                    ->update();
            }
            catch (ORM_Validation_Exception  $e)
            {
                $errors = $e->errors('validation');
                $error = array_shift($errors);
                $this->ajax_msg($error, 'error');
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


            $this->ajax_msg('Данные успешно сохранены');

            //$this->ajax_data($post);
        }
    }

    //Cannot add or update a child row: a foreign key constraint fails (`melnik5g_rqmpt`.`listeners`, CONSTRAINT `listeners_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)) [ UPDATE `listeners` SET `number_contract` = 'wer', `date_contract` = '2014-05-13', `group_id` = 'NULL', `famil` = 'Блядович', `imya` = 'Лооол', `otch` = 'Гг', `tel` = '8 (986) 278-41-54', `mesto_raboty` = NULL, `mesto_rojdeniya` = 'Мухосранск', `nationality_id` = '1', `education_id` = '1', `data_rojdeniya` = '1970-01-01', `sex` = '1', `seriya_med` = NULL, `nomer_med` = NULL, `data_med` = '1970-01-01', `kem_vydana_med` = NULL, `region` = NULL, `rion` = NULL, `nas_pynkt` = NULL, `street` = NULL, `dom` = NULL, `korpys` = NULL, `kvartira` = NULL, `document_id` = '1', `document_seriya` = NULL, `document_nomer` = NULL, `document_kem_vydan` = NULL, `document_data_vydachi` = '1970-01-01', `certificate_seriya` = NULL, `certificate_nomer` = NULL WHERE `user_id` = '39' ]


}