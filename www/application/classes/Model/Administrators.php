<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Administrators extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'administrators';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'first_name' => array('data_type' => 'string', 'is_nullable' => false),
        'family_name' => array('data_type' => 'string', 'is_nullable' => false),
        'timestamp' => array('data_type' => 'string', 'is_nullable' => false),
        'user_id' => array('data_type' => 'int', 'is_nullable' => false),
        'is_root' => array('data_type' => 'int', 'is_nullable' => false)
    );


    public function rules()
    {
        return array(
            'family_name' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
            ),
            'first_name' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
            ),
            'user_id' => array(
                array('digit')
            ),
        );
    }

    public function labels()
    {
        return array(
            'first_name' => 'Поле "имя"',
            'family_name' => 'Поле "фамилия"',
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