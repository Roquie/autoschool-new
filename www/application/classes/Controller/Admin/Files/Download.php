<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Files_Download extends Controller_Admin_Base
{
    /**
     * session instance
     * @var null
     */
    protected $_s = null;
    
    public function before()
    {
        parent::before();
        
        $this->_s = Session::instance();
    }

    public function action_statement()
    {
        $file = $this->action_create_statement();

        $this->response->send_file(
            APPPATH.'download/'.$file, null, array('delete' => true)
        );
    }

    public function action_contract()
    {
        $file = $this->action_create_contract();

        $this->response->send_file(
            APPPATH.'download/'.$file, null, array('delete' => true)
        );
    }

    public function action_create_contract()
    {
        $id = $this->_s->get('checked_user');

        if (!empty($id))
        {
            $user = new Model_User($id);

            $indy = $user->listener->indy;
            $listener = $user->listener;

            $korpys_listener = isset($listener->korpys) ? 'к. '.$listener->korpys : null;
            $korpys_indy = isset($indy->korpys) ? 'к. '.$indy->korpys : null;

            $customer_vrem_reg =
                isset($indy->vrem_reg)
                    ? ' - (временная)'
                    : null;

            $listener_vrem_reg =
                isset($listener->vrem_reg)
                    ? ' - (временная)'
                    : null;

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
                             $korpys_indy
                             .' кв. '.$indy->kvartira
                             .$customer_vrem_reg,
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
                             $korpys_listener
                             .' кв. '.$listener->kvartira
                             .$listener_vrem_reg,
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
                             $korpys_listener
                             .' кв. '.$listener->kvartira
                             .$customer_vrem_reg,
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
                             $korpys_listener
                             .' кв. '.$listener->kvartira
                             .$listener_vrem_reg,
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
    }

    public function action_create_statement()
    {
        $id = $this->_s->get('checked_user');
        
        if (!empty($id))
        {
            $user = new Model_User($id);

            $listener = $user->listener;
            
            $nat = new Model_Nationality($listener->nationality_id);
            $edu = new Model_Education($listener->education_id);
            

            $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;

            $document = new TemplateDocx(APPPATH.'templates/zayavlenie/template.docx');

            $document->setValueArray(
                array(
                     'Fam' => $listener->famil,
                     'Name' => $listener->imya,
                     'Otchestvo' => $listener->otch,
                     'DateBirth' => $listener->data_rojdeniya,
                     'Nationality' => $nat->name,
                     'PlaceBirth' => $listener->mesto_rojdeniya,
                     'AdresRegPoPasporty' =>
                         'регион: '.$listener->region.
                         ' насел. пункт: '.$listener->nas_pynkt.
                         ', район: '.$listener->rion.
                         ', ул. '.$listener->street.
                         ', д. '.$listener->dom.
                         $korpys
                         .' кв. '.$listener->kvartira,
                     'VremReg' => isset($listener->vrem_reg) ? 'Да' : 'Нет',
                     'Seriya' => $listener->document_seriya,
                     'Nomer' => $listener->document_nomer,
                     'Vidacha' => $listener->document_data_vydachi,
                     'PasportKemVydan' => $listener->document_kem_vydan,
                     'MobTel' => $listener->tel,
                     'Email' => $user->email,
                     'Obrazovanie' => $edu->name,
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
        
    }




}