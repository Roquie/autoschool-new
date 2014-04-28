<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Files_Download extends Controller_Admin_Base
{

    public function before()
    {
        parent::before();

        $this->auto_render = false;

        $internal = array(
            'create_statement',
            'create_contract',
            'create_ticket',
            'create_personal_card',
            'create_pay_doc',
            'create_group_practice',
        );

        if (in_array($this->request->action(), $internal))
        {
            if(Request::initial() === Request::current())
                throw new HTTP_Exception_404();
        }
        else
        {
            $response = Request::factory('admin/files/download/create_'.$this->request->action())
                ->execute();

            $file = json_decode($response)->file;

            $this->response->send_file(
                APPPATH.'download/'.$file, null, array('delete' => true)
            );
        }

    }

    public function action_create_ticket()
    {
        $id = Session::instance()->get('checked_user');

        if (!empty($id))
        {
            $user = new Model_User($id);

/*            $indy = $user->listener->indy;*/
            $listener = $user->listener;

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

            $this->response->body(
                json_encode(array('file' => $file))
            );
        }

    }

    public function action_create_contract()
    {
        $id = Session::instance()->get('checked_user');

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

            $this->response->body(
                json_encode(array('file' => $file))
            );
        }
    }

    public function action_create_statement()
    {
        $id = Session::instance()->get('checked_user');
        
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

            $this->response->body(
                json_encode(array('file' => $file))
            );
        }
        
    }

    /**
     *  @TODO: Доделать вывод инструктора (его надо както достать)
     */

    public function action_create_personal_card()
    {
        $id = Session::instance()->get('checked_user');

        if (!empty($id))
        {
            $user = new Model_User($id);

            $listener = $user->listener;

            $nat = new Model_Nationality($listener->nationality_id);
            $edu = new Model_Education($listener->education_id);


            $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;

            $document = new TemplateDocx(APPPATH.'templates/personal_card/personal_card.docx');

            $instruct = Text::format_name($listener->staff->famil, $listener->staff->imya, $listener->staff->otch);

            $document->setValueArray(
                array(
                     'LastName' => $listener->famil,
                     'FirstName' => $listener->imya,
                     'DaddyName' => $listener->otch,
                     'GroupNumber' => empty($listener->group->name) ? '______' : $listener->group->name,
                     'LessonStart' => date('d.m.Y', strtotime($listener->group->data_start)),
                     'LessonEnd' => date('d.m.Y', strtotime($listener->group->data_end)),
                     'MarkaTS' => empty($listener->staff->transport->name) ? '____________' : $listener->staff->transport->name,
                     'GosNumber' => empty($listener->staff->transport->reg_number) ? '____________' : $listener->staff->transport->reg_number,
                     'StaffInstructor' => empty($instruct) ? '__________' : $instruct,
                     'DriveCategory' => empty($listener->group->category->name) ? '«B»' : '«'.$listener->group->category->name.'»',
                     'DATE' => date('Y'),
                )
            );

            $file = 'temp/'.
                Text::translit($listener->famil).'_'.
                Text::translit(UTF8::substr($listener->imya, 0, 1)).'_'.
                Text::translit(UTF8::substr($listener->otch, 0, 1)).'_'.
                'zayavlenie_'.date('d_m_Y_H_i_s').'.docx';

            $document->save(APPPATH.'download/'.$file);
            unset($document);

            $this->response->body(
                json_encode(array('file' => $file))
            );
        }
    }

    public function action_create_pay_doc()
    {
        $id = Session::instance()->get('checked_user');

        if (!empty($id))
        {
            $group = new Model_Groups(1);

            $ws = new Spreadsheet(
                array(
                     'author'       => 'auto.mpt.ru/admin',
                     'title'        => 'Список группы № '.$group->name,
                ));

            $ws->set_active_sheet(0);
            $as = $ws->get_active_sheet();
            $as->setTitle('Список группы № '.$group->name);

            $as->mergeCells('A1:G1');
            $as->mergeCells('A2:D2');
            $as->setCellValue('A1', 'Список группы № '.$group->name);
            $as->getStyle("A1:G1")->getFont()->setSize(24);
            $as->getStyle("A1:G1")->getFont()->setBold(true);
            $as->getStyle("A1:G1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A1:G1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $as->getStyle("A3:G3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A3:G3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $as->getStyle("A3:G3")->getFont()->setBold(true);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            );
            $as->getStyle("A3:G3")->applyFromArray($styleArray);


            $as->getColumnDimension('A')->setWidth(10);
            $as->getRowDimension('1')->setRowHeight(40);
            $as->getRowDimension('2')->setRowHeight(40);
            $as->getRowDimension('3')->setRowHeight(30);

            $as->getColumnDimension('B')->setWidth(40);
            $as->getColumnDimension('C')->setWidth(15);
            $as->getColumnDimension('D')->setWidth(15);
            $as->getColumnDimension('E')->setWidth(15);
            $as->getColumnDimension('F')->setWidth(15);
            $as->getColumnDimension('G')->setWidth(15);

            $data[3] = array(
                '№',
                'Фамилия Имя Отчество',
                'Паспорт',
                'Фото',
                'МЕД',
                Date::rdate('M', strtotime($group->data_start)),
                Date::rdate('M', strtotime(date('m', strtotime($group->data_start))+1))
            );

            $i = 0;
            foreach ($group->listener->find_all() as $k => $value)
            {
                ++$i;
                $data[$row = $k+4] = array(
                    $i,
                    $value->famil.' '.$value->imya.' '.$value->otch,
                    '-',
                    '-',
                    '-',
                    0,
                    0
                );

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );

                $and_formuls = $row + 4;
                $as->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
                $as->getStyle('A'.$row.':G'.$and_formuls)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $as->getStyle('A'.$row.':G'.$and_formuls)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }

            $formula1 = "=SUM(F4:F$row)";
            $formula2 = "=SUM(G4:G$row)";

            $sum = $row + 3;
            $total_formula = "=SUM(F$sum:G$sum)";
            $total = $sum + 1;

            $as->setCellValue('F'.$sum, $formula1);
            $as->setCellValue('G'.$sum, $formula2);
            $as->setCellValue('F'.$total, 'Итого:');
            $as->setCellValue('G'.$total, $total_formula);


            $ws->set_data($data, false);

            $file = $ws->save(array('name' => 'pay_docs.list_group-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );

        }
    }

    /**
     * Создание списка слушателей по группе, на обучение практическому вождению
     *
     * @TODO: Доделать вывод инструкторов (их надо както достать)
     */
    public function action_create_group_practice()
    {
        $id = Session::instance()->get('checked_user');

        if (!empty($id))
        {
            $group = new Model_Groups(1);

            $ws = new Spreadsheet(
                array(
                    'author'       => 'auto.mpt.ru/admin',
                    'title'        => 'Список группы № '.$group->name,
                ));

            $ws->set_active_sheet(0);
            $as = $ws->get_active_sheet();
            $as->setTitle('Список группы № '.$group->name);

            $as->mergeCells('A1:E1');
            $as->setCellValue('A1', 'Список группы № '.$group->name);
            $as->getStyle("A1:E1")->getFont()->setSize(24);
            $as->getStyle("A1:E1")->getFont()->setBold(true);
            $as->getStyle("A1:E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A1:E1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $as->getStyle("A2:E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A2:E2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $as->getStyle("A2:F2")->getFont()->setBold(true);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            );
            $as->getStyle("A2:E2")->applyFromArray($styleArray);


            $as->getColumnDimension('A')->setWidth(10);
            $as->getRowDimension('1')->setRowHeight(40);
            $as->getRowDimension('2')->setRowHeight(30);

            $as->getColumnDimension('B')->setWidth(40);
            $as->getColumnDimension('C')->setWidth(15);
            $as->getColumnDimension('D')->setWidth(20);
            $as->getColumnDimension('E')->setWidth(45);

            $data[2] = array(
                '№',
                'Фамилия Имя Отчество',
                'Дата рождения',
                'Телефон',
                'МАСТЕР ПРОИЗВОДСТВЕННОГО ОБУЧЕНИЯ',
            );

            $i = 0;

            foreach ($group->listener->find_all() as $k => $value)
            {
                ++$i;
                $data[$row = $k+3] = array(
                    $i,
                    $value->famil.' '.$value->imya.' '.$value->otch,
                    date('d.m.Y', strtotime($value->data_rojdeniya)),
                    $value->tel,
                    $value->staff->famil.' '.$value->staff->imya.' '.$value->staff->otch,
                );

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );

                $as->getStyle('A'.$row.':E'.$row)->applyFromArray($styleArray);
                $as->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $as->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }


            $ws->set_data($data, false);

            $file = $ws->save(array('name' => 'practice.list_group-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );

        }
    }



}