<?php


namespace ninenight\export;


class PhpCvs implements ExportInterface
{
    protected $fileName = '';
    protected $title = [];
    protected $data = [];

    public function __construct($fileName, $title, $data)
    {
        $this->fileName = $fileName;
        $this->title = $title;
        $this->data = $data;
    }

    public function doExport()
    {
        // TODO: Implement doExport() method.
        $string = '';
        $colum = count($this->title);
        for ($i = 0; $i < $colum; $i++) {
            $string .= $this->title[$i];
        }
        $string .= "\n";
        $string = iconv('utf-8','GB18030', $string);
        $listcount = count($this->data);
        for ($j = 0; $j < $listcount; $j++) {
            $row = $this->data[$j];
            for ($k = 0; $k < $colum; $k++) {
                $string .= $row[$k];
            }
            $string .= "\n";
        }
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$this->fileName . ".cvs");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo $string;
        exit(0);
    }
}