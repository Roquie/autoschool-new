<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files_Print extends Controller_Admin_Base
{
    protected $_convert_docx_url = 'http://am3-word-view.officeapps.live.com/wv/WordViewer/request.pdf?WOPIsrc=http%3A%2F%2Fam3-15-view-wopi%2Ewopi%2Elive%2Enet%3A808%2Foh%2Fwopi%2Ffiles%2F%40%2FwFileId%3FwFileId%3D';

    /*protected $_convert_xlsx_url = 'http://am3-excel.officeapps.live.com/x/16.0.2731.3502/_layouts/xlprintview.aspx?&NoAuth=1&sessionId=12.5df9226c1e271.A74.1.V25.14519IoDZMeXzRg6nqYXxvYyy14.5.ru-RU5.ru-RU17.roquie.tk-Private1.S1.N&useSelection=0&usedRange=%27%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA%20%D0%B3%D1%80%D1%83%D0%BF%D0%BF%D1%8B%20%E2%84%96%2001-14%27!A1%3AH10&selectedRange=%27%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA%20%D0%B3%D1%80%D1%83%D0%BF%D0%BF%D1%8B%20%E2%84%96%2001-14%27!B10&title=pay_docs.list_group-01-14_1398598380.xlsx&isPostBack=true';*/


    public function before()
    {
        parent::before();
        $this->auto_render = false;

        $access = array(
            'statement',
            'contract',
            'ticket',
            'personal_card',
            'pay_doc',
            'group_practice',
            'listmed',
            'list_books',
            'ekz_protokol',
            'distrib',
        );

        if (in_array($this->request->action(), $access))
        {
            $response = Request::factory('admin/files/download/create_'.$this->request->action())
                               ->execute();

            $data = json_decode($response);
            $file_info = pathinfo($data->file);

            if ($file_info['extension'] === 'docx')
            {
                HTTP::redirect(
                    $this->_convert_docx_url.
                    urlencode(
                        URL::site('viewdoc/'.$data->file)
                    ).'&type=printpdf'
                );
            }
            elseif($file_info['extension'] === 'xlsx')
            {
                ob_start();
                    $this->_excel_to_html(APPPATH.'download/'.$data->file);
                $content = ob_get_clean();

                View::factory('admin/files/print_xlsx', compact('content'))->render();
            }

        }

    }

    public function action_other()
    {
        $url = $this->request->query('url');

        HTTP::redirect(
            $this->_convert_docx_url.
            urlencode(
                $url
            ).'&type=printpdf'
        );
    }

    protected function _excel_to_html($path_to_xlsx)
    {
        $excel = PHPExcel_IOFactory::load($path_to_xlsx);
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        $writer = PHPExcel_IOFactory::createWriter($excel, 'HTML');

        $writer->setUseInlineCSS(true);
        $writer->save('php://output');
        unset($excel, $writer);
        unlink($path_to_xlsx);
    }

   /* protected function _create_excel_url($title, $file_url)
    {
        $file_url = urlencode(URL::site('viewdoc/'.$file_url));
        $url = "http://am3-excel.officeapps.live.com/x/16.0.2731.3502/_layouts/xlprintview.aspx?&NoAuth=1&sessionId=12.5df9226c1e271.A74.1.V25.848478aKMmKekxZCUZnysMuGU14.5.ru-RU5.ru-RU17.roquie.tk-Private1.S1.N&useSelection=0&usedRange=%27%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA%20%D0%B3%D1%80%D1%83%D0%BF%D0%BF%D1%8B%20%E2%84%96%2001-14%27!A1%3AH10&title=".$title."&isPostBack=true";
        return $url;
    }*/

}