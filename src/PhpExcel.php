<?php


namespace ninenight\export;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhpExcel implements ExportInterface
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

    /**
     * 数字转字母 （类似于Excel列标）
     * @param Int $index 索引值
     * @param Int $start 字母起始值
     * @return String 返回字母
     */
    public function intToChr($index, $start = 65)
    {
        $str = '';
        if (floor($index / 26) > 0) {
            $str .= $this->intToChr(floor($index / 26) - 1);
        }
        return $str . chr($index % 26 + $start);
    }

    public function doExport()
    {
        // TODO: Implement doExport() method.
        header('Content-disposition: attachment; filename="' . $this->fileName . '".xlsx');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $header = array_values($this->title);
        $data = array_values($this->data);
        //获取列信息
        $column = [];
        foreach ($header as $k => $item) {
            $column[$k] = $this->intToChr($k);
        }
        //获取初始列和最终列
        $firstColum = $column[0];
        $lastColum = $column[count($column) - 1];
        //获取初始行和最终行
        $firstRow = 1;
        $lastRow = count($data) + 1;
        $row = 1;
        $spreadsheet = new Spreadsheet();//创建一个新的excel文档
        $sheet = $spreadsheet->getActiveSheet();//获取当前操作sheet的对象
        $sheet->setTitle('标题'); //设置标题
        $sheet->getStyle("{$firstColum}:{$lastColum}")->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER) //设置垂直居中
            ->setHorizontal(Alignment::HORIZONTAL_CENTER) //设置水平居中
            ->setWrapText(true); //设置自动换行
        //设置宽度
        $sheet->getDefaultColumnDimension()->setWidth(20);
        $headerStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
        ];
        $cellStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ],
            'font' => [
                'size' => 10,
            ],
        ];
        //将excel的单元格格式设为文本格式
        $sheet->getStyle("{$firstColum}{$firstRow}:{$lastColum}{$lastRow}")->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        //设置头信息样式
        $sheet->getRowDimension($row)->setRowHeight(30);//设置行高
        $sheet->getStyle("{$firstColum}{$row}:{$lastColum}{$row}")->applyFromArray($headerStyle);
        //设置头信息
        foreach ($header as $key => $item) {
            $sheet->setCellValue("{$column[$key]}{$row}", $item);
        }
        $row++;
        foreach ($data as $key => $model) {
            $sheet->getRowDimension($row)->setRowHeight(30);//设置行高
            $sheet->getStyle("{$firstColum}{$row}:{$lastColum}{$row}")->applyFromArray($cellStyle);
            $i = 0;
            foreach ($model as $value) {
                $sheet->setCellValue("{$column[$i]}{$row}", $value);
                $i++;
            }
            $row++;
        }
        $file = $this->fileName . '.xlsx';//保存地址
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);//生成excel文件
        exit(0);
    }
}