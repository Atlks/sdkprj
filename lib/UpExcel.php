<?php

/*
 * 用于读取EXCEL文档的类
 * 
 */

class UpExcel {

    /**
     * 按指定格式读取Excel内容
     * @param string $filePath            文件名
     * @param array $excelTitle            表格列名
     * @param boolwan $isReadTitle     是否读取表格标题行内容
     * @return array    二维数组数据
     */
    public static function readExcel($filePath = null, $excelTitle, $isReadTitle = False) {

        $PHPExcel = new PHPExcel();
        //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                echo 'no Excel';
                return;
            }
        }

        $PHPExcel = $PHPReader->load($filePath);
        //读取excel文件中的第一个工作表
        $currentSheet = $PHPExcel->getSheet(0);
        //取得最大的列号
        $allColumn = $currentSheet->getHighestDataColumn();
        //取得一共有多少行
        $allRow = $currentSheet->getHighestDataRow();
        //从第二行开始输出，因为excel表中第一行为列名
        $firstRow = $isReadTitle ? 1 : 2;
        $aExcel = [];
        $key = 0;
        for ($currentRow = $firstRow; $currentRow <= $allRow; $currentRow++) {
            //从第A列开始输出
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                $iColumn = ord($currentColumn) - 65;
                $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue();
                $aExcel[$key][$excelTitle[$iColumn]] = $val;
            }
            $key++;
        }
        return $aExcel;
    }

}
