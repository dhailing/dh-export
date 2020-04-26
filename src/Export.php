<?php


namespace ninenight\export;


class Export
{
    public function export($type, $filename, $title, $data)
    {
        switch ($type) {
            case 'xlswriter':
                return new PhpXlswriter($filename, $title, $data);
            case 'excel':
                return new PhpExcel($filename, $title, $data);
            case 'csv':
                return new PhpCsv($filename, $title, $data);
            case 'browser':
                return new PhpBrowser($filename, $title, $data);
            default:
                break;
        }
    }
}