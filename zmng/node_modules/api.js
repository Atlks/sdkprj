











//dep




























function getLibdir() {
    // _file=>C:\modyfing\jbbot\zmng\shangxiafen.htm
    // if embed in htm...filename just htm path
    console.log("_file=>"+__filename)  //if in html file ,...just for html file path
    console.log("__dirname=>"+__dirname)

    //   console.log(__dirname)
 let   libdir = __dirname + '/../libx/'
// C:\modyfing\jbbot\zmng/../lib/
    console.log(libdir)

    const fs = require('fs');

    console.log("exist dir:=>" + fs.existsSync(libdir))

    if (!fs.existsSync(libdir)) {
        console.log(libdir + " not exist")
        libdir = __dirname + '/libx/'
    }
    console.log("libdir=>"+libdir)
    return libdir;
}

let libdir = getLibdir();

var {
    isset,call_user_func,
    echo,
    substr,
    console_log,
    sprintf,
    startwith,
    str_replace,
    strtolower,
    strlen,
    strpos,
    trim,
    sprintf, time
} = require(libdir+'php.js');
const {http_get} = require(libdir+'http.js');
const {aes_encrypt, aes_decrypt, aes_mode_ECB, aes_mode_CBC} = require(libdir+'aes.js');

const {urlencode, md5} = require(libdir+'enc.js');


//商户唯一编码
agentid = 111356
//参数加密编码
descode = "26916DD661300B25"
desCode = descode
//请求校验加密编码
md5code = "1BC0036763DE22EC"
md5Code = md5code
//xx=aes_mode_ECB;
apitype_regLogin = 0;  //注册/登录接口
apitype_kexiafen = 1;//	查询玩家可下分接口
apitype_shangfen = 2;// 2	玩家上分
apitype_xiafen = 3;//3	玩家下分
apitype_orderQryShagnxiafen = 4;//// 4	玩家上下分订单查询
apitype_PlayerScore = 7;// 玩家总分查询
apitype_playerStat = 5;//玩家状态查询
// apitype=
//
// 1	查询玩家可下分接口
// 2	玩家上分
// 3	玩家下分
// 4	玩家上下分订单查询
// 5	玩家状态查询
// 6	游戏注单拉取
// 7	玩家总分查询
// 8	踢玩家下线
// 9	代理余额查询
// 11	比赛注单拉取
// 41	玩家上下分订单查询（集合）

module.exports = {reg,login}
global["playerStat"]=playerStat;
async function playerStat(uname) {
    timestamp = time();
    _paraValue = sprintf("account=%s", uname);
    //  orderid = sprintf("%s%s%s", agentid, timestamp, uname)
    //   _paraValue = sprintf(_paraValue, uname, score, orderid);

    let url = buildUrlNget(_paraValue, timestamp);
    return (await http_get(url));

}
async function login(uname, pwd) {
    timestamp = time();
    _paraValue = "account=%s&score=%s&orderid=%s";
    orderid = sprintf("%s%s%s", agentid, timestamp, uname)
    _paraValue = sprintf(_paraValue, uname, score, orderid);

    let url = buildUrlNget(_paraValue, timestamp);
    return (await http_get(url));

}
async function reg(uname, pwd, nickname) {

    $url_tpmplt = "https://ng.mqbsx.com/GameHandle?agentid=%s&timestamp=%s&type=%s&paraValue=%s&key=%s";


    timestamp = time();

    _paraValue = "account=%s&nickname=%s&headindex=0&linecode=10001_1&lastloginip=255.224.22.12&gamebackurl=www.test.com&logintype=1&gameid=0";
    _paraValue = sprintf(_paraValue, uname, nickname);
    paraValue = aes_encrypt(aes_mode_ECB(), _paraValue, desCode);
    md5key = md5(sprintf("%s%s%s", agentid, timestamp, md5Code));


    $url = sprintf($url_tpmplt, agentid, timestamp, apitype_regLogin, urlencode(paraValue), md5key);


    return (await http_get($url));


}
global["reg"]=reg;
global["shangfen"]=shangfen;



async function shangfen(uname, score) {




    timestamp = time();
    _paraValue = "account=%s&score=%s&orderid=%s";
    orderid=sprintf("%s%s%s",agentid,timestamp,uname)
    _paraValue = sprintf(_paraValue, uname, score,orderid);

    let url =   buildUrlNget(_paraValue,timestamp);
    return  (await http_get( url));

}


  function buildUrlNget(_paraValue,timestamp) {
    paraValue = aes_encrypt(aes_mode_ECB(), _paraValue, desCode);
    md5key = md5(sprintf("%s%s%s", agentid, timestamp, md5Code));


    $url_tpmplt = "https://ng.mqbsx.com/GameHandle?agentid=%s&timestamp=%s&type=%s&paraValue=%s&key=%s";
    $url = sprintf($url_tpmplt, agentid, timestamp, apitype_shangfen, urlencode(paraValue), md5key);


    return $url;
}





