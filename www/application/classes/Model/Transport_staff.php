<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Transport_staff extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'transport_staff';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'transport_id' => array('data_type' => 'int', 'is_nullable' => false),
		'staff_id' => array('data_type' => 'int', 'is_nullable' => false),
	);

    public function rules()
    {
        return array(
            'staff_id' => array(
                array('not_empty'),
                array('digit')
            ),
            'transport_id' => array(
                array('not_empty'),
                array('digit')
            )
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