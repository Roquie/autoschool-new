<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Instructor_group extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Instructor_group';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_group' => array('data_type' => 'int', 'is_nullable' => false),
		'id_employee' => array('data_type' => 'int', 'is_nullable' => false),
	);

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