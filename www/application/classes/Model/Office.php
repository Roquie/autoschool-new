<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Office extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'office';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'name' => array('data_type' => 'string', 'is_nullable' => false),
    );

    protected $_has_many = array(
        'staff' => array(
            'model' => 'Staff',
            'through' => 'office_staff'
        ),

    );

    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 90)),
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