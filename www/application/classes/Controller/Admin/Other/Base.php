<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Other_Base extends Controller_Admin_Base
{
    protected $_other = null;

    public function before()
    {
        parent::before();

        $menu = array(
            'national' => 'Гражданство',
            'edu' => 'Образование',
            'office' => 'Должность',
            'group' => 'Группы'
        );

        $this->_other = View::factory('admin/other/template', compact('menu'));
        $this->_other->content = null;
    }

    public function action_index()
    {
        HTTP::redirect('admin/other/national');
        /*$this->response->body(
            Request::factory('/admin/other/national')->execute()
        );*/
    }


        public function after()
    {
        $this->template->content = $this->_other->render();
        parent::after();
    }


}