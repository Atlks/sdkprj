response={

    send:function(s){
        console.log(s)
    }
};

var htl="";
function  main() {
     console.log("ttt")
  //  return;
    var http= require('http');
    httpModtmp=http;
    url="http://blog.csdn.net/attilax/article/details/79332937"


    var post_options = {
        host: 'blog.csdn.net',
        port: '80',
        path: '/attilax/article/details/79332937',
        method: 'GET',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Content-Length':0,
            'Origin':'blog.csdn.net',
            'Referer':url,
            'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',
            'Upgrade-Insecure-Requests':1
            //    'Cookie':'chinanpojsessionid=C5B432F4A8100CFA5803EA018A8B4AEC; _gscu_815174165=84382222mstxh112; _gscs_815174165=t84402470rmeenn15|pv:2; _gscbrs_815174165=1; Hm_lvt_3adce665674fbfb5552846b40f1c3cbc=1484382201; Hm_lpvt_3adce665674fbfb5552846b40f1c3cbc=1484403650'
        }
    };  //poost opt end

    var   req_ClientRequest =  httpModtmp.get(post_options, function (res) {
        // res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
        /*  */
        var data = '';
        res.on('data', function (chunk) {
            console.info( " res data evenbt..");
            data += chunk;
        });
        res.on('end', function () {
        //    console.info(data);
            htl=data;
           response.send("ressend:"+htl);
            console.info( " res end..");

            //  resAftEvt(url,url_cnt_idx,data );

        });

    });  //end   httpModtmp.get

//  if(httpModtmp==http)
    req_ClientRequest.on('error', function(e) {
        console.error(" req err:"+ url+ JSON.stringify(e));
    });
}
main();

//var intervalId = setInterval(main, 10000);