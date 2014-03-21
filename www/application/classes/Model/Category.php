<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'category';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'name' => array('data_type' => 'string', 'is_nullable' => false),
    );

    protected $_has_one = array(
        'category_prav' => array(
            'model' => 'Category_prav',
            'foreign_key' => 'category_id',
        )
    );

    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 1)),
                array('max_length', array(':value', 1))
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