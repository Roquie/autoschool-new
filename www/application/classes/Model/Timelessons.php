<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Timelessons extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Timelessons';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_group' => array('data_type' => 'int', 'is_nullable' => false),
		'id_lesson' => array('data_type' => 'int', 'is_nullable' => false),
		'day_of_week' => array('data_type' => 'string', 'is_nullable' => true),
		'time_start' => array('data_type' => 'string', 'is_nullable' => true),
		'time_end' => array('data_type' => 'string', 'is_nullable' => true),
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