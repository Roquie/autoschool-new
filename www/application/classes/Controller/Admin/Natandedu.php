<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Natandedu extends Controller_Admin_Base
{

    protected $_nat_and_edu = null;

    /**
     * Отображение страницы
     */
    public function before()
    {
        parent::before();

        $edu = ORM::factory('Educations')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $this->_nat_and_edu = View::factory('admin/html/data/nat_and_ed', compact('edu', 'national'));
        $this->_nat_and_edu->errors = null;
    }

    /**
     * Главная страница
     */
    public function action_index() {}

    /**
     * Добавления гражданства
     */
    public function action_create_nat()
    {
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();
            unset($post['csrf']);

            try
            {
                ORM::factory('Nationality')
                    ->values($post)
                    ->create();

                HTTP::redirect('/admin/other/natandedu');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $this->_nat_and_edu->errors = $e->errors('validation');
            }
        }
    }

    /**
     * Удаление гражданства
     */
    public function action_delete_nat()
    {
        $csrf = $this->request->query('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');

            $nat = ORM::factory('Nationality', $id);

            if ($nat->loaded())
            {
                $nat->delete();
                HTTP::redirect('/admin/other/natandedu');
            }
            else
            {
                $this->_nat_and_edu->errors = Kohana::message('validation', 'nat_not_found');
            }
        }
    }

    /**
     * Добавления образования
     */
    public function action_create_edu()
    {
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();
            unset($post['csrf']);
            try
            {
                ORM::factory('Educations')
                    ->values($post)
                    ->create();

                HTTP::redirect('/admin/other/natandedu');
            }
            catch (ORM_Validation_Exception  $e)
            {
                $this->_nat_and_edu->errors = $e->errors('validation');
            }
        }
    }

    /**
     * Удаление образования
     */
    public function action_delete_edu()
    {
        $csrf = $this->request->query('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::GET)
        {
            $id = $this->request->query('id');

            $nat = ORM::factory('Educations', $id);

            if ($nat->loaded())
            {
                $nat->delete();
                HTTP::redirect('/admin/other/natandedu');
            }
            else
            {
                $this->_nat_and_edu->errors = Kohana::message('validation', 'edu_not_found');
            }
        }
    }

    public function after()
    {
        $this->template->content = $this->_nat_and_edu->render();
        parent::after();
    }


}