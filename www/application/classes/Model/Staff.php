<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Staff extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'staff';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'imya' => array('data_type' => 'string', 'is_nullable' => false),
		'famil' => array('data_type' => 'string', 'is_nullable' => false),
		'otch' => array('data_type' => 'string', 'is_nullable' => false),
		'adres' => array('data_type' => 'string', 'is_nullable' => false),
		'tel' => array('data_type' => 'string', 'is_nullable' => false),
		'data' => array('data_type' => 'string', 'is_nullable' => false),
		'sex' => array('data_type' => 'int', 'is_nullable' => false),
		'nomer_prav' => array('data_type' => 'string', 'is_nullable' => false),
	);

    protected $_has_one = array(
        'category_prav' => array(
            'model' => 'Category_prav',
            'foreign_key' => 'staff_id',
        ),
        'listener' => array(
            'model' => 'Listeners',
            'foreign_key' => 'staff_id',
        ),
        'staff_group' => array(
            'model' => 'Staff_group',
            'foreign_key' => 'staff_id',
        ),
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
            ),
            'adres' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 1000))
            ),
            'tel' => array(
                array('not_empty'),
                array('phone', array(':value', 11)),
            ),
            'data' => array(
                array('not_empty'),
                array('date'),
            ),
            'sex' => array(
                array('not_empty'),

            ),
            'nomer_prav' => array(
                array('not_empty'),

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