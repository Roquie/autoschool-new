<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Exam extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Exam';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_group' => array('data_type' => 'int', 'is_nullable' => false),
		'predsedatel' => array('data_type' => 'string', 'is_nullable' => false),
		'sekretar' => array('data_type' => 'string', 'is_nullable' => false),
		'number_protocol' => array('data_type' => 'string', 'is_nullable' => false),
		'date_protocol' => array('data_type' => 'string', 'is_nullable' => false),
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