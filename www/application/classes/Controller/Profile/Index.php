<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Index extends Controller_Profile_Base
{
    protected $_profile = null;
    protected $_group = null;

    public function before()
    {
        parent::before();

        $this->_profile = new View('profile/template');
        $this->_profile->content = null;

        $id = Auth::instance()->get_user()->id;

        $this->_group = ORM::factory('User', $id)->listener->group;

        if ($this->_group->loaded())
        {
            $this->_profile->group = 'Группа #: '.$this->_group->name;
        }
        else
        {
            $this->_profile->group = null;
        }
    }

    public function action_index()
	{
        $news = ORM::factory('News')
                   ->where('group_id', '=', $this->_group->id)
                   ->order_by('id', 'desc')
                   ->find_all();


        $this->_profile->content = View::factory('profile/pages/messages', compact('news'));
	}

    public function action_statement()
    {
        $a = Auth::instance();
        $post = $this->request->post();
        $user = ORM::factory('User', $a->get_user()->id);
        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            if (isset($post['vrem_reg']))
            {
                $post['vrem_reg'] = (bool)$post['vrem_reg'];
            }
            else
            {
                $post['vrem_reg'] = 0;
            }

            try
            {
                if ($user->listener->status < 3)
                {

                    $post['data_rojdeniya'] =  Text::getDateUpdate($post['data_rojdeniya']);
                    $post['document_data_vydachi'] = Text::getDateUpdate($post['document_data_vydachi']);

                    $user->listener
                         ->values($post)
                         ->where('user_id', '=', $a->get_user()->id)
                         ->update();

                    $success = Kohana::message('profile', 'statement.update_ok');
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $statement = $user->listener->as_array();
        $statement['data_rojdeniya'] =  Text::check_date($statement['data_rojdeniya']);
        $statement['document_data_vydachi'] =  Text::check_date($statement['document_data_vydachi']);

        $v = View::factory('profile/pages/statement', compact('errors', 'success', 'edu', 'national', 'type_doc'))
                 ->set('statement', $statement)
                 ->set('status', $user->listener->status)
                 ->render();

        $this->_profile->content = $v;
    }

    public function action_contract_check()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $id = Auth::instance()->get_user()->id;
            if (isset($post['customer']))
            {
                try
                {
                    DB::update('listeners')
                      ->set(array('is_individual' => 0))
                      ->where('user_id', '=', $id)
                      ->execute();
                }
                catch(Database_Exception $e)
                {
                    die($e->getMessage());
                }
                HTTP::redirect('/profile/contract');
            }
            else
            {
                try
                {
                    DB::update('listeners')
                      ->set(array('is_individual' => 1))
                      ->where('user_id', '=', $id)
                      ->execute();
                }
                catch(Database_Exception $e)
                {
                    die($e->getMessage());
                }
                HTTP::redirect('/profile/contract');

            }
        }
        else
        {
            HTTP::redirect('/profile/contract');
        }
    }

    public function action_contract()
    {
        $a = Auth::instance();
        $post = $this->request->post();
        $user = ORM::factory('User', $a->get_user()->id);
        $type_doc = ORM::factory('Documents')->find_all();

        $c = ORM::factory('Individual')->where('listener_id', '=', $user->listener->id)->find();

        $form_data = $user->listener->indy->as_array();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            if (isset($post['vrem_reg']))
            {
                $post['vrem_reg'] = (bool)$post['vrem_reg'];
            }
            else
            {
                $post['vrem_reg'] = 0;
            }

            try
            {
                if ($user->listener->status < 3)
                {
                    $post['document_data_vydachi'] =  Text::getDateUpdate($form_data['document_data_vydachi']);
                    if ($c->loaded())
                    {
                        $c->values($post)->where('user_id', '=', $a->get_user()->id)->update();
                        $success = Kohana::message('profile', 'contract.update');
                    }
                    else
                    {
                        $post['listener_id'] = $user->listener->id;
                        $form_data = array_merge($form_data, $post);
                        $c->values($post)->create();
                        $success = Kohana::message('profile', 'contract.create');
                    }
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $form_data['document_data_vydachi'] =  Text::check_date($form_data['document_data_vydachi']);

        $v = View::factory('profile/pages/contract', compact('errors', 'success', 'type_doc'))
                 ->set('contract', $form_data)
                 ->set('status', $user->listener->status)
                 ->set('contract_exists', $c->loaded())
                 ->render();

        $this->_profile->content = $v;
    }

    public function action_help()
    {
        $a = Auth::instance();
        $user = $a->get_user();

        $listener = $user->listener;

        $messages = $listener->getMessage();

        $profile = true;

        $admin_avatar = Kohana::$config->load('settings.admin_avatar');

        $this->_profile->content = View::factory('profile/pages/help', compact('messages', 'user', 'listener', 'admin_avatar', 'profile'));
    }

    public function action_add_message()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');



        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $post = $this->request->post();
            //fix xss
            $post = Arr::map('Security::xss_clean',
                Arr::map('trim', $this->request->post())
            );

            unset($post['csrf']);

            $a = Auth::instance();
            $user = $a->get_user();

            $post['admin'] = 0;
            $post['listener_id'] = $user->listener->id;

            try
            {
                ORM::factory('Messages')->values($post)->create();
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');

                $this->ajax_msg(array_shift($errors), 'error');
            }

            $this->ajax_data(
                View::factory('admin/html/message', compact('post', 'user'))->render(),
                'Сообщение отправлено'
            );
        }
    }

    /**
     * Заргузка сообщений пользователя
     */
    public function action_load_message()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        //$this->ajax_data($this->request->post());

        if (Security::is_token($csrf) && $this->request->method() === Request::POST)
        {
            $a = Auth::instance();
            $user = $a->get_user();

            $listener = $user->listener;

            $messages = $listener->getMessage($this->request->post('offset'));

            if (!$messages->count())
                $this->ajax_msg('', 'empty');

            $profile = true;

            $admin_avatar = Kohana::$config->load('settings.admin_avatar');

            $this->ajax_data(
                View::factory('admin/html/messages', compact('messages', 'listener' , 'profile', 'admin_avatar'))->render()
            );
        }
    }

    public function action_settings()
    {
        $a = Auth::instance();
        $type = $this->request->param('id');
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            if ($a->hash($post['password']) === $a->get_user()->password)
            {
                if ($type === 'change_pass')
                {
                    try
                    {
                         ORM::factory('User', $a->get_user()->id)
                            ->update_user(
                                 array(
                                      'password' => $post['password_new'],
                                      'password_confirm' => $post['password_new']
                                 ),
                                 array('password')
                             );

                         $success = Kohana::message('profile', 'settings.ok_pass');
                    }
                    catch(ORM_Validation_Exception $e)
                    {
                        $errors = $e->errors('validation');
                        $errors = array_shift($errors);
                    }

                }
                elseif ($type === 'change_email')
                {
                    try
                    {
                        ORM::factory('User', $a->get_user()->id)
                            ->update_user(
                                array(
                                     'email' => $post['new_email'],
                                ),
                                array('email')
                            );

                        $success = Kohana::message('profile', 'settings.ok_email');
                    }
                    catch(ORM_Validation_Exception $e)
                    {
                        $errors = $e->errors('validation');
                    }
                }
            }
            else
            {
                $errors = array('err_pass' => Kohana::message('profile', 'settings.err_pass'));
            }
        }

        $this->_profile->content = View::factory('profile/pages/settings', compact('errors', 'success'));
    }

    public function action_view_doc()
    {
        $type = $this->request->param('id');
        $this->auto_render = false;
        switch($type)
        {
            case 'contract':
                echo Request::factory('admin/files/look/contract')->execute();
            break;
            case 'statement':
                echo Request::factory('admin/files/look/statement')->execute();
            break;
            case 'ticket':
                echo Request::factory('admin/files/look/ticket')->execute();
            break;
        }
    }

    public function action_download()
    {
        $this->_profile->content = View::factory('profile/pages/downloads', compact('errors', 'success'));
    }

    public function action_download_statement()
    {
        Request::factory('admin/files/download/statement')->execute();
    }

    public function action_download_contract()
    {
        Request::factory('admin/files/download/contract')->execute();
    }

    public function action_download_ticket()
    {
        Request::factory('admin/files/download/ticket')->execute();
    }


   /* public function action_download_zip()
    {
        $paths = array(
            APPPATH.'download/'.$this->_create_contract(),
            APPPATH.'download/'.$this->_create_statement(),
            APPPATH.'download/'.$this->_create_ticket(),
        );

        $str = File::createZip(APPPATH.'download/temp/documents_exports', $paths);

        foreach ($paths as $value)
            unlink($value);

        $this->response->send_file(
            $str, null, array('delete' => true)
        );
    }*/

    public function after()
    {
        $this->template->content = $this->_profile->render();
        parent::after();
    }

}