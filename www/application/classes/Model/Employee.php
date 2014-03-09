<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Employee extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Employee';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_auto' => array('data_type' => 'int', 'is_nullable' => true),
		'famil' => array('data_type' => 'string', 'is_nullable' => true),
		'imya' => array('data_type' => 'string', 'is_nullable' => true),
		'otch' => array('data_type' => 'string', 'is_nullable' => true),
		'address' => array('data_type' => 'string', 'is_nullable' => true),
		'tel' => array('data_type' => 'string', 'is_nullable' => true),
		'data' => array('data_type' => 'string', 'is_nullable' => true),
		'pol' => array('data_type' => 'int', 'is_nullable' => false),
		'nomer_prav' => array('data_type' => 'string', 'is_nullable' => true),
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