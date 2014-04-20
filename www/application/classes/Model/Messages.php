<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Messages extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'messages';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'listener_id' => array('data_type' => 'int', 'is_nullable' => false),
        'message' => array('data_type' => 'string', 'is_nullable' => false),
        'admin' => array('data_type' => 'int', 'is_nullable' => true),
        'datetime' => array('data_type' => 'string', 'is_nullable' => false),
    );

    public function rules()
    {
        return array(
            'message' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 130)),
            ),
            'user_id' => array(
                array('digit'),
            ),
            'admin' => array(
                array('digit'),
            ),

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