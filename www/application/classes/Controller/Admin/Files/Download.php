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
            'create_listmed',
            'create_list_books',
            'create_ekz_protokol',
            'create_distrib',
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
                    UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
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

            $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $as->getPageSetup()->setFitToPage(true);
            $as->getPageSetup()->setFitToWidth(1);
            $as->getPageSetup()->setFitToHeight(0);

            $file = $ws->save(array('name' => 'pay_docs.list_group-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );

        }
    }

    /**
     * Создание списка слушателей по группе, на обучение практическому вождению
     *
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
                    UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                    date('d.m.Y', strtotime($value->data_rojdeniya)),
                    $value->tel,
                    UTF8::strtoupper($value->staff->famil).' '.UTF8::strtoupper($value->staff->imya).' '.UTF8::strtoupper($value->staff->otch),
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

            $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $as->getPageSetup()->setFitToPage(true);
            $as->getPageSetup()->setFitToWidth(1);
            $as->getPageSetup()->setFitToHeight(0);

            $file = $ws->save(array('name' => 'practice.list_group-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );

        }
    }


    public function action_create_listmed()
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

            $as->mergeCells('A1:D1');
            $as->mergeCells('A2:D2');
            $as->setCellValue('A1', 'Список группы № '.$group->name);
            $as->getStyle("A1:D1")->getFont()->setSize(24);
            $as->getStyle("A1:D1")->getFont()->setBold(true);

            $as->setCellValue('A2', 'Медкомиссия');
            $as->getStyle("A2:D2")->getFont()->setSize(21);
            $as->getStyle("A2:D2")->getFont()->setBold(true);

            $as->getStyle("A1:D3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A1:D3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'font' => array(
                    'bold' => true
                )
            );
            $as->getStyle("A3:D3")->applyFromArray($styleArray);


            $as->getColumnDimension('A')->setWidth(10);
            $as->getRowDimension('1')->setRowHeight(40);
            $as->getRowDimension('2')->setRowHeight(40);
            $as->getRowDimension('3')->setRowHeight(30);

            $as->getColumnDimension('B')->setWidth(40);
            $as->getColumnDimension('C')->setWidth(40);
            $as->getColumnDimension('D')->setWidth(40);

            $data[3] = array(
                '№',
                'Фамилия Имя Отчество',
                'Принял',
                'Сдал(а)',
            );

            $i = 0;
            foreach ($group->listener->find_all() as $k => $value)
            {
                ++$i;
                $data[$row = $k+4] = array(
                    $i,
                    UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                    null,
                    null,
                );

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $as->getStyle('A'.$row.':D'.$row)->applyFromArray($styleArray);
            }

            $ws->set_data($data, false);

            $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $as->getPageSetup()->setFitToPage(true);
            $as->getPageSetup()->setFitToWidth(1);
            $as->getPageSetup()->setFitToHeight(0);

            $file = $ws->save(array('name' => 'list_med.-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );
        }
    }


    public function action_create_list_books()
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

            $as->mergeCells('A1:I1');
            $as->mergeCells('A2:I2');
            $as->setCellValue('A1', 'Список группы № '.$group->name);
            $as->getStyle("A1:I1")->getFont()->setSize(24);
            $as->getStyle("A1:I1")->getFont()->setBold(true);

            $as->setCellValue('A2', 'ЛИТЕРАТУРА');
            $as->getStyle("A2:I2")->getFont()->setSize(21);
            $as->getStyle("A2:I2")->getFont()->setBold(true);

            $as->getStyle("A1:I3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A1:I3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'font' => array(
                    'bold' => true
                )
            );
            $as->getStyle("A3:I3")->applyFromArray($styleArray);


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
            $as->getColumnDimension('H')->setWidth(40);
            $as->getColumnDimension('I')->setWidth(40);

            $data[3] = array(
                '№',
                'Фамилия Имя Отчество',
                'ПДД (100р)',
                'Задачник (250р)',
                'Билеты (250р)',
                'Мед (100р)',
                'В ГАИ (100р)',
                'Принял',
                'Сдал(а)',
            );

            $i = 0;
            foreach ($group->listener->find_all() as $k => $value)
            {
                ++$i;
                $data[$row = $k+4] = array(
                    $i,
                    UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                );

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $as->getStyle('A'.$row.':I'.$row)->applyFromArray($styleArray);
            }

            $ws->set_data($data, false);

            $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $as->getPageSetup()->setFitToPage(true);
            $as->getPageSetup()->setFitToWidth(1);
            $as->getPageSetup()->setFitToHeight(0);

            $file = $ws->save(array('name' => 'list_books.-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );
        }
    }


    public function action_create_ekz_protokol()
    {
        $id = Session::instance()->get('checked_user');

        if (!empty($id))
        {
            $group = new Model_Groups(1);

            $ws = new Spreadsheet(
                array(
                     'author'       => 'auto.mpt.ru/admin',
                     'title'        => 'ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ, гр. '.$group->name,
                ));

            $ws->set_active_sheet(0);
            $as = $ws->get_active_sheet();
            $as->setTitle('ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ');

            $as->mergeCells('A1:J1');
            $as->mergeCells('A2:J2');
            $as->setCellValue('A1', 'ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ');
            $as->getStyle("A1:J1")->getFont()->setSize(24);
            $as->getStyle("A1:J1")->getFont()->setBold(true);

            $as->setCellValue('A2', 'ГРУППЫ № '.$group->name);
            $as->getStyle("A2:J2")->getFont()->setSize(21);
            $as->getStyle("A2:J2")->getFont()->setBold(true);

            $as->getStyle("A1:J3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $as->getStyle("A1:J3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'font' => array(
                    'bold' => true
                )
            );
            $as->getStyle("A3:J3")->applyFromArray($styleArray);


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
            $as->getColumnDimension('H')->setWidth(15);
            $as->getColumnDimension('I')->setWidth(15);
            $as->getColumnDimension('J')->setWidth(15);

            $data[3] = array(
                '№',
                'Фамилия Имя Отчество',
                'Дата рождения',
                'ОЗДД',
                'УиТ АС',
                'ОБУ ТС',
                'ПП',
                'Вожд.',
                'Свидетельство',
                'Подпись',
            );



            $i = 0;
            foreach ($group->listener->find_all() as $k => $value)
            {
                ++$i;
                $data[$row = $k+4] = array(
                    $i,
                    UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                    date('d.m.Y', strtotime($value->data_rojdeniya)),
                    'удовл.',
                    'удовл.',
                    'удовл.',
                    'удовл.',
                    'удовл.',
                    $value->certificate_seriya.' '.$value->certificate_nomer,
                );

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $as->getStyle('A'.$row.':J'.$row)->applyFromArray($styleArray);

                $to_text = $row + 3;

            }
            $start = $to_text;

            $as->setCellValue('A'.$to_text, 'Всего:');
            $as->setCellValue('B'.$to_text, $i.' чел.');

            $to_text += 1;
            $as->mergeCells('A'.$to_text.':B'.$to_text);
            $as->setCellValue('A'.$to_text, 'Из них с оценками');

            $to_text += 1;
            $as->mergeCells('A'.$to_text.':F'.$to_text);
            $as->setCellValue('A'.$to_text, '«отлично» 0 чел.,  «хорошо» 0 чел.,  «удовлетворительно» '.$i.' чел.,  «неудовлетворительно»  0 чел.');

            $to_text += 2;
            $as->mergeCells('A'.$to_text.':B'.$to_text);
            $as->setCellValue('A'.$to_text, 'Председатель комиссии _______________');

            $to_text += 2;
            $as->mergeCells('A'.$to_text.':C'.$to_text);
            $as->setCellValue('A'.$to_text, 'Члены комиссии _________________  _________________');

            $as->mergeCells('E'.$to_text.':G'.$to_text);
            $as->setCellValue('E'.$to_text, 'Директор а/ш МПТ РГТЭУ _____________');

            $as->getStyle('A'.$start.':G'.$to_text)->getFont()->setBold(true);

            $ws->set_data($data, false);

            $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $as->getPageSetup()->setFitToPage(true);
            $as->getPageSetup()->setFitToWidth(1);
            $as->getPageSetup()->setFitToHeight(0);

            $file = $ws->save(array('name' => 'ekz_protokol.-'.$group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

            $this->response->body(
                json_encode(array('file' => 'temp/'.$file))
            );
        }
    }

    /**
     * Неутвержденные слушатели
     */
    public function action_create_distrib()
    {

        $listeners = new Model_Listeners();
        $distrib = $listeners->where('status', '<', 3)->find_all();

        $ws = new Spreadsheet(
            array(
                 'author'       => 'auto.mpt.ru/admin',
                 'title'        => 'Неутвержденные слушатели',
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Неутвержденные слушатели');

        $as->mergeCells('A1:D1');
        $as->mergeCells('A2:D2');
        $as->setCellValue('A1', 'Неутвержденные слушатели');
        $as->getStyle("A1:D1")->getFont()->setSize(24);
        $as->getStyle("A1:D1")->getFont()->setBold(true);

        $as->getStyle("A1:D3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $as->getStyle("A1:D3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'font' => array(
                'bold' => true
            )
        );
        $as->getStyle("A3:D3")->applyFromArray($styleArray);


        $as->getColumnDimension('A')->setWidth(10);
        $as->getRowDimension('1')->setRowHeight(40);
        $as->getRowDimension('2')->setRowHeight(40);
        $as->getRowDimension('3')->setRowHeight(30);

        $as->getColumnDimension('B')->setWidth(40);
        $as->getColumnDimension('C')->setWidth(15);
        $as->getColumnDimension('D')->setWidth(60);

        $data[3] = array(
            '№',
            'Фамилия Имя Отчество',
            'Дата рождения',
            'Причина (каких документов не хватает)',
        );

        $i = 0;
        foreach ($distrib as $k => $value)
        {
            ++$i;
            $data[$row = $k+4] = array(
                $i,
                UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                date('d.m.Y', strtotime($value->data_rojdeniya)),
                $value->description_status,
            );

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );

            $as->getStyle('A'.$row.':D'.$row)->applyFromArray($styleArray);
        }

        $ws->set_data($data, false);

        $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $as->getPageSetup()->setFitToPage(true);
        $as->getPageSetup()->setFitToWidth(1);
        $as->getPageSetup()->setFitToHeight(0);

        $file = $ws->save(array('name' => 'distrib', 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );

    }

}




//create word
/*
        $group = new Model_Groups(1);

        $PHPWord = new PhpWord();

        $section = $PHPWord->createSection(
            array(
                 'marginLeft' => 600,
                 'marginRight' => 600,
                 'marginTop' => 600,
                 'marginBottom' => 600,
                 'orientation' => 'landscape'
            )
        );

        $styleFont = array(
            'name' => 'Times New Roman',
            'size' => 12,
            'bold' => true,
            'align' => 'center'
        );
        $styleCellFont = array(
            'name' => 'Times New Roman',
            'size' => 12,
            'align' => 'center',
            'spaceAfter' => 0
        );

        $styleCellAligment = array(
            'valign' => 'center',
            'spaceAfter' => 0,
            'marginBottom' => 0
        );
        $section->addText('ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ', $styleFont,
            array(
                 'align' => 'center',
                 'spaceAfter' => 1
            )
        );
        $section->addText('ГРУППЫ № '.$group->name, $styleFont, array('align' => 'center'));

        $styleTable = array('borderSize' => 6, 'borderColor'=>'000000', 'cellMargin' => 0, 'border' => 'black');
        $styleFirstRow = array('bold' => true, 'name' => 'Times New Roman', 'size' => 12, 'align' => 'center', );

        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

        $table = $section->addTable('myOwnTableStyle');

        $table->addRow(100);
        $table->addCell(60, $styleCellAligment)->addText('№', $styleFirstRow);
        $table->addCell(4000, $styleCellAligment)->addText('Фамилия Имя Отчество', $styleFirstRow);
        $table->addCell(1600, $styleCellAligment)->addText('Дата рождения', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('ОЗДД', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('УиТ АС', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('ОБУ ТС', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('ПП', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('Вожд.', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('Свидетельство', $styleFirstRow);
        $table->addCell(1500, $styleCellAligment)->addText('Подпись', $styleFirstRow);


        $lol = 'удовл.';
        $i = 0;
        foreach($group->listener->find_all() as $k => $value)
        {
            $table->addRow(0);
            $name = UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch);

            $table->addCell(60, $styleCellAligment)->addText(++$i, $styleCellFont);
            $table->addCell(4000, $styleCellAligment)->addText($name, $styleCellFont);
            $table->addCell(1600, $styleCellAligment)->addText($value->data_rojdeniya, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText($lol, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText($lol, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText($lol, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText($lol, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText($lol, $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText('хз', $styleCellFont);
            $table->addCell(1500, $styleCellAligment)->addText(null, $styleCellFont);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save('Section.docx');*/
