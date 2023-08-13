<?php


function encodeMkdwContext($t){

$cs="\*{}[]()#*+-.!|";
$a=str_split($cs);


return join($a);


}



//支持中文的splt ,,ori splt only eng
function str_splitX($str)
{
    //support chinese char,,,,  str_split not spt chins char
    return  preg_split('/(?<!^)(?!$)/u', $str);
}


public   function replace_markdown($text)
{
    $characters = "/[\_|\*|\[|\]|\(|\)|\~|\`|\>|\#|\+|\-|\=|\||\{|\}|\.|\!]+/";
    $replaced = [];
    if (preg_match_all($characters, $text, $mc)) {
        foreach ($mc[0] as $c) {
            if(!isset($replaced[$c])){
                $reg = '/\\' . $c . '/u';
                $text = preg_replace($reg, "\\" . $c, $text);
                $replaced[$c] = 1;
            }
        }
    }
    return $text;
}