<?php
//文件注释：：本文件为任务核心流程
require "cfg.php";
require "conn.php";


$main->info($sql);
$rows = queryPdo($sql, $pdo);
require "sdk/httpclient.php";

require "sendNewEcFunc.php";
foreach ($rows as $row) {
    echo PHP_EOL . PHP_EOL . PHP_EOL;
    echo "row:" . json_encode($row);
    echo PHP_EOL . "bet_data:" . $row['bet_data'] . PHP_EOL;

    $btdt_str = $row['bet_data'];
    if (strstr($btdt_str, 'longhu.longhu'))
        $bet_data = Convert_bet_data_longhu($btdt_str);
    else if (strstr($btdt_str, 'daxiaodanshuang'))
        $bet_data = Convert_bet_data_daxiaodanshuang($btdt_str);

    else {
        //-----------convert  nomrfmt
        $bet_data = convert_normal($row);
    }
    //// --------------full fix row
    $row = fullFixRow($bet_data, $row);

    //--------------------------------url symc
    echo PHP_EOL . '------------------------------------------------start url sync...' . PHP_EOL;
    //$url = 'http://localhost/';
    echo PHP_EOL . $url;
    //  echo PHP_EOL. file_get_contents($url);
    require "sendNewEc.php";


    echo PHP_EOL . '------------------------------------------------set sync flat =1...' . PHP_EOL;
    //------------------set sync flat =1
    $sql = "update  bet_records set sync_flag=1 where id=" . $row["id"];
    $sql = "insert bet_record_ext set sync_flag=1, id=" . $row["id"];
    exec_sql($sql, $pdo);
}
echo PHP_EOL . PHP_EOL . PHP_EOL . "finish task" . PHP_EOL;


/**
 * 格式转换
 *
 * @param $row 原始数据
 * @return 返回转换数据
 */
function convert_normal($row)
{
    $bet_data = json_decode($row['bet_data'], true);
    $jsonArr = ($bet_data['balls']);


    for ($i = 0; $i < count($jsonArr); ++$i) {
        $betSingleObj = $jsonArr[$i];
        echo "betSingleObj:" . json_encode($betSingleObj);
        echo PHP_EOL;
        $danzhu_data = $betSingleObj['ball'];
        echo $danzhu_data;
        echo PHP_EOL;
        $danzhu_data_newecFmt = str_replace("|", ",", $danzhu_data);
        $danzhu_data_newecFmt = '[' . $danzhu_data_newecFmt . ']';
        echo "new fmt:" . $danzhu_data_newecFmt;
        $betSingleObj['ball'] = $danzhu_data_newecFmt;
        $jsonArr[$i] = $betSingleObj;
        echo "";
    }
    $bet_data['balls'] = $jsonArr;
    return $bet_data;
}

/** 补充完整newec需要的字段
 * @param 投注数据
 * @param $row
 * @return 返回需要的数据
 */

function fullFixRow($bet_data, $row)
{
    echo PHP_EOL;
    echo json_encode($bet_data);
    $row['bet_data'] = $bet_data;
    $row['appId'] = 'appid111';
    $row['orderNo'] = $row['username'] . $row['created_at'];
    $row['issue'] = 'issuexxx';
    $row['userId'] = $row['user_id'];
    $row['bet'] = $row['bet_data'];


    $row['betNum'] = $row['bet_count'];

    $row['betTime'] = $row['created_at'];
    $row['sign'] = $row['bet_count'];

    echo PHP_EOL;
    echo json_encode($row);
    return $row;
}

/**
 * 转换投注数据从2hc到newec格式
 * 2hz：1｜2｜0
 * new ec： [big,small,odd]
 *
 * @param $bet_data_str 投注数据
 * @return newec新格式投注数据
 */
function Convert_bet_data_daxiaodanshuang($bet_data_str)
{
    $bet_data = json_decode($bet_data_str, true);
    $jsonArr = ($bet_data['balls']);


    for ($i = 0; $i < count($jsonArr); ++$i) {
        $betSingleObj = $jsonArr[$i];
        echo "betSingleObj:" . json_encode($betSingleObj);
        echo PHP_EOL;
        $danzhu_data = $betSingleObj['ball'];
        echo $danzhu_data;
        echo PHP_EOL;
        $danzhu_data_newecFmt = str_replace("|", "][", $danzhu_data);
        $danzhu_data_newecFmt = str_replace("1", "big,", $danzhu_data_newecFmt);
        $danzhu_data_newecFmt = str_replace("0", "small,", $danzhu_data_newecFmt);
        //deshwo
        $danzhu_data_newecFmt = str_replace("3", "odd,", $danzhu_data_newecFmt);
        $danzhu_data_newecFmt = str_replace("2", "even,", $danzhu_data_newecFmt);

        $danzhu_data_newecFmt = "[" . $danzhu_data_newecFmt . "]";
        $danzhu_data_newecFmt = str_replace(",]", "]", $danzhu_data_newecFmt);
        echo "new fmt:" . $danzhu_data_newecFmt;
        $betSingleObj['ball'] = $danzhu_data_newecFmt;
        $jsonArr[$i] = $betSingleObj;
        echo "";
    }
    $bet_data['balls'] = $jsonArr;
    return $bet_data;
}

/**
 * 转换2hz虎龙投注数据格式到newec格式
 * 2hz：1｜2｜0
 * new ec： [tiger,dragon,drawn]
 *
 * @param $bet_data_str  投注数据
 * @return newec新格式投注数据
 */
function Convert_bet_data_longhu($bet_data_str)
{

    $bet_data = json_decode($bet_data_str, true);
    $jsonArr = ($bet_data['balls']);


    for ($i = 0; $i < count($jsonArr); ++$i) {
        $betSingleObj = $jsonArr[$i];
        echo "betSingleObj:" . json_encode($betSingleObj);
        echo PHP_EOL;

        $danzhu_data = $betSingleObj['ball'];
        echo $danzhu_data;
        echo PHP_EOL;

        $danzhu_data_newecFmt = str_replace("|", ",", $danzhu_data);
        $danzhu_data_newecFmt = str_replace("2", "dragon,", $danzhu_data_newecFmt);
        $danzhu_data_newecFmt = str_replace("0", "tiger,", $danzhu_data_newecFmt);
        $danzhu_data_newecFmt = str_replace("1", "drawn,", $danzhu_data_newecFmt);
        $danzhu_data_newecFmt = "[" . $danzhu_data_newecFmt . "]";
        $danzhu_data_newecFmt = str_replace(",]", "]", $danzhu_data_newecFmt);
        echo "new fmt:" . $danzhu_data_newecFmt;

        $betSingleObj['ball'] = $danzhu_data_newecFmt;
        $jsonArr[$i] = $betSingleObj;
        echo "";
    }
    $bet_data['balls'] = $jsonArr;
    return $bet_data;

}