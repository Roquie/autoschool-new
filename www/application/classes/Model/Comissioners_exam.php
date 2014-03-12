<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Comissionersexam extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'comissionersexam';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'comissioner_id' => array('data_type' => 'int', 'is_nullable' => false),
        'exam_id' => array('data_type' => 'int', 'is_nullable' => false),
    );


    public function rules()
    {
        return array(
            'comissioner_id' => array(
                array('not_empty'),
                array('digit')
            ),
            'exam_id' => array(
                array('not_empty'),
                array('digit')
            )
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