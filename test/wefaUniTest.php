<?php
//   6599269003:AAHW6kAh3Cy28vT4NuzQIkU4sISM3iFi-OA      ssc2024_bot  test ssc bot
//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe app/lotrySsc.php
//   特码球玩法=\d\/\d\/\d+,特码球大小单双玩法=\d+[大|小|单|双]\d+,和值大小单双玩法=和[大|小|单|双]\d+,龙虎和玩法=[龙|虎|和]\d+,前后三玩法=[前|后][豹|顺|对|半|杂]\d+
//1/1/1


//C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe test/wefaUniTest.php 
require_once  __DIR__ . "/../app/lotrySsc.php";

echo  "------------1/单/100  " . "11690" .  tostrFrmbool(dwijyo("1/单/100",   "11690"));
//die();

echo  "------------1/1/100  " . "11690" . tostrFrmbool(dwijyo("1/1/100",   "11690"));

echo  "------------1/单/100  " . "11690" .  tostrFrmbool(dwijyo("1/单/100",   "11690"));

echo  "--------------小100  " . "11690"  . tostrFrmbool(dwijyo("小100",   "11690"));

var_dump(dwijyo("大100",   "11690"));
var_dump(dwijyo("单100",   "11690"));
var_dump(dwijyo("双100",   "11690"));
var_dump(dwijyo("龙100",   "01690"));
var_dump(dwijyo("虎100",   "01690"));

echo  "--------------和100  " . "01690"  . tostrFrmbool(dwijyo("和100",   "01690"));
echo  "--------------前豹100  " . "00090"  . tostrFrmbool(dwijyo("前豹100",   "00090"));

echo  "--------------前对100  " . "00190"  . tostrFrmbool(dwijyo("前对100",   "01090"));



die();
//var_dump(join(" ",getKaijNumArr_hezDasyods("41278") ));



//

function tostrFrmbool($blll)
{
    if ($blll)
        return "   TRUEEEEEEEEEEEEEEEEEEEEEE..";
    else
        return "    false.....";
}
