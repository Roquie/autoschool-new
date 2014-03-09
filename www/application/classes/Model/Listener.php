<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Listener extends ORM
{
	protected $_db = 'default';
    protected $_table_name  = 'Listener';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => false),
		'id_individual' => array('data_type' => 'int', 'is_nullable' => true),
		'id_user' => array('data_type' => 'int', 'is_nullable' => false),
		'id_aboutus' => array('data_type' => 'int', 'is_nullable' => true),
		'id_nationality' => array('data_type' => 'int', 'is_nullable' => true),
		'id_education' => array('data_type' => 'int', 'is_nullable' => true),
		'imya' => array('data_type' => 'string', 'is_nullable' => true),
		'famil' => array('data_type' => 'string', 'is_nullable' => true),
		'otch' => array('data_type' => 'string', 'is_nullable' => true),
		'data_rojdeniya' => array('data_type' => 'string', 'is_nullable' => true),
		'mesto_rojdeniya' => array('data_type' => 'string', 'is_nullable' => true),
		'adress' => array('data_type' => 'string', 'is_nullable' => true),
		'vrem_reg' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_seriya' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_nomer' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_data_vydachi' => array('data_type' => 'string', 'is_nullable' => true),
		'pasport_kem_vydan' => array('data_type' => 'string', 'is_nullable' => true),
		'tel' => array('data_type' => 'string', 'is_nullable' => true),
		'mesto_raboty' => array('data_type' => 'string', 'is_nullable' => true),
		'pol' => array('data_type' => 'int', 'is_nullable' => false),
		'nomer_med' => array('data_type' => 'string', 'is_nullable' => true),
		'seriya_med' => array('data_type' => 'string', 'is_nullable' => true),
		'data_med' => array('data_type' => 'string', 'is_nullable' => true),
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
            'data_rojdeniya' => array(
                array('not_empty'),
                array('date')
            ),
            'mesto_rojdeniya' => array(
                array('not_empty'),
                //  array('alpha_numeric', array(':value', true)),
                //   array('alpha', array(':value', true)),
            ),

            'adress' => array(
                //  array('alpha_numeric', array(':value', true)),
                //  array('alpha', array(':value', true)),
            ),

            'vrem_reg' => array(
                // array('alpha_numeric', array(':value', true)),
                // array('alpha', array(':value', true)),
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
            'tel' => array(
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

        );
    }


    public function labels()
    {
        return array(
            'user_id' => 'id пользователя',
            'famil' => 'Поле "Фамилия"',
            'imya' => 'Поле "Имя"',
            'otch' => 'Поле "Отчество"',
            'data_rojdeniya' => 'Поле "Дата рождения"',
            'mesto_rojdeniya' => 'Поле "Место рождения"',
            'adress' => 'Поле "Адрес рег. по паспорту"',
            'vrem_reg' => 'Поле "Временная регистрация"',
            'pasport_seriya' => 'Поле "Серия паспорта"',
            'pasport_nomer' => 'Поле "Номер паспорта"',
            'pasport_data_vyda4i' => 'Поле "Дата выдачи паспорта"',
            'pasport_kem_vydan' => 'Поле "Кем выдан паспорт"',
            'tel' => 'Поле "Моб. телефон"',
            'mesto_raboty' => 'Поле "Место работы"',
            'about' => 'Поле "Как вы узнали о нас"',
            'nationality_id' => 'id гражданства',
            'education_id' => 'id образования',

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