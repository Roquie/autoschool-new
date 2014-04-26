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
		'tel' => array('data_type' => 'string', 'is_nullable' => false),
		'region' => array('data_type' => 'string', 'is_nullable' => false),
		'street' => array('data_type' => 'string', 'is_nullable' => false),
		'rion' => array('data_type' => 'string', 'is_nullable' => false),
		'dom' => array('data_type' => 'string', 'is_nullable' => false),
		'korpys' => array('data_type' => 'string', 'is_nullable' => false),
		'kvartira' => array('data_type' => 'string', 'is_nullable' => false),
		'nas_pynkt' => array('data_type' => 'string', 'is_nullable' => false),
		'document_id' => array('data_type' => 'int', 'is_nullable' => false),
		'vrem_reg' => array('data_type' => 'int', 'is_nullable' => false),
		'document_seriya' => array('data_type' => 'string', 'is_nullable' => false),
		'document_nomer' => array('data_type' => 'string', 'is_nullable' => false),
		'document_data_vydachi' => array('data_type' => 'string', 'is_nullable' => true),
		'document_kem_vydan' => array('data_type' => 'string', 'is_nullable' => false),
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

        'transport' => array(
            'model' => 'Transport',
            'foreign_key' => 'staff_id',
        ),
    );

    protected $_has_many = array(
        'office' => array(
            'model' => 'Office',
            'through' => 'office_staff'
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

            'tel' => array(
                array('not_empty'),
                array('phone', array(':value', 11)),
            ),

            'sex' => array(
                array('not_empty'),
            ),

            'nomer_prav' => array(
                array('not_empty'),

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

            'vrem_reg' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),

            'document_id' => array(
                array('not_empty'),
                array('digit')
            ),
            'document_seriya' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'document_nomer' => array(
                array('not_empty'),
                array('alpha_numeric', array(':value', true)),
            ),
            'document_kem_vydan' => array(
                array('not_empty'),
                // array('alpha_space', array(':value')),
            ),
            'document_data_vydachi' => array(
                array('not_empty'),
                array('date')
            ),


        );
    }

    public function labels()
    {
        return array(
            'otch' => 'Поле "Отчество" ',
            'imya' => 'Поле "Имя" ',
            'famil' => 'Поле "Фамилия" ',
            'tel' => 'Поле "Моб. тел." ',
            'sex' => 'Поле "Пол" ',
            'document_id' => 'Поле "Тип документа" ',
            'document_data_vydachi' => 'Поле "Дата выдачи" ',
            'document_seriya' => 'Поле "Серия документа" ',
            'document_nomer' => 'Поле "Номер документа" ',
            'region' => 'Поле "Регион" ',
            'street' => 'Поле "Улица" ',
            'rion' => 'Поле "Район" ',
            'dom' => 'Поле "Дом" ',
            'korpys' => 'Поле "Корпус" ',
            'kvartira' => 'Поле "Квартира" ',
            'nas_pynkt' => 'Поле "Населенный пункт" ',
            'vrem_reg' => 'Поле "Временная регистрация" ',
            'document_kem_vydan' => 'Поле "Кем выдан документ" ',
            'nomer_prav' => 'Поле "Номер прав" ',
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