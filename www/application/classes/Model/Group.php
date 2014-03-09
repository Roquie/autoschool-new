<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Group extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Group';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_category' => array('data_type' => 'int', 'is_nullable' => false),
		'id_pdd' => array('data_type' => 'int', 'is_nullable' => true),
		'id_tuto' => array('data_type' => 'int', 'is_nullable' => true),
		'id_opmt' => array('data_type' => 'int', 'is_nullable' => true),
		'name' => array('data_type' => 'string', 'is_nullable' => false),
		'data_nachala' => array('data_type' => 'string', 'is_nullable' => true),
		'data_okonchaniya' => array('data_type' => 'string', 'is_nullable' => true),
	);



    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
                array('min_length', array(':value', 1)),
                array('max_length', array(':value', 50)),
                array(array($this, 'unique'), array('name', ':value')),
            ),
            'data_nachala' => array(
                array('not_empty'),
                array('date'),
            ),
            'data_okonchaniya' => array(
                array('not_empty'),
                array('date'),
            ),

        );
    }

    public function labels()
    {
        return array(
            'name' => 'Поле "Наименование группы" ',
            'data_nachala' => 'Поле "Дата начала" ',
            'data_okonchaniya' => 'Поле "Дата окончания" ',
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