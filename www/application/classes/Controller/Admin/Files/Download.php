<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Files_Download extends Controller_Admin_Base
{

    protected $_group = null;
    protected $_listener = null;
    protected $_user = null;

    public function before()
    {
        parent::before();

        $this->auto_render = false;
        $id = Session::instance()->get('checked_user');

        if (empty($id))
        {
            throw new HTTP_Exception_404();
        }

        $this->_group = ORM::factory('User',  $id)->listener->group;
        $this->_listener = ORM::factory('User',  $id)->listener;
        $this->_user = ORM::factory('User',  $id);

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
            'create_distrib_all_info',
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
        $obj = new TemplateDocx(APPPATH.'templates/ticket/ticket.docx');

        $famil = UTF8::ucfirst(UTF8::strtolower($this->_listener->famil));
        $imya = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($this->_listener->imya, 0, 1).'. '));
        $ot4estvo = UTF8::ucfirst(UTF8::strtolower(UTF8::substr($this->_listener->otch, 0, 1).'.'));

        $obj->setValueArray(array(
            'BigName' => $famil.' '.UTF8::ucfirst(UTF8::strtolower($this->_listener->imya)).' '.UTF8::ucfirst(UTF8::strtolower($this->_listener->otch)),
            'Customer' => $famil.' '.$imya.' '.$ot4estvo,
            'NumberContract' => $this->_listener->number_contract,
            'GroupNumber' => $this->_listener->group->name,
        ));

        $file = 'temp/'.
            Text::translit($this->_listener->famil).'_'.
            Text::translit(UTF8::substr($this->_listener->imya, 0, 1)).'_'.
            Text::translit(UTF8::substr($this->_listener->otch, 0, 1)).'_'.
            'kvitanciya_'.date('d_m_Y_H_i_s').'.docx';

        $obj->save(APPPATH.'download/'.$file);
        unset($document);

        $this->response->body(
            json_encode(array('file' => $file))
        );

    }

    public function action_create_contract()
    {
        $indy = $this->_listener->indy;
        $listener = $this->_listener;

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

        $dateContract = Text::check_date($listener->date_contract);
        !empty($dateContract) ?: $dateContract = '«_____»_____________201___года';

        $obj = new TemplateDocx(APPPATH.'templates/contract/dogovor.docx');

        if ($listener->is_individual)
        {
            $obj->setValueArray(
                array(
                     'Customer' => $indy->famil.' '.$indy->imya.' '.$indy->otch,
                     'NumberContract' => isset($listener->number_contract) ?  $listener->number_contract : '_______________',
                     'DateContract' => $dateContract,
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
                     'NumberContract' =>  isset($listener->number_contract) ?  $listener->number_contract : '_______________',
                     'DateContract' => $dateContract,
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

    public function action_create_statement()
    {
        $listener = $this->_listener;

        $nat = new Model_Nationality($listener->nationality_id);
        $edu = new Model_Education($listener->education_id);


        $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;

        $document = new TemplateDocx(APPPATH.'templates/zayavlenie/template.docx');

        $document->setValueArray(
            array(
                 'Fam' => $listener->famil,
                 'Name' => $listener->imya,
                 'Otchestvo' => $listener->otch,
                 'DateBirth' => Text::check_date($listener->data_rojdeniya),
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
                 'Vidacha' => Text::check_date($listener->document_data_vydachi),
                 'PasportKemVydan' => $listener->document_kem_vydan,
                 'MobTel' => $listener->tel,
                 'Email' => $this->_user->email,
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


    public function action_create_personal_card()
    {
        $listener = $this->_listener;

        $nat = new Model_Nationality($listener->nationality_id);
        $edu = new Model_Education($listener->education_id);

        $korpys = isset($listener->korpys) ? 'к. '.$listener->korpys : null;

        $document = new TemplateDocx(APPPATH.'templates/personal_card/personal_card.docx');

        $instruct = Text::format_name($listener->staff->famil, $listener->staff->imya, $listener->staff->otch);

        $document->setValueArray(
            array(
                 'LastName' => $listener->famil ?: '-',
                 'FirstName' => $listener->imya ?: '-',
                 'DaddyName' => $listener->otch ?: '-',
                 'GroupNumber' => empty($listener->group->name) ? '______' : $listener->group->name,
                 'LessonStart' => Text::check_date($listener->group->data_start) ?: '-',
                 'LessonEnd' => Text::check_date($listener->group->data_end) ?: '-',
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

    public function action_create_pay_doc()
    {
        $ws = new Spreadsheet(
            array(
                 'author'       => 'auto.mpt.ru/admin',
                 'title'        => 'Список группы № '.$this->_group->name,
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Список группы № '.$this->_group->name);

        $as->mergeCells('A1:G1');
        $as->mergeCells('A2:D2');
        $as->setCellValue('A1', 'Список группы № '.$this->_group->name);
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
            Date::rdate('M', strtotime($this->_group->data_start)),
            Date::rdate('M', strtotime(date('m', strtotime($this->_group->data_start))+1))
        );

        $i = 0;
        foreach ($this->_group->listener->find_all() as $k => $value)
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

        $file = $ws->save(array('name' => 'pay_docs.list_group-'.$this->_group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );
    }

    /**
     * Создание списка слушателей по группе, на обучение практическому вождению
     *
     */
    public function action_create_group_practice()
    {
        $ws = new Spreadsheet(
            array(
                'author'       => 'auto.mpt.ru/admin',
                'title'        => 'Список группы № '.$this->_group->name,
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Список группы № '.$this->_group->name);

        $as->mergeCells('A1:E1');
        $as->setCellValue('A1', 'Список группы № '.$this->_group->name);
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

        foreach ($this->_group->listener->find_all() as $k => $value)
        {
            ++$i;
            $data[$row = $k+3] = array(
                $i,
                UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                Text::check_date($value->data_rojdeniya) ?: '-',
                $value->tel ?: '-',
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

        $file = $ws->save(array('name' => 'practice.list_group-'.$this->_group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );
    }


    public function action_create_listmed()
    {
        $ws = new Spreadsheet(
            array(
                'author'       => 'auto.mpt.ru/admin',
                'title'        => 'Список группы № '.$this->_group->name,
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Список группы № '.$this->_group->name);

        $as->mergeCells('A1:D1');
        $as->mergeCells('A2:D2');
        $as->setCellValue('A1', 'Список группы № '.$this->_group->name);
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
        foreach ($this->_group->listener->find_all() as $k => $value)
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

        $file = $ws->save(array('name' => 'list_med.-'.$this->_group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );

    }


    public function action_create_list_books()
    {
        $ws = new Spreadsheet(
            array(
                'author'       => 'auto.mpt.ru/admin',
                'title'        => 'Список группы № '.$this->_group->name,
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Список группы № '.$this->_group->name);

        $as->mergeCells('A1:I1');
        $as->mergeCells('A2:I2');
        $as->setCellValue('A1', 'Список группы № '.$this->_group->name);
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
        foreach ($this->_group->listener->find_all() as $k => $value)
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

        $file = $ws->save(array('name' => 'list_books.-'.$this->_group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );
    }


    public function action_create_ekz_protokol()
    {
        $ws = new Spreadsheet(
            array(
                 'author'       => 'auto.mpt.ru/admin',
                 'title'        => 'ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ, гр. '.$this->_group->name,
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ');

        $as->mergeCells('A1:J1');
        $as->mergeCells('A2:J2');
        $as->setCellValue('A1', 'ЭКЗАМЕНАЦИОННЫЙ ПРОТОКОЛ');
        $as->getStyle("A1:J1")->getFont()->setSize(24);
        $as->getStyle("A1:J1")->getFont()->setBold(true);

        $as->setCellValue('A2', 'ГРУППЫ № '.$this->_group->name);
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
        foreach ($this->_group->listener->find_all() as $k => $value)
        {
            ++$i;
            $data[$row = $k+4] = array(
                $i,
                UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                Text::check_date($value->data_rojdeniya)   ?: '-',
                'удовл.',
                'удовл.',
                'удовл.',
                'удовл.',
                'удовл.',
                $value->certificate_seriya ?: '-' .' '.$value->certificate_nomer ?: '-',
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

        $file = $ws->save(array('name' => 'ekz_protokol.-'.$this->_group->name, 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

        $this->response->body(
            json_encode(array('file' => 'temp/'.$file))
        );
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
                Text::check_date($value->data_rojdeniya)   ?: '-',
                $value->description_status   ?: '-',
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

    public function action_create_distrib_all_info()
    {
        $listeners = new Model_Listeners();
        $distrib = $listeners->where('status', '<', 3)->find_all();

        $ws = new Spreadsheet(
            array(
                'author'       => 'auto.mpt.ru/admin',
                'title'        => 'Список всех слушателей подавших заявку',
            ));

        $ws->set_active_sheet(0);
        $as = $ws->get_active_sheet();
        $as->setTitle('Неутвержденные слушатели');

        $as->mergeCells('A1:N1');
        $as->setCellValue('A1', 'Список всех слушателей подавших заявку');
        $as->getStyle("A1:N1")->getFont()->setSize(19);
        $as->getStyle("A1:N1")->getFont()->setBold(true);



        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'font' => array(
                'bold' => true,
                'size' => 10
            )
        );
        $as->getStyle("A3:N3")->applyFromArray($styleArray);


        $as->getColumnDimension('A')->setWidth(5);
        $as->getRowDimension('1')->setRowHeight(40);
        $as->getRowDimension('3')->setRowHeight(30);

        $as->getColumnDimension('B')->setWidth(33);
        $as->getColumnDimension('C')->setWidth(15);
        $as->getColumnDimension('D')->setWidth(13);
        $as->getColumnDimension('E')->setWidth(7);
        $as->getColumnDimension('F')->setWidth(15);
        $as->getColumnDimension('G')->setWidth(30);
        $as->getColumnDimension('H')->setWidth(10);
        $as->getColumnDimension('I')->setWidth(8);
        $as->getColumnDimension('J')->setWidth(8);
        $as->getColumnDimension('K')->setWidth(12);
        $as->getColumnDimension('L')->setWidth(30);
        $as->getColumnDimension('M')->setWidth(20);
        $as->getColumnDimension('N')->setWidth(26);


        $data[3] = array(
            '№',
            'Фамилия Имя Отчество',
            'Tел.моб.',
            'Дата рождения',
            'Гр-во',
            'Место рождения',
            'Адр. регистрации',
            'Врем. рег-я',
            'П. серия',
            'П. номер',
            'Дата выдачи',
            'Кем выдан',
            'Email',
            'Обр-ие',
        );

        $i = 0;
        foreach ($distrib as $k => $value)
        {
            $korpys = isset($value->korpys) ? 'к. '.$value->korpys : null;
            ++$i;
            $data[$row = $k+4] = array(
                $i,
                UTF8::strtoupper($value->famil).' '.UTF8::strtoupper($value->imya).' '.UTF8::strtoupper($value->otch),
                $value->tel ?: '-',
                Text::check_date($value->data_rojdeniya) ?: '-',
                $value->national->name ?: '-',
                $value->mesto_rojdeniya  ?: '-',
                'регион: '.$value->region.
                ' насел. пункт: '.$value->nas_pynkt.
                ', район: '.$value->rion.
                ', ул. '.$value->street.
                ', д. '.$value->dom.
                $korpys
                .' кв. '.$value->kvartira,
                isset($value->vrem_reg) ? 'Да' : 'Нет',
                $value->document_seriya ?: '-',
                $value->document_nomer ?: '-',
                Text::check_date($value->document_data_vydachi) ?: '-',
                $value->document_kem_vydan ?: '-',
                $value->user->email ?: '-',
                $value->edu->name ?: '-',
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
                ),
                'font' => array(
                    'size' => 10
                )
            );

            $as->getStyle('A'.$row.':N'.$row)->applyFromArray($styleArray);
        }

        $ws->set_data($data, false);

        $as->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $as->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $as->getPageSetup()->setFitToPage(true);
        $as->getPageSetup()->setFitToWidth(1);
        $as->getPageSetup()->setFitToHeight(0);

        $file = $ws->save(array('name' => 'distrib_all_info', 'format' => 'Excel2007', 'path' => APPPATH.'download/temp/'));

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
