<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Createdocs_Index extends Controller_Admin_Base
{

    public function action_save_to_db()
    {
        $this->auto_render = false;

        $listener = $this->request->post('statement');
        $indy  = $this->request->post('contract');

/*        $this->ajax_data($listener, 'error');
        exit;*/

        if (Security::is_token($listener['csrf']) && $this->request->method() === Request::POST)
        {
            $newpass = Text::random();

            $valid = new Validation(
                Arr::map(
                    'Security::xss_clean',
                    Arr::map('trim', $listener)
                )
            );
            $valid->rule('famil', 'not_empty');
            $valid->rule('famil', 'alpha', array(':value', true));
            $valid->rule('famil', 'min_length', array(':value', 2));
            $valid->rule('famil', 'max_length', array(':value', 50));
            $valid->rule('imya', 'not_empty');
            $valid->rule('imya', 'alpha', array(':value', true));
            $valid->rule('imya', 'min_length', array(':value', 2));
            $valid->rule('imya', 'max_length', array(':value', 50));
            //$valid->rule('otch', 'not_empty');
            $valid->rule('otch', 'alpha', array(':value', true));
            $valid->rule('otch', 'min_length', array(':value', 2));
            $valid->rule('otch', 'max_length', array(':value', 50));
            $valid->rule('tel', 'not_empty');
            $valid->rule('tel', 'phone', array(':value', 11));

            if ($valid->check())
            {
                $email = $listener['email'];
                try
                {
                    $users = ORM::factory('User');
                    $pk = $users
                        ->create_user(
                            array(
                                 'password' => $newpass,
                                 'password_confirm' => $newpass,
                                 'email' => $email
                            ),
                            array(
                                 'password',
                                 'email',
                            ))->pk();


                    unset($listener['email'], $listener['csrf']);

                    $listener['data_rojdeniya'] = Text::getDateUpdate($listener['data_rojdeniya']);
                    $listener['document_data_vydachi'] = Text::getDateUpdate($listener['document_data_vydachi']);
                    $indy['document_data_vydachi'] = Text::getDateUpdate($indy['document_data_vydachi']);

                    $columns = array_keys($listener);
                    $columns[] = 'user_id';

                    $listener['user_id'] = $pk;

                    try
                    {
                        $query = DB::insert('listeners')
                                   ->columns($columns)
                                   ->values($listener)
                                   ->execute();
                    }
                    catch(Database_Exception $e)
                    {
                        $this->ajax_msg($e->getMessage(), 'error');
                    }

                    if ($listener['is_individual'] == 1)
                    {
                        unset($indy['csrf']);

                        $columns = array_keys($indy);
                        $columns[] = 'listener_id';

                        $indy['listener_id'] = $query[0];

                        try
                        {
                            DB::insert('individual')
                                ->columns($columns)
                                ->values($indy)
                                ->execute();
                        }
                        catch(Database_Exception $e)
                        {
                            $this->ajax_msg($e->getMessage(), 'error');
                        }
                    }


                    $mail_content = View::factory('tmpmail/profile/registr')
                                        ->set('username', $listener['imya'])
                                        ->set('login', $email)
                                        ->set('pass', $newpass);

                    $message = View::factory('tmpmail/template', compact('mail_content'));

                    try
                    {
                        Email::factory('Вас зарегистрировал администратор Автошколы МПТ', $message, 'text/html')
                             ->to($email)
                             ->from('autompt@gmail.ru', 'Автошкола МПТ')
                             ->send();
                    }
                    catch(Swift_SwiftException $e)
                    {
                        $this->ajax_msg($e->getMessage(), 'error');
                    }

                    $role = array(1, 3);
                    $users->add('roles', $role);

                    $this->ajax_msg('Пользователь добавлен');
                }
                catch(ORM_Validation_Exception $e)
                {
                    $errors = $e->errors('validation');
                    $this->ajax_msg(array_shift($errors), 'error');
                }
            }
            else
            {
                $errors = $valid->errors('register_admin');
                $this->ajax_msg(array_shift($errors), 'error');
            }

        }
    }


    public function action_contract()
    {
        $this->auto_render = false;

        $doc = new Model_Documents();
        $post = (object)$this->request->post('contract');

        $listener = (object)$this->request->post('statement');

        if (Security::is_token($post->csrf) && $this->request->method() === Request::POST)
        {

            $korpys = isset($post->korpys) ? 'к. '.$post->korpys : null;

            $customer_vrem_reg =
                isset($post->vrem_reg)
                    ? ' - (временная)'
                    : null;

            $listener_vrem_reg =
                isset($listener->vrem_reg)
                    ? ' - (временная)'
                    : null;

            $obj = new TemplateDocx(APPPATH.'templates/contract/dogovor.docx');

            $obj->setValueArray(
                array(
                     'Customer' => $post->famil.' '.$post->imya.' '.$post->otch,
                     'CSeriya' => $post->document_seriya,
                     'CNomer' => $post->document_nomer,
                     'CVidan' => $post->document_kem_vydan,
                     'CAddress' =>
                         'регион: '.$post->region.
                         ' насел. пункт: '.$post->nas_pynkt.
                         ', район: '.$post->rion.
                         ', ул. '.$post->street.
                         ', д. '.$post->dom.
                         $korpys
                         .' кв. '.$post->kvartira
                         .$customer_vrem_reg,
                     'CPhone' => $post->tel,

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
                         .' кв. '.$listener->kvartira
                         .$listener_vrem_reg,
                     'LPhone' => $listener->tel,
                )
            );

            $file = 'temp/'.
                Text::translit($post->famil).'_'.
                Text::translit(UTF8::substr($post->imya, 0, 1)).'_'.
                Text::translit(UTF8::substr($post->otch, 0, 1)).'_'.
                'dogovor_'.date('d_m_Y_H_i_s').'.docx';


            $obj->save(APPPATH.'download/'.$file);
            unset($document);

            $this->ajax_data(
                array('file' => URL::site('viewdoc/'.$file))
            );
        }
    }

    public function action_index()
	{
        $nat = new Model_Nationality();
        $doc = new Model_Documents();
        $edu = new Model_Education();
        $s = Session::instance();

        $post = (object)$this->request->post('statement');

        if (Security::is_token($post->csrf) && $this->request->method() === Request::POST)
        {
            $nat_name = $nat->where('id', '=', $post->nationality_id)
                            ->find();

            $edu_name = $edu->where('id', '=', $post->education_id)
                            ->find();

            /*$docs_name = $doc->where('id', '=', $post->document_id)
                             ->find();
            $docs_name->name;*/

            $korpys = isset($post->korpys) ? 'к. '.$post->korpys : null;

            $document = new TemplateDocx(APPPATH.'templates/zayavlenie/template.docx');

            $document->setValueArray(
                array(
                     'Fam' => $post->famil,
                     'Name' => $post->imya,
                     'Otchestvo' => $post->otch,
                     'DateBirth' => $post->data_rojdeniya,
                     'Nationality' => $nat_name->name,
                     'PlaceBirth' => $post->mesto_rojdeniya,
                     'AdresRegPoPasporty' =>
                         'регион: '.$post->region.
                         ' насел. пункт: '.$post->nas_pynkt.
                         ', район: '.$post->rion.
                         ', ул. '.$post->street.
                         ', д. '.$post->dom.
                         $korpys
                         .' кв. '.$post->kvartira,
                     'VremReg' => isset($post->vrem_reg) ? 'Да' : 'Нет',
                     'Seriya' => $post->document_seriya,
                     'Nomer' => $post->document_nomer,
                     'Vidacha' => $post->document_data_vydachi,
                     'PasportKemVydan' => $post->document_kem_vydan,
                     'MobTel' => $post->tel,
                     'Email' => $post->email,
                     'Obrazovanie' => $edu_name->name,
                     'MestoRaboty' => $post->mesto_raboty,
                     'About' => $post->about,
                )
            );

            $file = 'temp/'.
                Text::translit($post->famil).'_'.
                Text::translit(UTF8::substr($post->imya, 0, 1)).'_'.
                Text::translit(UTF8::substr($post->otch, 0, 1)).'_'.
                'zayavlenie_'.date('d_m_Y_H_i_s').'.docx';

            $document->save(APPPATH.'download/'.$file);
            unset($document);

            $this->response->send_file(
                APPPATH.'download/'.$file, null, array('delete' => true)
            );
        }

        $this->template->content =
            View::factory('admin/createdocs/index')
                ->set('edu', $edu->find_all())
                ->set('national', $nat->find_all())
                ->set('type_doc', $doc->find_all());
	}

}












