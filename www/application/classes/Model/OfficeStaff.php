<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_OfficeStaff extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'office_staff';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'office_id' => array('data_type' => 'int', 'is_nullable' => false),
        'staff_id' => array('data_type' => 'int', 'is_nullable' => false),
    );

    public function rules()
    {
        return array(
            'office_id' => array(
                array('not_empty'),
                array('digit')
            ),
            'staff_id' => array(
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