<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Comissioners extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'comissioners';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'famil' => array('data_type' => 'string', 'is_nullable' => false),
        'imya' => array('data_type' => 'string', 'is_nullable' => false),
        'otch' => array('data_type' => 'string', 'is_nullable' => false),
    );

    public function rules()
    {
        return array(
            'famil' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
            ),
            'imya' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
            ),
            'otch' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
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