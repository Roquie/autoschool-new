<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_News extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'News';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'title' => array('data_type' => 'string', 'is_nullable' => false),
		'message' => array('data_type' => 'string', 'is_nullable' => false),
		'group_id' => array('data_type' => 'int', 'is_nullable' => false),
	);

    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 5)),
                array('max_length', array(':value', 50)),
            ),
            'message' => array(
                array('not_empty'),
                array('min_length', array(':value', 5)),
                array('max_length', array(':value', 3000)),
            ),
            'group_id' => array(
                array('digit'),
                array(array($this, 'check_group'), array(':value'))
            )
        );
    }

    public function check_group($id)
    {
       // $admin = ORM::factory('Administrators')->where('email', '=', $email)->find();
      //  return (bool)!$admin->email;
        $result = ORM::factory('Groups')->where('id', '=', $id)->find();
        return (bool)$result->id;
    }

    public function labels()
    {
        return array(
            'title' => 'Заголовок',
            'message' => 'Текс сообщения',
            'group_id' => 'id группы'
        );
    }

    public function filters()
    {
        return array(
            true => array(
                array('trim'),
                array('Security::xss_clean', array(':value')),
            )
        );
    }

}