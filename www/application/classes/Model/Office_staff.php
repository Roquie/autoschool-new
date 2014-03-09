<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Office_staff extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Office_staff';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_office' => array('data_type' => 'int', 'is_nullable' => false),
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