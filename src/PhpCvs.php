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
        set_time_limit(0);
        $csvFileName = $this->fileName;
        //设置好告诉浏览器要下载excel文件的headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $fp = fopen('php://output', 'a');//打开output流
        mb_convert_variables('GBK', 'UTF-8', $this->title);
        fputcsv($fp, $this->title);//将数据格式化为CSV格式并写入到output流中
        $accessNum = count($this->data);//从数据库获取总量，假设是一百万
        for ($i = 1; $i <= $accessNum; $i++) {
            //需要导出的数据
            $rowData = [];
            $rowNum = count($this->data[$i]);
            for ($j = 0;$j < $rowNum; $j++) {
                array_push($rowData, $this->data[$i][$j]);
            }
            mb_convert_variables('GBK', 'UTF-8', $rowData);
            fputcsv($fp, $rowData);
            //刷新输出缓冲到浏览器
            ob_flush();
            flush();//必须同时使用 ob_flush() 和flush() 函数来刷新输出缓冲。
        }
        fclose($fp);
        exit();
    }
}