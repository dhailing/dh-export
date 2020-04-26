<?php


namespace ninenight\export;


class PhpCsv implements ExportInterface
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