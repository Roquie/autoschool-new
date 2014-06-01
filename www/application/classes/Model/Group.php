<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Group extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'groups';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'name' => array('data_type' => 'string', 'is_nullable' => false),
        'category_id' => array('data_type' => 'int', 'is_nullable' => true),
        'data_start' => array('data_type' => 'string', 'is_nullable' => true),
        'data_end' => array('data_type' => 'string', 'is_nullable' => true),
        'pdd_teacher' => array('data_type' => 'int', 'is_nullable' => true),
        'tyto_teacher' => array('data_type' => 'int', 'is_nullable' => true),
        'med_teacher' => array('data_type' => 'int', 'is_nullable' => true),
    );

    protected $_belongs_to = array(
        'category' => array(
            'model' => 'Category',
            'foreign_key' => 'category_id',
        )
    );

    protected $_has_many = array(
        'listener' => array(
            'model' => 'Listeners',
            'foreign_key' => 'group_id',
        ),
        'staff' => array(
            'model' => 'Staff',
            'through' => 'staff_group',
        ),
        'timelessons' => array(
            'model' => 'Timelessons',
            'foreign_key' => 'group_id',
        ),
    );

    protected $_has_one = array(
        'exam' => array(
            'model' => 'Exam',
            'foreign_key' => 'group_id',
        ),
    );



    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 50))
            ),
            'category_id' => array(
                //array('not_empty'),
                array('digit')
            ),
            'data_start' => array(
                array('not_empty'),
                array('date')
            ),
            'data_end' => array(
                array('not_empty'),
                array('date')
            ),
            'pdd_teacher' => array(
                array('not_empty'),
                array('digit')
            ),
            'tyto_teacher' => array(
                array('not_empty'),
                array('digit')
            ),
            'med_teacher' => array(
                array('not_empty'),
                array('digit')
            ),


        );
    }

    public function labels()
    {
        return array(
            'pdd_teacher' => 'Поле "Преподаватель ПДД"',
            'tyto_teacher' => 'Поле "Преподаватель ТУ и ТО"',
            'med_teacher' => 'Поле "Преподаватель ОПМТ"',
            'data_start' => 'Начало занятий',
            'data_end' => 'Окончание занятий',
            'name' => 'Название группы'
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

    public function isset_group($name)
    {
        $group = ORM::factory('Group')
                    ->where('name', '=', $name)
                    ->find_all();

        return $group->as_array();
    }
}