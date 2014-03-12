<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Staff_group extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'staff_group';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'staff_id' => array('data_type' => 'int', 'is_nullable' => false),
		'group_id' => array('data_type' => 'int', 'is_nullable' => false),
	);

    protected $_belongs_to = array(
        'group' => array(
            'model' => 'Groups',
            'foreign_key' => 'group_id',
        )
    );

    public function rules()
    {
        return array(
            'staff_id' => array(
                array('not_empty'),
                array('digit')
            ),
            'group_id' => array(
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