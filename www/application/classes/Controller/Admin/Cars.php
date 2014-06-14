<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cars extends Controller_Admin_Base
{
    protected $_group = null;

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $cars = ORM::factory('Transport')
            ->order_by('id', 'desc')
            ->find_all();
        $staffs = Model::factory('Office')->getStaffs('инструктор');

        $this->template->content = View::factory('admin/other/car', compact('cars', 'staffs'));
    }

    public function action_getCar()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $id = $this->request->post('id');

            $result = ORM::factory('Transport', $id);

            $data = $result->as_array();

            $data['doc_data_reg'] = Text::check_date($data['doc_data_reg']);

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

            $id = $post['car_id'];

            unset($post['csrf'], $post['car_id']);

            $post['doc_data_reg'] =  Text::getDateUpdate($post['doc_data_reg']);

            try
            {
                $query = DB::update('transport')
                    ->set($post)
                    ->where('id', '=', $id)
                    ->execute();

                $this->ajax_msg('Данные успешно сохранены');
            }
            catch(Database_Exception $e)
            {
                $this->ajax_msg('<strong>Данные машины:</strong> '.$e->getMessage(), 'error');
            }

        }
    }

    public function action_add()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        /*        $post = $this->request->post();
                $this->ajax_data($post);

                exit;*/

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();

            $id = $post['car_id'];

            unset($post['csrf'], $post['car_id']);

            $query = array();

            $post['doc_data_reg'] =  Text::getDateUpdate($post['doc_data_reg']);

            try
            {
                $query = DB::insert('transport')
                    ->columns(array_keys($post))
                    ->values($post)
                    //->where('user_id', '=', $id)
                    ->execute();

                $this->ajax_data(array(
                    'id' => $query[0],
                    'name' => $post['name']
                ), 'Группа успешно добавлена');

            }
            catch(Database_Exception $e)
            {
                $this->ajax_msg('<strong>Данные машины:</strong> '.$e->getMessage(), 'error');
            }

        }
    }



}