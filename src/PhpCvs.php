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
    }
}