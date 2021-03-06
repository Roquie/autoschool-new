<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User
{
    protected $_db = 'default';
    protected $_table_name  = 'users';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
        'id' => array('data_type' => 'int', 'is_nullable' => false),
        'email' => array('data_type' => 'string', 'is_nullable' => false),
        'hash' => array('data_type' => 'string', 'is_nullable' => false),
        'photo' => array('data_type' => 'string', 'is_nullable' => false),
        'password' => array('data_type' => 'string', 'is_nullable' => false),
        'logins' => array('data_type' => 'int', 'is_nullable' => false),
        'last_login' => array('data_type' => 'int', 'is_nullable' => true),
    );


    protected $_has_one = array(
        'admin' => array(
            'model' => 'Administrators',
            'foreign_key' => 'user_id',
        ),
        'listener' => array(
            'model' => 'Listeners',
            'foreign_key' => 'user_id',
        )
    );

    public function rules()
    {
        return array(
            'id' => array(
                array('digit')
            ),
            'email' => array(
                //array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
        );
    }

    public function labels()
    {
        return array(
            'id' => 'Номер пользователя',
            'email' => 'Почта',
            'password' => 'Поле "Пароль" '
        );
    }

    public function filters()
    {
        return array(
            'email' => array(
                array('trim'),
                array('Security::xss_clean', array(':value')),
            ),
            'photo' => array(
                array('trim'),
                array('Security::xss_clean', array(':value')),
            ),
            'password' => array(
                array(array(Auth::instance(), 'hash'))
            )
        );
    }

    /**
     * вернет array(
    0 => 'Фамилия И.О.',
     * );
     * @param bool $no_approved
     * @return array
     */
    public function get_user_list($no_approved = true, $all = false)
    {
        $no_approved ? $condition = '<' : $condition = '=';

        if ($all)
            $users = ORM::factory('Listeners')->find_all();
        else
            $users = ORM::factory('Listeners')->where('status', $condition, 3)->find_all();

        return $this->_filter_user_list($users);
    }

    public function by_group_id($group_id)
    {
        $result = ORM::factory('User')
            ->listener
            ->where('group_id', '=', $group_id)
            ->where('status', '=', 3)
            ->find_all();

        if ($result->count() === 0)
            return false;
        else
            return $this->_filter_user_list($result);
    }

    /**
     * вернет array(
    0 => 'Фамилия И.О.',
     * );
     * @internal param bool $no_approved
     * @return array
     */
    public function users_without_group()
    {
        $users = ORM::factory('User')->where('group_id', '=', 0)->find_all();
        return $this->_filter_user_list($users);
    }

    protected function _filter_user_list($obj_orm_users)
    {
        $arr = array();
        foreach ($obj_orm_users as $value)
            $arr[$value->id] =
                Text::limit_chars($value->famil, 10, '*') . ' '.
                UTF8::substr($value->imya,0, 1).'. ' .
                UTF8::substr($value->otch,0, 1).'.';

        asort($arr);

        return $arr;
    }

    /**
     * Allows a model use both email and username as unique identifiers for login
     *
     * @param   string  unique value
     * @return  string  field name
     */
    public function unique_key($value)
    {
        return Valid::email($value) ? 'email' : 'hash';
    }


}