/**
 * Created by Administrator on 2017/5/31.
 *
 * D:\0workspace\atiplat_eeJS\com.attilax\util\GenderUtil.js
 */


var libpath="../";

var pathModule = require(libpath+"io/path.js");
var filM = require(libpath+"io/fileUtil.js");
var pm = require(libpath+"io/path.js");

var chars=filM.toCharArr(__dirname+ "\\male_name_char.txt");
var male_chars=new Array();
for(  char of chars)
{

    if( char==" " || char=="\r" || char=="\n")
    continue;

    if( char=="、" || char=="，" || char=="\t" ||  char=="　"  　)
    continue;
    male_chars.push(char);

}


function  isHasMaleChar(f)
{
    var name=pm.getNameWzExt(f);

    for(var char of male_chars)
    {
        if(name.indexOf(char)>=0)
        {
            console.log(" has male char, char:"+char+"  ,f:"+f);
            return true;
        }
    }
return false;

}


exports.isHasMaleChar = isHasMaleChar;
