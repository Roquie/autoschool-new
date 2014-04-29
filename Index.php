<?php defined('SYSPATH') or die('No direct script access.');
use XBase\Table;
use XBase\Column;
use XBase\WritableTable;

class Controller_Admin_Index extends Controller_Admin_Base
{

    public function action_index()
	{
        $this->auto_render = false;


        /*$def = array(
            array("date",     "D"),
            array("name",     "C",  50),
            array("age",      "N",   3, 0),
            array("email",    "C", 128),
            array("ismember", "L")
        );

        if (!dbase_create(APPPATH.'download/temp/test.dbf', $def)) {
            echo "Ошибка, не получается создать базу данных\n";
        }*/



        $file = APPPATH.'download/temp/s338D5M1.dbf';
        $created = APPPATH.'download/temp/create.dbf';
        $db = dbase_open(APPPATH.'download/temp/test.dbf', 0);


        //echo_dbf($file);

        $arr = get_dbf_header($file);


       /* echo '<pre>';
        print_r($arr);
        echo '</pre>';*/
        //$table = new Table($file);
        ;

       /* while ($record = $table->nextRecord()) {
            echo $record->getChar('name');
        }*/


       /* echo '<pre>';
        print_r($arr);
        echo '</pre>';*/
        /* sample data */
        //Имя файла
        $def = array(
            array("id","N",8,0), //Идентификатор, целое число
            array("FNAME", "C", 32, 0), //Имя, строка
            array("C2", "C", 32, 0), //Имя, строка
            array("FNAME", "C", 32, 0), //Имя, строка
            array("weight","N",2,2), //Вес, дробное
        );

        $filename = "Users.dbf";


       /* //Столбцы

        //Создем файл
        $DBF = dbase_create($created, $def);

        //Получаем данные из MySQL


        //Добавляем строку в файл dbf
        dbase_add_record($DBF, array('ЛОХ', 1, 12));

        dbase_close($DBF);*/




        echo_dbf($file);

        $lol = new DbaseReader($file);

        echo '<pre>';
        print_r($lol->fetchAll());
        echo '</pre>';




        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Groups')->find_all();
        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();


        $this->template->content = View::factory('admin/index', compact('list_users', 'list_groups', 'edu', 'national', 'type_doc'));
	}
	



}




class DbaseReader
{

    /**
     * Resource associated to the dbf file
     * @var resource
     */
    protected $_filePointer = null;

    /**
     * Path to the dbf file
     * @var string
     */
    protected $_fileName = null;

    /**
     * Headers of the dbf file
     * @var array
     */
    protected $_headers = null;

    /**
     * Fields headers
     * @var array
     */
    protected $_infos = null;

    /**
     * Unpack string build with fields headers
     * @var string
     */
    protected $_unpackString = '';

    /**
     * All data of the dbf file
     * @var array
     */
    protected $_data = null;

    /**
     * DbaseReader constructor: open the file and retrieve the headers
     * @param string $fileName Dbf filename
     */
    public function  __construct($fileName)
    {
        $this->_fileName = $fileName;
        if (!file_exists($fileName) || !\is_readable($fileName)) {
            throw new \Exception('Dbf file does not exist or is not readable');
        }
        $this->_openFile();
        $buffer = fread($this->_filePointer, 32);
        $this->_headers = unpack("VrecordCount/vfirstRecord/vrecordLength",
            substr($buffer, 4, 8));
        $this->_closeFile();
    }

    /**
     * Open associated dbf file
     */
    private function _openFile()
    {
        if (!$this->_filePointer) {
            $this->_filePointer = fopen($this->_fileName,'r');
        }
    }

    /**
     * Close associated dbf file
     */
    private function _closeFile()
    {
        if ($this->_filePointer) {
            fclose($this->_filePointer);
            $this->_filePointer = null;
        }
    }

    /**
     * Close associated dbf file when destructing object
     */
    public function  __destruct()
    {
        $this->_closeFile();
    }

    /**
     * Retrieve file metadata
     * @return array
     */
    public function getInfos()
    {
        if (!$this->_infos) {
            $this->_openFile();
            $continue = true;
            $this->_unpackString = '';
            $fields = array();
            fseek($this->_filePointer, 32);
            // Read fields headers
            while ($continue && !feof($this->_filePointer)) {
                $buffer = fread($this->_filePointer, 32);
                if (substr($buffer, 0, 1) == chr(13)) {
                    $continue = false;
                } else {
                    $field = unpack("AfieldName/A1fieldType/Voffset",
                        substr($buffer, 0, 18));
                    // Check fields headers
                   /* if (!in_array($field['fieldType'], array('M', 'D', 'N', 'C', 'L', 'F'))) {
                        throw new \Exception("Field type of field '{$field['fieldName']}' is not correct");
                    }*/

                    echo '<pre>';
                    print_r(iconv('CP1251', 'UTF-8', $buffer));
                    echo '</pre>';
                    /*$this->_unpackString .= 'A' . $field['fieldLen'] . $field['fieldName'] . '/';
                    array_push($fields, $field);*/
                }
            }
            $this->_infos = $fields;
            $this->_closeFile();
        }
        return $this->_infos;
    }

    /**
     * Return all records as an array
     * @return array
     */
    public function fetchAll()
    {
        if (!$this->_data) {
            $this->getInfos();
            $this->_openFile();
            fseek($this->_filePointer, $this->_headers['firstRecord'] + 1);
            $records = array();
            for ($i = 1; $i <= $this->_headers['recordCount']; $i++) {
                $buffer = fread($this->_filePointer, $this->_headers['recordLength']);
                $record = unpack($this->_unpackString, $buffer);
                array_push($records, $record);
            }
            $this->_data = $records;
            $this->_closeFile();
        }
        return $this->_data;
    }

    /**
     * Number of record
     * @return integer
     */
    public function getRecordCount()
    {
        return $this->_headers['recordCount'];
    }
}


function echo_dbf($dbfname) {
    $fdbf = fopen($dbfname,'r');
    $fields = array();
    $buf = fread($fdbf,32);
    $header=unpack( "VRecordCount/vFirstRecord/vRecordLength", substr($buf,4,8));
    echo 'Header: '.json_encode($header).'<br/>';
    $goon = true;
    $unpackString='';
    while ($goon && !feof($fdbf)) { // read fields:
        $buf = fread($fdbf,32);
        if (substr($buf,0,1)==chr(13)) {$goon=false;} // end of field list
        else {
            $field = unpack( "a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf,0,18));
            echo 'Field: '.json_encode($field).'<br/>';
            $unpackString.="A$field[fieldlen]$field[fieldname]/";
            array_push($fields, $field);}}
    fseek($fdbf, $header['FirstRecord']+1); // move back to the start of the first record (after the field definitions)
    for ($i=1; $i<=$header['RecordCount']; $i++) {
        $buf = fread($fdbf,$header['RecordLength']);
        $record=unpack($unpackString,$buf);
        echo 'record: '.json_encode($record).'<br/>';
        echo $i.$buf.'<br/>';} //raw record
    fclose($fdbf); }


function get_dbf_header($dbfname) {
    $fdbf = fopen($dbfname,'r');

    $dbfhdrarr = array();
    $buff32 = array();
    $i = 1;
    $goon = true;

    while ($goon) {
        if (!feof($fdbf)) {
            $buff32 = fread($fdbf,32);
            if ($i > 1) {
                if (substr($buff32,0,1) == chr(13)) {
                    $goon = false;
                } else {
                    $pos = strpos(substr($buff32,0,10),chr(0));
                    $pos = ($pos == 0?10:$pos);

                    $fieldname = substr($buff32,0,$pos);
                    $fieldtype = substr($buff32,11,1);
                    $fieldlen = ord(substr($buff32,16,1));
                    $fielddec = ord(substr($buff32,17,1));

                    array_push($dbfhdrarr, array($fieldname,$fieldtype,$fieldlen,$fielddec));

                }
            }
            $i++;
        } else {
            $goon = false;
        }
    }

    fclose($fdbf);
    return($dbfhdrarr);
}


function cp1251_to_utf8($s)
{
    $t = '';
    if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "WINDOWS-1251")
    {
        $c209 = chr(209); $c208 = chr(208); $c129 = chr(129);
        for($i=0; $i<strlen($s); $i++)
        {
            $c=ord($s[$i]);
            if ($c>=192 and $c<=239) $t.=$c208.chr($c-48);
            elseif ($c>239) $t.=$c209.chr($c-112);
            elseif ($c==184) $t.=$c209.$c209;
            elseif ($c==168)    $t.=$c208.$c129;
            else $t.=$s[$i];
        }
        return $t;
    }
    else
    {
        return $s;
    }
}
