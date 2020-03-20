<?php


namespace ninenight\export;


class PhpBrowser implements ExportInterface
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
        $strTable = '';
        $strTable = '<table width="500" border="1">';
        $strTable .= '<tr>';
        foreach ($this->title as $titleName) {
            $strTable .= '<td style="text-align:center;font-size:12px;width:180px;">' . $titleName . '</td>';
        }
        $strTable .= '</tr>';
        foreach ($this->data as $k => $val) {
            $strTable .= '<tr>';
            foreach ($val as $fields) {
                $strTable .= '<td style="text-align:center;font-size:12px;">' . $fields . '</td>';
            }
            $strTable .= '</tr>';
        }
        $strTable .= "</tbody>
            </table>";
        //通过header头控制输出excel表格
        header("Pragma: public");
        header("Expires: 0");
        header('Content-Type:text/html;charset=utf-8 ');
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="' . $this->fileName . '.xlsx"');
        header("Content-Transfer-Encoding:binary");
        echo $strTable;
        exit(0);
    }
}