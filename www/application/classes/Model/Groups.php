<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Groups extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'groups';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'name' => array('data_type' => 'string', 'is_nullable' => false),
        'category_id' => array('data_type' => 'int', 'is_nullable' => false),
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

    protected $_has_one = array(
        'staff_group' => array(
            'model' => 'Staff_group',
            'foreign_key' => 'group_id',
        ),
        'timelessons' => array(
            'model' => 'Timelessons',
            'foreign_key' => 'group_id',
        ),
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
                array('not_empty'),
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