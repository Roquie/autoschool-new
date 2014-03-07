<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile_Index extends Controller_Profile_Base
{
    protected $_profile = null;

    public function before()
    {
        parent::before();

        $this->_profile = new View('profile/template');
        $this->_profile->group = 0; // заглушка
        $this->_profile->content = null;
    }

    public function action_index()
	{
        $a = Auth::instance();
        $group = ORM::factory('Groups', $a->get_user()->group_id)
                    ->find()
                    ->as_array();

        $result = ORM::factory('Groups', $a->get_user()->group_id)->news->find_all();

        $news = array();

        if ($result->count() === 0)
        {
            $news[] = array(
                'title' => 'Группа не определена администратором',
                'message' => 'Сообщения не найдены.',
            );
        }
        else
        {
            foreach ($result as $v)
                $news[] = $v->as_array();
        }

        $this->_profile->content = View::factory('profile/pages/messages', compact('news'));
	}

    public function action_statement()
    {
        $a = Auth::instance();
        $post = $this->request->post();
        $user = ORM::factory('User', $a->get_user()->id);
        $edu = ORM::factory('Educations')->find_all();
        $national = ORM::factory('Nationality')->find_all();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            try
            {
                if ($user->status < 3)
                {
                    $user->statement
                        ->values($post)
                        ->where('user_id', '=', $a->get_user()->id)
                        ->update();

                    $success = 'update';
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $v = View::factory('profile/pages/statement', compact('errors', 'success', 'edu', 'national'))
                 ->set('statement', $user->statement->as_array())
                 ->set('status', $user->status)
                 ->render();

        $this->_profile->content = $v;
    }

    public function action_contract()
    {
        $a = Auth::instance();
        $post = $this->request->post();
        $user = ORM::factory('User', $a->get_user()->id);

        $c = ORM::factory('Contracts', array('user_id' => $a->get_user()->id));

        $form_data = $user->contract->as_array();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            try
            {
                if ($user->status < 3)
                {
                    if ($c->loaded())
                    {
                        $c->values($post)->where('user_id', '=', $a->get_user()->id)->update();
                        $success = 'update';
                    }
                    else
                    {
                        $post['user_id'] = $a->get_user()->id;
                        $form_data = array_merge($form_data, $post);
                        $c->values($post)->create();
                        $success = 'create';
                    }
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
            }
        }

        $v = View::factory('profile/pages/contract', compact('errors', 'success'))
                 ->set('contract', $form_data)
                 ->set('status', $user->status)
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
        $statement = ORM::factory('User', Auth::instance()->get_user()->id)->statement;
        $contract = ORM::factory('User', Auth::instance()->get_user()->id)->contract;

        $obj = new TemplateDocx(APPPATH.'templates/contract/dogovor.docx');

        $obj->setValueArray(
            array(
                 'Customer' => $contract->famil.' '.$contract->imya.' '.$contract->ot4estvo,
                 'CSeriya' => $contract->pasport_seriya,
                 'CNomer' => $contract->pasport_nomer,
                 'CVidan' => $contract->pasport_kem_vydan,
                 'CAddress' => $contract->adres_reg_po_pasporty,
                 'CPhone' => $contract->phone,

                 'Listener' => $statement->famil.' '.$statement->imya.' '.$statement->ot4estvo,
                 'LSeriya' => $statement->pasport_seriya,
                 'LNomer' => $statement->pasport_nomer,
                 'LVidan' => $statement->pasport_kem_vydan,
                 'LAddress' => $statement->adres_reg_po_pasporty,
                 'LPhone' => $statement->mob_tel,
            )
        );

        $file = 'temp/'.
            Text::translit($contract->famil).'_'.
            Text::translit(UTF8::substr($contract->imya,0, 1)).'_'.
            Text::translit(UTF8::substr($contract->ot4estvo,0, 1)).'_'.
            'dogovor_'.date('d_m_Y_H_i_s').'.docx';

        $obj->save(APPPATH.'download/'.$file);
        unset($document);

        return $file;
    }

    protected function _create_statement()
    {
        $statement = ORM::factory('User', Auth::instance()->get_user()->id)
            ->statement;

        $document = new TemplateDocx(APPPATH.'templates/zayavlenie/template.docx');

        $document->setValueArray(
            array(
                 'Fam' => $statement->famil,
                 'Name' => $statement->imya,
                 'Otchestvo' => $statement->ot4estvo,
                 'DateBirth' => $statement->data_rojdeniya,
                 'Nationality' => $statement->national->grajdanstvo,
                 'PlaceBirth' => $statement->mesto_rojdeniya,
                 'AdresRegPoPasporty' => $statement->adres_reg_po_pasporty,
                 'VremReg' => $statement->vrem_reg,
                 'Seriya' => $statement->pasport_seriya,
                 'Nomer' => $statement->pasport_nomer,
                 'Vidacha' => $statement->pasport_data_vyda4i,
                 'PasportKemVydan' => $statement->pasport_kem_vydan,
                 'MobTel' => $statement->mob_tel,
                 'Obrazovanie' => $statement->edu->obrazovanie,
                 'MestoRaboty' => $statement->mesto_raboty,
                 'About' => $statement->about,
            )
        );

        $file = 'temp/'.
            Text::translit($statement->famil).'_'.
            Text::translit(UTF8::substr($statement->imya,0, 1)).'_'.
            Text::translit(UTF8::substr($statement->ot4estvo,0, 1)).'_'.
            'zayavlenie_'.date('d_m_Y_H_i_s').'.docx';

        $document->save(APPPATH.'download/'.$file);
        unset($document);

        return $file;
    }

    protected function _create_ticket()
    {
        $contract = ORM::factory('User', Auth::instance()->get_user()->id)->contract;

        $obj = new TemplateDocx(APPPATH.'templates/ticket/ticket.docx');

        $famil = UTF8::ucfirst(UTF8::strtolower($contract->famil));
        $imya = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($contract->imya, 0, 1).'. '));
        $ot4estvo = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($contract->ot4estvo, 0, 1).'.'));

        $obj->setValue('Customer', $famil.' '.$imya.' '.$ot4estvo);

        $file = 'temp/'.
            Text::translit($contract->famil).'_'.
            Text::translit(UTF8::substr($contract->imya, 0, 1)).'_'.
            Text::translit(UTF8::substr($contract->ot4estvo, 0, 1)).'_'.
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