<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Createdocs_Index extends Controller_Admin_Base
{
    protected $_createdocs = null;

    public function before()
    {
        parent::before();


        $this->_createdocs = new View('admin/createdocs/template');
        $this->_createdocs->content = null;
    }


    public function action_contract()
    {

        $this->_createdocs->content =
            View::factory('admin/createdocs/contract', compact('Nationality', 'Educations'));
    }

    public function action_index()
	{
        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();

        $this->_createdocs->content =
            View::factory('admin/createdocs/index', compact('national', 'type_doc', 'edu'));
	}

    public function after()
    {
        $this->template->content = $this->_createdocs->render();
        parent::after();
    }
}