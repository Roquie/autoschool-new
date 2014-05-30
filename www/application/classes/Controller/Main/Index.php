<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main_Index extends Controller_Main_Base
{


    public function action_index()
    {
        //генерация кода для моделей. Не включать - затрет Users;
        //Gmodeler::init();

/*
        //create hashes
        $u = new Model_User();

        foreach($u->find_all() as $k => $v)
        {
            DB::update('users')->where('id', '=', $v->id)->set(array('hash' => md5(uniqid())))->execute();
        }*/

   /*     $l = new Model_Listeners();
        foreach($l->find_all() as $k => $v)
        {
            DB::update('listeners')->where('id', '=', $v->id)->set(array('tel' => Text::format_phone($v->tel)))->execute();
        }*/

        $this->template->content = View::factory('main/index');
    }




}