<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Exam extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'exam';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'group_id' => array('data_type' => 'int', 'is_nullable' => false),
		'predsedatel' => array('data_type' => 'string', 'is_nullable' => false),
		'sekretar' => array('data_type' => 'string', 'is_nullable' => false),
		'number_protocol' => array('data_type' => 'string', 'is_nullable' => false),
		'data_protocola' => array('data_type' => 'string', 'is_nullable' => false),
		'deducted' => array('data_type' => 'int', 'is_nullable' => false),
		'deducted_po_neysp' => array('data_type' => 'int', 'is_nullable' => false),
	);

    public function rules()
    {
        return array(
            'group_id' => array(
                array('digit')
            ),
            'predsedatel' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 500))
            ),
            'sekretar' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 500))
            ),
            'number_protocol' => array(
                array('not_empty')
            ),
            'data_protocola' => array(
                array('not_empty'),
                array('date'),
            ),
            'deducted' => array(
                array('digit')
            ),
            'deducted_po_neysp' => array(
                array('digit')
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