<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Transport extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'transport';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'name' => array('data_type' => 'string', 'is_nullable' => false),
		'reg_number' => array('data_type' => 'string', 'is_nullable' => false),
		'description' => array('data_type' => 'string', 'is_nullable' => false),
		'doc_seriya' => array('data_type' => 'string', 'is_nullable' => false),
		'doc_nomer' => array('data_type' => 'string', 'is_nullable' => false),
		'doc_data_reg' => array('data_type' => 'string', 'is_nullable' => false),
		'doc_place_reg' => array('data_type' => 'string', 'is_nullable' => false),
	);

    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 90)),
            ),
            'reg_number' => array(
                array('not_empty'),
            ),
            'doc_data_reg' => array(
                array('date'),
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