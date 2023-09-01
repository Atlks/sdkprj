

module.exports = {urlencode,md5}

function  urlencode($prm)
{
    return  encodeURIComponent($prm)
}

var CryptoJS = require("crypto-js");

// 辅助函数
function md5(data) {
    return CryptoJS.MD5(data).toString();
}
global["md5"]=md5;
global["strip_tagsx"]=strip_tagsx;
//global["shangfen"]=shangfen;
function  strip_tagsx($t)
{
    $t= strip_tags($t);
    $t=removeBlankLines($t);return $t;
}
function  strip_tags($t)
{
    result=$t;
    //  var result = $t.replace(/<\/?.+?>/g,"")
    //result = $t.replace(/<\/?.+?>/g,"")   //cant replace img mlt line


    result = result.replace(/<style>[\s\S]*?<\/style>/igm,"")
    // var regex=/<style>[\s\S]*?<\/style>/ig;
    result = result.replace(/<\/?[^>]*>/img,"")

    //.replace(/ /g,"");
    return result;
}
global["json_decode"]=json_decode;
global["json_encode"]=json_encode;
function  json_decode($s)
{
return JSON.parse($s)
}
function  json_encode($s)
{
 return   JSON.stringify($s)
}