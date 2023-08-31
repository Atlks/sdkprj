


function isset(varname) {
    try {
        varname = varname.trim();
        rzt = typeof (eval(varname));
        return typeof (varname) != "undefined";
    } catch (e) {
        console.log(e.message);
        //  console_log(e);
        return false;
    }

}

if (isset("module"))
    module.exports = {http_get }


function  get($url)
{
    return http_get($url);
}

//http_get("urllll",2)
async function http_get_syncReqLib($url) {
    console.log("\r\n");
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);

    //  console.log($url);
    var request = require('sync-request');
    var res = await request('GET', $url);
    let body =await res.getBody().toString();
    console.log(" [http_get():] ret=>" + body);
    console.log("\r\n");
    return body;

}

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

async  function  http_get($url)
{
    console.log("\r\n");
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);

    require("esm-hook");
    const fetch = require('node-fetch').default



//fetch("http://127.0.0.1:80/web/upload.php")


    const res = await fetch($url);
    console.log(" res.statusCode=>"+ res.statusCode)

    console.log(" res.status=>"+ res.status)



     var result = await res.text();



    if(res.status!=200)
    {
        result=strip_tagsx(result);// result=removeBlankLines(result)
    }




   // console.log(result)
    console.log(" [http_get():] ret=>" + result);
    console.log("\r\n");
    return result;
}

function delHtmlTag(result) {
    return strip_tags(result)
}

function removeBlankLines($t){
  $t = $t.replace(/(\n[\s\t]*\r*\n)/g, '\n');

   $t=  $t .replace(/^[\n\r\n\t]*|[\n\r\n\t]*$/g, '')

 return $t;
}