<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Listeners extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'listeners';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'user_id' => array('data_type' => 'int', 'is_nullable' => false),
		'about' => array('data_type' => 'string', 'is_nullable' => false),
		'nationality_id' => array('data_type' => 'int', 'is_nullable' => true),
		'education_id' => array('data_type' => 'int', 'is_nullable' => true),
		'group_id' => array('data_type' => 'int', 'is_nullable' => true),
		'staff_id' => array('data_type' => 'int', 'is_nullable' => true),
		'status' => array('data_type' => 'int', 'is_nullable' => false),
		'imya' => array('data_type' => 'string', 'is_nullable' => false),
		'famil' => array('data_type' => 'string', 'is_nullable' => false),
		'otch' => array('data_type' => 'string', 'is_nullable' => false),
		'data_rojdeniya' => array('data_type' => 'string', 'is_nullable' => false),
		'mesto_rojdeniya' => array('data_type' => 'string', 'is_nullable' => false),
		'adres' => array('data_type' => 'string', 'is_nullable' => false),
		'vrem_reg' => array('data_type' => 'string', 'is_nullable' => false),
		'pasport_seriya' => array('data_type' => 'string', 'is_nullable' => false),
		'pasport_nomer' => array('data_type' => 'string', 'is_nullable' => false),
		'pasport_data_vydachi' => array('data_type' => 'string', 'is_nullable' => false),
		'pasport_kem_vydan' => array('data_type' => 'string', 'is_nullable' => false),
		'tel' => array('data_type' => 'string', 'is_nullable' => false),
		'mesto_raboty' => array('data_type' => 'string', 'is_nullable' => false),
		'sex' => array('data_type' => 'int', 'is_nullable' => false),
		'nomer_med' => array('data_type' => 'string', 'is_nullable' => false),
		'seriya_med' => array('data_type' => 'string', 'is_nullable' => false),
		'data_med' => array('data_type' => 'string', 'is_nullable' => false),
	);

    protected $_belongs_to = array(
        'national' => array(
            'model' => 'Nationality',
            'foreign_key' => 'nationality_id',
        ),
        'edu' => array(
            'model' => 'Education',
            'foreign_key' => 'education_id',
        ),
        'group' => array(
            'model' => 'Group',
            'foreign_key' => 'group_id',
        ),
        'user' => array(
            'model' => 'User',
            'foreign_key' => 'user_id',
        ),
        'staff' => array(
            'model' => 'Staff',
            'foreign_key' => 'staff_id',
        ),
    );

    protected $_has_one = array(
        'indy' => array(
            'model' => 'Individual',
            'foreign_key' => 'listener_id',
        ),
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
            'ot4estvo' => array(
                array('alpha', array(':value', true)),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50)),
            ),
            'data_rojdeniya' => array(
                array('not_empty'),
                array('date')
            ),
            'mesto_rojdeniya' => array(
                array('not_empty'),
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),

            'adres' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),

            'vrem_reg' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),
            'pasport_seriya' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'pasport_nomer' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'pasport_data_vyda4i' => array(
                array('not_empty'),
                array('date')
            ),
            'pasport_kem_vydan' => array(
                array('not_empty'),
                // array('alpha_space', array(':value')),
            ),
            'mob_tel' => array(
                array('not_empty'),
            ),
            'mesto_raboty' => array(
                array('not_empty'),
                //   array('alpha', array(':value', true)),
            ),
            'about' => array(
                array('not_empty'),
                //array('alpha', array(':value', true)), - иначе пробелы и знаки препинания не работают.
            ),
            'nationality_id' => array(
                array('not_empty'),
                array('digit'),
            ),
            'education_id' => array(
                array('not_empty'),
                array('digit'),
            ),
            'user_id' => array(
                array('digit'),
            ),
            'individual_id' => array(
                array('digit'),
            ),
            'group_id' => array(
                array('digit'),
            ),
            'staff_id' => array(
                array('digit'),
            ),
            'status' => array(
                array('not_empty'),
                array('regex', array(':value', '/[0-3]/'))
            ),
            'sex' => array(
                array('not_empty'),

            ),
            'nomer_med' => array(
                array('not_empty'),

            ),
            'seriya_med' => array(
                array('not_empty'),

            ),
            'data_med' => array(
                array('not_empty'),
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