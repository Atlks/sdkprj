<?php

//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe tlgrm/lotry.php
//   特码球玩法=\d\/\d\/\d+,特码球大小单双玩法=\d+[大|小|单|双]\d+,和值大小单双玩法=和[大|小|单|双]\d+,龙虎和玩法=[龙|虎|和]\d+,前后三玩法=[前|后][豹|顺|对|半|杂]\d+
//1/1/1



//echo preg_match("/\d\/\d\/\d+/", "1/1/33");
//die();


//echo preg_match("/\d[大|小|单|双].*/", "1单311");
//die();
//echo preg_match("/\d[大|小|单|双]\d+/", "1单33");
//die();
//echo getWefa("1单33");
//echo getWefa("和单33");

//print_r(str_split("3单33"));
$str = "3单33";

//print_r(str_splitX("3单33"));


echo PHP_EOL;
//var_dump(dwijyo("1单33", "12745"));
$glb = [];
//var_dump(dwijyo("4/4/33", "12745"));
//var_dump(dwijyo("后顺33", "32765"));
//var_dump(dwijyo("和单", "32765"));
var_dump(dwijyo("前顺33", "90175"));


var_dump(isShunzi("029"));
var_dump(isBanShunzi("029"));


// 获取玩法
function getWefa($numb)
{
 
    echo "betnum:".$numb;
    $wefa_rex = '特码球玩法=\d\/\d\/\d+,特码球大小单双玩法=\d[大|小|单|双]\d+,和值大小单双玩法=和[大|小|单|双]\d+,龙虎和玩法=[龙|虎|和]\d+,前后三玩法=[前|后][豹|顺|对|半|杂]\d+';
    $wefa_rex = '特码球玩法=\d\/\d\/\d+,特码球大小单双玩法=\d\/[大小单双],和值大小单双玩法=和[大小单双],龙虎和玩法=[龙虎和],前后三玩法=[前中后][豹顺对半杂]';

    // 和值单独判断.bcs rex cant ok... in php 
    if (startsWith($numb, "和"))
        return  "和值大小单双玩法";
        if (startsWith($numb, "前") || startsWith($numb, "中") || startsWith($numb, "后"))
        return  "前后三玩法";

    global $wefa_rex;
    $a = explode(",", $wefa_rex);

    $arr = $a;



    foreach ($arr as $key => $value) {
        $a100 = explode("=", $value);
        $wefa = $a100[0];
        $rx = $a100[1];

        echo PHP_EOL;
        echo "----------------------------------";
        echo PHP_EOL;
        print_r($numb);
        print_r($wefa);
        print_r($rx);
        $p = '/'  . $rx . '/';
        print_r($p);

        if (preg_match($p, $numb)) {
            print_r("     match..");
            return   $wefa;
        } else
            print_r("   not match..");
    }

    $arr = array_map(function ($item) {
        $a100 = explode("=", $item);
        return $item . '_i';
    }, $a);
}

//对讲结果
function dwijyo($betNum,   $bonusNum)
{
    echo PHP_EOL;
    $wefa = getWefa($betNum);
    //global $glb;
    $glb['wefa'] = $wefa;
    print_r($glb);
    var_dump($wefa);
    if ($wefa == "特码球玩法") {
        $cyoIdex = str_split($betNum)[0];
        print_r($cyoIdex);
        //开奖号码
        $cyoNum = str_split($bonusNum)[$cyoIdex - 1];
        print_r($cyoNum);

        $betNum = explode("/", $betNum)[1];
        return  $betNum ==    $cyoNum;
    } else if ($wefa == "特码球大小单双玩法") {
        $cyoIdex = str_split($betNum)[0];
        print_r($cyoIdex);
        $kaij_num_curPos = str_split($bonusNum)[$cyoIdex - 1];
        //   print_r($cyoNum);

        $dasyaodeshwo = str_splitX($betNum)[1];
        print_r($dasyaodeshwo);


        $kaij_num = getKaijNumArr_Dasyaodeshwo($kaij_num_curPos);
        print_r($kaij_num);
        return  in_array($dasyaodeshwo, $kaij_num);
    } else if ($wefa == "和值大小单双玩法") {
        $betnum = str_splitX($betNum)[1];

        $kaij_num = getKaijNumArr_hezDasyods($bonusNum);
        print_r(" kaij num::");
        print_r($kaij_num);


        return  in_array($betnum, $kaij_num);
    } else if ($wefa == "龙虎和玩法") {
        $betnum = str_splitX($betNum)[0];

        //开奖号码
        //  $kaij_num=
        if (str_split($bonusNum)[0] > str_split($bonusNum)[4])
            $kaij_num = "龙";
        if (str_split($bonusNum)[0] < str_split($bonusNum)[4])
            $kaij_num = "虎";
        if (str_split($bonusNum)[0] = str_split($bonusNum)[4])
            $kaij_num = "和";



        return  $betNum ==    $kaij_num;
    } else if ($wefa == "前后三玩法") {
        $betnum = str_delNum($betNum);
        $betnum=cyehose_bet_fullname( $betnum);
       


        print_r(" betnum num fullname::" . $betnum);
        //  die();
        //开奖号码
        //  $kaij_num=

        $kaij_num = getKaijNumArr_cyehose($bonusNum);
        print_r(" kaij num::");
        print_r($kaij_num);


        return  in_array($betnum, $kaij_num);
    }
}

function cyehose_bet_fullname( $betnum)
{
    $betnum= str_replace("前","前三",$betnum);
    $betnum= str_replace("后","后三",$betnum);
    $betnum= str_replace("中","中三",$betnum);
    $betnum= str_replace("豹","豹子",$betnum);
    $betnum= str_replace("对","对子",$betnum);
    $betnum= str_replace("顺","顺子",$betnum);
    $betnum= str_replace("半","半顺子",$betnum);
    $betnum= str_replace("杂","杂六",$betnum);
    return $betnum;
}

//获取开奖序列  --和值大小单双
function getKaijNumArr_hezDasyods($bonusNum)
{
    $a2 = str_split($bonusNum);
    $val = array_sum($a2);
    if ($val % 2 == 0)
        $a[] = "双";
    else
        $a[] = "单";

    if ($val > 23)
        $a[] = "大";
    else
        $a[] = "小";
    return $a;
}
//获取开奖序列  --大小单双
function getKaijNumArr_Dasyaodeshwo($bonusNum)
{
    $glb = [];
    //   if($bonusNum)
    //  $a[];
    $glb['bonusNum'] = $bonusNum;
    $a_de = [1, 3, 5, 7, 9];
    // print_r($a);
    if (in_array($bonusNum, $a_de))
        $a[] = "单";
    else
        $a[] = "双";
    $glb['curKaijunm_arr'] = $a;
    //  $a_shwo = [0, 2, 4, 6, 8];
    //  if (in_array($bonusNum, $a_shwo)) 
    print_r($glb);


    if ($bonusNum >= 5)
        $a[] = "大";
    else
        $a[] = "小";
    print_r($glb);
    return $a;
}

//获取开奖序列--前后三玩法
function getKaijNumArr_cyehose($bonusNum)
{
    $cye3 = substr($bonusNum, 0, 3);
    var_dump($cye3);
    $jon3= substr($bonusNum, 1, 3);
    $ho3 = substr($bonusNum, 2, 3);
    if (isBaozi($cye3))
        $a[] = "前三豹子";
    else if (isDwizi($cye3))
        $a[] = "前三对子";
    else   if (isShunzi($cye3))
        $a[] = "前三顺子";
    else  if (isBanShunzi($cye3))
        $a[] = "前三半顺子";
    else  if (isZalyo($cye3))
        $a[] = "前三杂六";



        if (isBaozi($jon3))
        $a[] = "中三豹子";
    else if (isDwizi($jon3))
        $a[] = "中三对子";
    else   if (isShunzi($jon3))
        $a[] = "中三顺子";
    else  if (isBanShunzi($jon3))
        $a[] = "中三半顺子";
    else  if (isZalyo($jon3))
        $a[] = "中三杂六";


    if (isBaozi($ho3))
        $a[] = "后三豹子";
    else if (isDwizi($ho3))
        $a[] = "后三对子";
    else   if (isShunzi($ho3))
        $a[] = "后三顺子";
    else  if (isBanShunzi($ho3))
        $a[] = "后三半顺子";
    else  if (isZalyo($ho3))
        $a[] = "后三杂六";
    return $a;
}

function isBaozi($num)
{
    return (str_split($num)[0] === str_split($num)[1] &&   str_split($num)[0] === str_split($num)[2]);
}
function isDwizi($num)
{
    if (isBaozi($num))
        return false;
    else  if (str_split($num)[0] === str_split($num)[1] &&   str_split($num)[0] !== str_split($num)[2])
        return true;
    else if (str_split($num)[0] === str_split($num)[2] &&   str_split($num)[0] !== str_split($num)[1])
        return true;
    else if (str_split($num)[1] === str_split($num)[2] &&   str_split($num)[1] !== str_split($num)[0])
        return true;
    else
        return false;
}

function isShunzi($num)
{
    $num = order_str($num);// 019
    $a = ['123', '234', '345', '456', '567', '678', '789', '890', '901', '012', '089','019'];
    return in_array($num, $a);
}


function isBanShunzi($num)
{

    $num = order_str($num);
    if (isShunzi($num))
        return false;
   
    $cye2 = substr($num, 0, 2);
    $ho2 = substr($num, 1, 2);
    $jo2=substr($num, 0, 1).substr($num, 2, 1);
    var_dump($jo2);
    //   789  290>029  801>018
    $a = ['12', '23', '34', '45', '56', '67', '78', '89', '90', '01', '12','09'];
    if (in_array($cye2, $a) || in_array($ho2, $a) || in_array($jo2, $a))
        return true;
    else
        return false;
}

function isZalyo($num)
{
    if (isBaozi($num))
        return false;
    else if (isDwizi($num))
        return false;
    else   if (isShunzi($num))
        return false;
    else  if (isBanShunzi($num))
        return false;
    else  return true;
}






//-----------------------------------core .fun lib---------------------------
//检查字符串是否以特定的子字符串开头
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

//支持中文的splt ,,ori splt only eng
function str_splitX($str)
{
    //support chinese char,,,,  str_split not spt chins char
    return  preg_split('/(?<!^)(?!$)/u', $str);
}


//echo " str ddl:".str_delNum("后顺333");
function str_delNum($str)
{
    return preg_replace('/[\d]/', '', $str);
}

// order_str as char arr
function order_str($num)
{
    echo 1151;
    print_r("num:" . $num . "    ");
    $a = str_split($num);
    print_r($a);
    sort($a);
    echo " aft asort:";
    print_r($a);
    // die();
    $s = implode($a);
    return $s;
}
