<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Natandedu extends Controller_Admin_Base
{

    /**
     * Отображение страницы (чтоб не повторять код)
     * @param null $errors
     */
    private function view($errors = null)
    {
        $edu = ORM::factory('Educations')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $this->template->content =
            View::factory('admin/html/data/nat_and_ed', compact('edu', 'national', 'errors'));
    }

    /**
     * Главная страница
     */
    public function action_index()
    {
        $this->view();
    }

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
                $errors = $e->errors('validation');
                $this->view($errors);
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
                $errors = Kohana::message('validation', 'nat_not_found');
                $this->view($errors);
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
                $errors = $e->errors('validation');
                $this->view($errors);
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
                $errors = Kohana::message('validation', 'edu_not_found');
                $this->view($errors);
            }
        }
    }


}