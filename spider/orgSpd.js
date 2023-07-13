/**
 * Created by Administrator on 2017/1/14.
 */
var sys = require("util");
var fs = require('fs');
sys.log("Hello world");

var https = require('http');

function getUrls()
{
    var urls=new Array();
    for(var i=1;i<100;i++)
    {
        var reqdata_str="orgName=&corporateType=1&managerDeptCode=&registrationNo=&unifiedCode=&order=registrationDate&legalName=&page_flag=true&pagesize_key=result&goto_page=next&current_page=@page@&total_count=1938&to_page=";
        reqdata_str=reqdata_str.replace("@page@",i);
        urls.push(reqdata_str );
    }
    return urls;
}

//main
var urls=getUrls();
var cnt=0;
for(idx in urls)
{
    var url=urls[idx];
    console.log("url:"+url);
    cnt++;
    req(url,cnt);
}
function req(reqdata_str,page)
{

var reqData={
    order:'registrationDate',
    corporateType:'1',
    current_page:'4',
    page_flag:true,
    pagesize_key:'result',
    goto_page:'next',
    total_count:1938,
    orgName:'',
    managerDeptCode:'',
    registrationNo:'',
        unifiedCode:'',
    legalName:'',
    to_page:''
    };
var data_str=  JSON.stringify (reqData);
sys.log("--reqData.length:"+data_str.length);
//var reqdata_str="orgName=&corporateType=1&managerDeptCode=&registrationNo=&unifiedCode=&order=registrationDate&legalName=&page_flag=true&pagesize_key=result&goto_page=next&current_page=3&total_count=1938&to_page=";


var post_options = {
    host: 'www.chinanpo.gov.cn',
    port: '80',
    path: '/search/searchOrgList.do?action=searchOrgList',
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
         'Content-Length':reqdata_str.length,
        'Origin':'http://www.chinanpo.gov.cn',
        'Referer':'http://www.chinanpo.gov.cn/search/searchOrgList.do?action=searchOrgList',
       'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',
        'Upgrade-Insecure-Requests':1
    //    'Cookie':'chinanpojsessionid=C5B432F4A8100CFA5803EA018A8B4AEC; _gscu_815174165=84382222mstxh112; _gscs_815174165=t84402470rmeenn15|pv:2; _gscbrs_815174165=1; Hm_lvt_3adce665674fbfb5552846b40f1c3cbc=1484382201; Hm_lpvt_3adce665674fbfb5552846b40f1c3cbc=1484403650'
    }
};  //poost opt end

var post_req_ClientRequest=https.request(post_options, function(res) {
    console.log("statusCode: ", res.statusCode);
 //   console.log("headers: ", res.headers);
    var html = '';
    res.on('data', function(d) {
      //  process.stdout.write(d);
        html += d;

    });


    res.on('end', function(data) {
        save(html,page);
    })

}).on('error', function(e) {
    console.error(e);
});

// post the data
post_req_ClientRequest.write(reqdata_str);
//https.write(reqData);
post_req_ClientRequest.end();

}
function getTimestamp()
{
    var timestamp = (new Date()).valueOf();
    return 	timestamp;
}


function save(html,page)
{
    console.log('start save!')
    // 将抓取的内容保存到本地文件中
    fs.writeFile('c:\\00orgSave\\index_P'+page+"_"+getTimestamp()+'.html', html, function(err) {
        if (err) {
            console.log('出现错误!')
        }
        console.log('已输出至index.html中')
    })

}