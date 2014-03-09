<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Aboutus extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Aboutus';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'name' => array('data_type' => 'string', 'is_nullable' => false),
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