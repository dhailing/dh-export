# dh-export

---

### 安装

---

`composer require ninenight/export `

### example

```php
 //导出excel
        use ninenight\export\Export;

        $excelobj = new Export();
        $type = 'xlswriter';    //xlswriter,excel,csv,browser
        $excelobj->export($type, $filename, $title, $data)->doExport();
```