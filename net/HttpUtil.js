/**
 * Created by Administrator on 2017/6/1.
 */



function req_httpNhttps(url,url_cnt_idx)
{
    var httpModtmp=http;
    if( url.indexOf("https://")>=0 )
        httpModtmp=https;
//    console.log(" start req:"+url +" cnt:"+url_cnt_idx);
    if(url.indexOf("http://")==-1 &&  url.indexOf("https://")==-1 )
        url="http://"+url;


    console.log(" start req final:"+url +" ,cnt:"+url_cnt_idx);


    try {
        //get 请求外网
        var   req_ClientRequest =  httpModtmp.get(url, function (res) {
            res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
            var data = '';
            res.on('data', function (chunk) {
                data += chunk;
            });
            res.on('end', function () {
                //   console.info(html);
                var    url_tmp = url.replace("http://", "");
                url_tmp = url_tmp.replace("https://", "");
                url_tmp = url_tmp.replace(/\//g, "%2f");
                url_tmp = url_tmp.replace(/\\/g, "%5c");

                var savepath = 'c:\\00orgSave\\url%' + url_tmp + "_" + timeUtil.getTimestamp() + '.html';
                console.log("savepath:"+savepath)
                pathUtil.mkdirsSync_byfilepath(savepath);
                fs.writeFileSync(savepath, data, "binary");
            });
        });  //end   httpModtmp.get

        //  if(httpModtmp==http)
        req_ClientRequest.on('error', function(e) {
            console.error(" req err:"+ url+ JSON.stringify(e));
        });
    }catch(e)
    {
        console.error( url+  e);
    }


}

function reqV2(url,url_cnt_idx)
{

    console.log(" start reg:"+url +" cnt:"+url_cnt_idx);
//get 请求外网
    http.get(url,function(res){
        res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
        var data='';
        req.on('data',function(chunk){
            data+=chunk;
        });
        req.on('end',function(){
            //   console.info(html);
            url=url.reaplace("http://","");    url=url.reaplace("https://","");
            url=url.reaplace("/","    %2f");



            var savepath='c:\\00orgSave\\url%'+url+"_"+getTimestamp()+'.html';
            pathUtil.mkdirsSync_byfilepath(savepath);
            fs.writeFileSync(savepath, data, "binary");
        });
    });

}



function req_ori(reqdata_str,page)
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

    var post_req_ClientRequest=httpModule.request(post_options, function(res) {
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

    });

    post_req_ClientRequest.on('error', function(e) {
        console.error(e);
    });

// post the data
//post_req_ClientRequest.write(reqdata_str);
//https.write(reqData);
    post_req_ClientRequest.end();

}


function req_file(url,url_cnt_idx,resAftEvt)
{
    var httpModtmp=http;
    if( url.indexOf("https://")>=0 )
        httpModtmp=https;
//    console.log(" start req:"+url +" cnt:"+url_cnt_idx);
    if(url.indexOf("http://")==-1 &&  url.indexOf("https://")==-1 )
        url="http://"+url;


    console.log(" start req final:"+url +" ,cnt:"+url_cnt_idx);


    try {
        //get 请求外网
        var   req_ClientRequest =  httpModtmp.get(url, function (res) {
            res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
            var data = '';
            res.on('data', function (chunk) {
                data += chunk;
            });
            res.on('end', function () {
                //   console.info(html);
                var    url_tmp = url.replace("http://", "");
                url_tmp = url_tmp.replace("https://", "");
                url_tmp = url_tmp.replace(/\//g, "%2f");
                url_tmp = url_tmp.replace(/\\/g, "%5c");

                var savepath = 'c:\\00orgSave\\url%' + url_tmp + "_" + timeUtil.getTimestamp() + '.html';
                console.log("savepath:"+savepath)
                pathUtil.mkdirsSync_byfilepath(savepath);
                fs.writeFileSync(savepath, data, "binary");
            });
        });  //end   httpModtmp.get

        //  if(httpModtmp==http)
        req_ClientRequest.on('error', function(e) {
            console.error(" req err:"+ url+ JSON.stringify(e));
        });
    }catch(e)
    {
        console.error( url+  e);
    }


}

function save(html,page)
{
    console.log('start save!')
    // ��ץȡ�����ݱ��浽�����ļ���
    fs.writeFile('c:\\00orgSave\\index_P'+page+"_"+getTimestamp()+'.html', html, function(err) {
        if (err) {
            console.log('���ִ���!')
        }
        console.log('�������index.html��')
    })

}

