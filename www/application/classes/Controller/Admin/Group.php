<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Group extends Controller_Admin_Base
{

    public function action_index()
    {
        $groups = Model::factory('Group')->find_all(); // список всех групп
        $staffs = Model::factory('Office')->getStaffs(array(
               'instructors' => 'инструктор',
               'teachers' => 'преподаватель'
        ));

        $category = Model::factory('Category')->find_all();
        $this->template->content = View::factory('admin/group', compact('groups', 'staffs', 'category'));
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

            $instructors = (isset($post['instructors'])) ? $this->clear_array($post['instructors']) : null;

            $lessons = (isset($post['lessons'])) ? $this->clear_array($post['lessons']) : null;

            $id = $post['group_id'];

            unset($post['instructors'], $post['lessons'], $post['csrf'], $post['group_id']);

            foreach ($post as $key => $value) {
                if ($value == '')
                    $post[$key] = NULL;
            }

            $post['data_start'] =  Text::getDateUpdate($post['data_start']);
            $post['data_end'] =  Text::getDateUpdate($post['data_end']);

            $valid = new Validation(
                Arr::map(
                    'Security::xss_clean',
                    Arr::map('trim', $post)
                )
            );
            $valid->rule('name', 'not_empty');

            if ($valid->check())
            {
                $query = array();
                try
                {
                    $query = DB::update('groups')
                        ->set($post)
                        ->where('id', '=', $id)
                        ->execute();
                }
                catch(Database_Exception $e)
                {
                    $this->ajax_msg('<strong>Данные группы:</strong> '.$e->getMessage(), 'error');
                }

                $staff_group = ORM::factory('StaffGroup')
                    ->where('group_id', '=', $id)
                    ->find_all();

                foreach($staff_group as $option)
                {
                    $option->delete();
                }

                if (!empty($instructors))
                {
                    try
                    {

                        foreach ($instructors as $key => $value)
                        {
                            ORM::factory('StaffGroup')
                                ->values(array(
                                              'group_id' => $id,
                                              'staff_id' => $value
                                         ))->create();
                        }
                    }
                    catch (ORM_Validation_Exception  $e)
                    {
                        $errors = $e->errors('validation');
                        $error = array_shift($errors);
                        $this->ajax_msg('<strong>Данные группы:</strong> '.$error, 'error');
                    }
                }

                $timelessons = ORM::factory('Timelessons')
                    ->where('group_id', '=', $id)
                    ->find_all();

                foreach($timelessons as $option)
                {
                    $option->delete();
                }

                if (!empty($lessons))
                {
                    try
                    {
                        foreach ($lessons as $key => $value)
                        {
                            $value['group_id'] = $id;
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
                }

                $this->ajax_msg('Данные успешно сохранены');

            }
            else
            {
                $errors = $valid->errors('validation');
                $this->ajax_msg(array_shift($errors), 'error');
            }

        }
    }

    public function action_add()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        /*        $post = $this->request->post();
                $this->ajax_data($this->clear_array($post));
                exit;*/


        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();

            $instructors = (isset($post['instructors'])) ? $this->clear_array($post['instructors']) : null;

            $lessons = (isset($post['lessons'])) ? $this->clear_array($post['lessons']) : null;

            unset($post['instructors'], $post['lessons'], $post['csrf'], $post['group_id']);

            foreach ($post as $key => $value) {
                if ($value == '')
                    $post[$key] = NULL;
            }

            $group = ORM::factory('Group')->isset_group($post['name']);

            if (!count($group))
            {
                $post['data_start'] =  Text::getDateUpdate($post['data_start']);
                $post['data_end'] =  Text::getDateUpdate($post['data_end']);

                $valid = new Validation(
                    Arr::map(
                        'Security::xss_clean',
                        Arr::map('trim', $post)
                    )
                );
                $valid->rule('name', 'not_empty');

                if ($valid->check())
                {
                    $query = array();
                    try
                    {
                        $query = DB::insert('groups')
                            ->columns(array_keys($post))
                            ->values($post)
                            //->where('user_id', '=', $id)
                            ->execute();
                    }
                    catch(Database_Exception $e)
                    {
                        $this->ajax_msg($e->getMessage(), 'error');
                    }

                    if (!empty($instructors))
                    {
                        foreach ($instructors as $key => $value)
                        {
                            ORM::factory('StaffGroup')
                                ->values(array(
                                  'group_id' => $query[0],
                                  'staff_id' => $value
                            ))->create();
                        }
                    }

                    if (!empty($lessons))
                    {
                        foreach ($lessons as $key => $value)
                        {
                            $value['group_id'] = $query[0];
                            ORM::factory('Timelessons')
                                ->values($value)
                                ->create();
                        }
                    }

                    $this->ajax_data(array(
                          'id' => $query[0],
                          'name' => $post['name']
                    ), 'Группа успешно добавлена');
                }
                else
                {
                    $errors = $valid->errors('validation');
                    $this->ajax_msg(array_shift($errors), 'error');
                }

            }
            else
            {
                $this->ajax_msg('Группа с таким названием уже существует', 'error');
            }

            //$this->ajax_msg(, 'error');
        }
    }

    public function action_del_group()
    {
        $csrf = pack('H*', $this->request->query('csrf'));

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');

            ORM::factory('Group', $id)->delete();

            $this->msg('Группа удалена', 'success', 'admin/group');
        }
        else
            throw new HTTP_Exception_403('access denied');

    }

    private function clear_array($arr)
    {
        foreach ($arr as $key => $value)
        {
            if (is_array($value))
            {
                $arr[$key] = $this->clear_array($value);
            }
            else if (empty($value))
            {
                unset($arr[$key]);
            }
        }
        return array_filter($arr);
    }


}