<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Office extends ORM
{
    protected $_db = 'default';
    protected $_table_name  = 'office';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'name' => array('data_type' => 'string', 'is_nullable' => false),
    );

    protected $_has_many = array(
        'staff' => array(
            'model' => 'Staff',
            'through' => 'office_staff'
        ),

    );

    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 90)),
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

    public function getStaffs($office)
    {
        $arr = array();
        if (is_array($office))
        {
            foreach ($office as $key => $value)
            {
                $offices = ORM::factory('Office')
                    ->where('name', '=', $value)
                    ->find();

                $staffs = $offices->staff->find_all();

                foreach ($staffs as $v)
                    $arr[$key][$v->id] =
                        $v->famil . ' '.
                        UTF8::substr($v->imya,0, 1).'. ' .
                        UTF8::substr($v->otch,0, 1).'.';
            }
        }
        else
        {
            $offices = ORM::factory('Office')
                ->where('name', '=', $office)
                ->find();

            $staffs = $offices->staff->find_all();

            foreach ($staffs as $value)
                $arr[$value->id] =
                    $value->famil . ' '.
                    UTF8::substr($value->imya,0, 1).'. ' .
                    UTF8::substr($value->otch,0, 1).'.';
        }

        return $arr;

/*        foreach($staffs as $staff)
        {
            echo $office->name .' - '. $staff->imya .'<br />';
        }*/
    }
}