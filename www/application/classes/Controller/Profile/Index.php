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

        $c = ORM::factory('Individual', array('listener_id' => $a->get_user()->id));

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
                        $post['listener_id'] = $a->get_user()->id;
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
                 ->set('contract_exists', $c)
                 ->render();

        $this->_profile->content = $v;
    }

    public function action_help()
    {
        $a = Auth::instance();
        $m = new Model_Messages();

        $messages = $m->getMessage($a->get_user()->id);
        $admin_avatar = Kohana::$config->load('settings.admin_avatar');

        $this->_profile->content = View::factory('profile/pages/help', compact('messages', 'admin_avatar'));
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

        switch($type)
        {
            case 'contract':
                $this->ajax_data(
                    array(
                         'file' => $this->_create_contract(),
                         'url' => URL::site('viewdoc'),
                    )
                );
            break;
            case 'statement':
                $this->ajax_data(
                    array(
                         'file' => $this->_create_statement(),
                         'url' => URL::site('viewdoc'),
                    )
                );
            break;
            case 'ticket':
                $this->ajax_data(
                    array(
                         'file' => $this->_create_ticket(),
                         'url' => URL::site('viewdoc'),
                    )
                );
            break;
        }
    }

    public function action_download()
    {
        $this->_profile->content = View::factory('profile/pages/downloads', compact('errors', 'success'));
    }

    public function action_download_statement()
    {
        $file = $this->_create_statement();

        $this->response->send_file(
            APPPATH.'download/'.$file, null, array('delete' => true)
        );
    }

    public function action_download_contract()
    {
        $file = $this->_create_contract();

        $this->response->send_file(
            APPPATH.'download/'.$file, null, array('delete' => true)
        );
    }

    public function action_download_ticket()
    {
        $file = $this->_create_ticket();

        $this->response->send_file(
            APPPATH.'download/'.$file, null, array('delete' => true)
        );
    }

    protected function _create_contract()
    {
        $listener = ORM::factory('User', Auth::instance()->get_user()->id)->listener;
        $indy = ORM::factory('User', Auth::instance()->get_user()->id)->listener->indy;

        $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;

        $obj = new TemplateDocx(APPPATH.'templates/contract/dogovor.docx');

        if ($listener->is_individual)
        {
            $obj->setValueArray(
                array(
                     'Customer' => $indy->famil.' '.$indy->imya.' '.$indy->otch,
                     'CSeriya' => $indy->document_seriya,
                     'CNomer' => $indy->document_nomer,
                     'CVidan' => $indy->document_kem_vydan,
                     'CAddress' =>
                         'регион: '.$indy->region.
                         ' насел. пункт: '.$indy->nas_pynkt.
                         ', район: '.$indy->rion.
                         ', ул. '.$indy->street.
                         ', д. '.$indy->dom.
                         $korpys
                         .' кв. '.$indy->kvartira,
                     'CPhone' => $indy->tel,

                     'Listener' => $listener->famil.' '.$listener->imya.' '.$listener->otch,
                     'LSeriya' => $listener->document_seriya,
                     'LNomer' => $listener->document_nomer,
                     'LVidan' => $listener->document_kem_vydan,
                     'LAddress' =>
                         'регион: '.$listener->region.
                         ' насел. пункт: '.$listener->nas_pynkt.
                         ', район: '.$listener->rion.
                         ', ул. '.$listener->street.
                         ', д. '.$listener->dom.
                         $korpys
                         .' кв. '.$listener->kvartira,
                     'LPhone' => $listener->tel,
                )
            );

            $file = 'temp/'.
                Text::translit($indy->famil).'_'.
                Text::translit(UTF8::substr($indy->imya, 0, 1)).'_'.
                Text::translit(UTF8::substr($indy->otch, 0, 1)).'_'.
                'dogovor_'.date('d_m_Y_H_i_s').'.docx';
        }
        else
        {
            $obj->setValueArray(
                array(
                     'Customer' => $listener->famil.' '.$listener->imya.' '.$listener->otch,
                     'CSeriya' => $listener->document_seriya,
                     'CNomer' => $listener->document_nomer,
                     'CVidan' => $listener->document_kem_vydan,
                     'CAddress' =>
                         'регион: '.$listener->region.
                         ' насел. пункт: '.$listener->nas_pynkt.
                         ', район: '.$listener->rion.
                         ', ул. '.$listener->street.
                         ', д. '.$listener->dom.
                         $korpys
                         .' кв. '.$listener->kvartira,
                     'CPhone' => $listener->tel,

                     'Listener' => $listener->famil.' '.$listener->imya.' '.$listener->otch,
                     'LSeriya' => $listener->document_seriya,
                     'LNomer' => $listener->document_nomer,
                     'LVidan' => $listener->document_kem_vydan,
                     'LAddress' =>
                         'регион: '.$listener->region.
                         ' насел. пункт: '.$listener->nas_pynkt.
                         ', район: '.$listener->rion.
                         ', ул. '.$listener->street.
                         ', д. '.$listener->dom.
                         $korpys
                         .' кв. '.$listener->kvartira,
                     'LPhone' => $listener->tel,
                )
            );

            $file = 'temp/'.
                Text::translit($listener->famil).'_'.
                Text::translit(UTF8::substr($listener->imya, 0, 1)).'_'.
                Text::translit(UTF8::substr($listener->otch, 0, 1)).'_'.
                'dogovor_'.date('d_m_Y_H_i_s').'.docx';
        }

        $obj->save(APPPATH.'download/'.$file);
        unset($document);

        return $file;
    }

    protected function _create_statement()
    {
        $listener = ORM::factory('User', Auth::instance()->get_user()->id)
                        ->listener;

        $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;
        $document = new TemplateDocx(APPPATH.'templates/zayavlenie/template.docx');

        $document->setValueArray(
            array(
                 'Fam' => $listener->famil,
                 'Name' => $listener->imya,
                 'Otchestvo' => $listener->otch,
                 'DateBirth' => $listener->data_rojdeniya,
                 'Nationality' => $listener->national->name,
                 'PlaceBirth' => $listener->mesto_rojdeniya,
                 'AdresRegPoPasporty' =>
                     'регион: '.$listener->region.
                     ' насел. пункт: '.$listener->nas_pynkt.
                     ', район: '.$listener->rion.
                     ', ул. '.$listener->street.
                     ', д. '.$listener->dom.
                     $korpys
                     .' кв. '.$listener->kvartira,
                 'VremReg' => $listener->vrem_reg ? 'Да' : 'Нет',
                 'Seriya' => $listener->document_seriya,
                 'Nomer' => $listener->document_nomer,
                 'Vidacha' => $listener->document_data_vydachi,
                 'PasportKemVydan' => $listener->document_kem_vydan,
                 'MobTel' => $listener->tel,
                 'Email' => Auth::instance()->get_user()->email,
                 'Obrazovanie' => $listener->edu->name,
                 'MestoRaboty' => $listener->mesto_raboty,
                 'About' => $listener->about,
            )
        );

        $file = 'temp/'.
            Text::translit($listener->famil).'_'.
            Text::translit(UTF8::substr($listener->imya, 0, 1)).'_'.
            Text::translit(UTF8::substr($listener->otch, 0, 1)).'_'.
            'zayavlenie_'.date('d_m_Y_H_i_s').'.docx';

        $document->save(APPPATH.'download/'.$file);
        unset($document);

        return $file;
    }

    protected function _create_ticket()
    {
        $indy = ORM::factory('User', Auth::instance()->get_user()->id)->listener->indy;
        $listener = ORM::factory('User', Auth::instance()->get_user()->id)->listener;

        $obj = new TemplateDocx(APPPATH.'templates/ticket/ticket.docx');

        $famil = UTF8::ucfirst(UTF8::strtolower($listener->famil));
        $imya = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($listener->imya, 0, 1).'. '));
        $ot4estvo = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($listener->otch, 0, 1).'.'));

        $obj->setValue('Customer', $famil.' '.$imya.' '.$ot4estvo);

        $file = 'temp/'.
            Text::translit($listener->famil).'_'.
            Text::translit(UTF8::substr($listener->imya, 0, 1)).'_'.
            Text::translit(UTF8::substr($listener->otch, 0, 1)).'_'.
            'kvitanciya_'.date('d_m_Y_H_i_s').'.docx';

        $obj->save(APPPATH.'download/'.$file);
        unset($document);

        return $file;
    }

    public function action_download_zip()
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
    }

    public function after()
    {
        $this->template->content = $this->_profile->render();
        parent::after();
    }

}