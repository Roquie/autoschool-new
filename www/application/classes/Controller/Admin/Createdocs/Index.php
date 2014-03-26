<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Createdocs_Index extends Controller_Admin_Base
{
    protected $_createdocs = null;

    public function before()
    {
        parent::before();

        $this->_createdocs = new View('admin/createdocs/template');
        $this->_createdocs->content = null;
    }

    public function action_contract_check()
    {
        $s = Session::instance();
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && Request::initial()->is_ajax())
        {
            if ($s->get('st_createdocs'))
            {
                $this->ajax_data(
                    $s->get('st_createdocs')
                );
            }
        }
    }

    public function action_next()
    {
        $post = $this->request->post();
        $s = Session::instance();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $s->set('st_createdocs', $post);

            HTTP::redirect('admin/createdocs/contract');
        }
    }

    public function action_contract()
    {
        $doc = new Model_Documents();
        $post = (object)$this->request->post();

        $s = Session::instance();
        $listener = (object)$s->get('st_createdocs');

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

            $this->response->send_file(
                APPPATH.'download/'.$file, null, array('delete' => true)
            );
        }

        $this->_createdocs->content =
            View::factory('admin/createdocs/contract')
                ->set('type_doc', $doc->find_all());
    }

    public function action_index()
	{
        $nat = new Model_Nationality();
        $doc = new Model_Documents();
        $edu = new Model_Education();
        $s = Session::instance();

        $post = (object)$this->request->post();

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

        $this->_createdocs->content =
            View::factory('admin/createdocs/index')
                ->set('edu', $edu->find_all())
                ->set('national', $nat->find_all())
                ->set('type_doc', $doc->find_all());
	}

    public function after()
    {
        $this->template->content = $this->_createdocs->render();
        parent::after();
    }
}











