<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Individual extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'individual';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'listener_id' => array('data_type' => 'int', 'is_nullable' => false),
		'imya' => array('data_type' => 'string', 'is_nullable' => false),
		'famil' => array('data_type' => 'string', 'is_nullable' => false),
		'otch' => array('data_type' => 'string', 'is_nullable' => false),
		'region' => array('data_type' => 'string', 'is_nullable' => false),
		'street' => array('data_type' => 'string', 'is_nullable' => false),
		'rion' => array('data_type' => 'string', 'is_nullable' => false),
		'dom' => array('data_type' => 'string', 'is_nullable' => false),
		'korpys' => array('data_type' => 'string', 'is_nullable' => false),
		'kvartira' => array('data_type' => 'string', 'is_nullable' => false),
		'nas_pynkt' => array('data_type' => 'string', 'is_nullable' => false),
		'document_id' => array('data_type' => 'int', 'is_nullable' => false),
		'document_seriya' => array('data_type' => 'string', 'is_nullable' => false),
		'document_nomer' => array('data_type' => 'string', 'is_nullable' => false),
		'document_kem_vydan' => array('data_type' => 'string', 'is_nullable' => false),
		'document_data_vydachi' => array('data_type' => 'string', 'is_nullable' => false),
		'vrem_reg' => array('data_type' => 'int', 'is_nullable' => true),
		'tel' => array('data_type' => 'string', 'is_nullable' => false),
	);

    public function rules()
    {
        return array(

            'famil' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50)),
            ),
            'imya' => array(
                array('not_empty'),
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50)),
            ),
            'otch' => array(
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50)),
            ),

            'region' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'street' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),

            'rion' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'dom' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'korpys' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'kvartira' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'nas_pynkt' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'document_id' => array(
                array('digit')
            ),

            'vrem_reg' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'document_seriya' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'document_nomer' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'document_data_vydachi' => array(
                array('not_empty'),
                array('date')
            ),
            'document_kem_vydan' => array(
                array('not_empty'),
                // array('alpha_space', array(':value')),
            ),
            'tel' => array(
                array('not_empty'),
            ),
            'listener_id' => array(
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