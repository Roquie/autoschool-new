<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Individual extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Individual';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'famil' => array('data_type' => 'string', 'is_nullable' => true),
		'imya' => array('data_type' => 'string', 'is_nullable' => true),
		'otchestvo' => array('data_type' => 'string', 'is_nullable' => true),
		'adress' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_seriya' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_nomer' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_kem_vydan' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_data_vyda4i' => array('data_type' => 'string', 'is_nullable' => true),
		'vrem_reg' => array('data_type' => 'string', 'is_nullable' => true),
		'phone' => array('data_type' => 'string', 'is_nullable' => true),
	);

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