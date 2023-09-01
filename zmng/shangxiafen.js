function  xiafen745(){
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);



    //rzt=  dsl_callFunCmdMode("playerStat",$("#uname").val() )
    rzt=  dsl_callFunCmdMode("xiafen",$("#uname").val() ,$("#score").val())


    //  {"maintype":"/GameHandle","type":7,"data":{"code":0,"agentid":111356,"linecode":"10001_1","status":0,"userid":32076939,"account":"uname1","totalScore":300.0,"integralvalue":6.0,"addscore":300.0,"subscore":0.0,"addscoretimes":2,"subscoretimes":0,"totalwinlose":0.0,"totalrevenue":0.0}}
    console.log("[xiafen745] rzt=>" + rzt)
    rztobj=JSON.parse(rzt);


    if(rztobj.data.code==0)
        alert("下分成功")
    else
        alert(rzt)

}

function  PlayerKexiafenBal638()
{
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);



    //rzt=  dsl_callFunCmdMode("playerStat",$("#uname").val() )
    rzt=  dsl_callFunCmdMode("PlayerKexiafenBal",$("#uname").val() )


    //  {"maintype":"/GameHandle","type":7,"data":{"code":0,"agentid":111356,"linecode":"10001_1","status":0,"userid":32076939,"account":"uname1","totalScore":300.0,"integralvalue":6.0,"addscore":300.0,"subscore":0.0,"addscoretimes":2,"subscoretimes":0,"totalwinlose":0.0,"totalrevenue":0.0}}
    console.log("[PlayerKexiafenBal638] rzt=>" + rzt)
    rztobj=JSON.parse(rzt);
    alert("此用户可下分为:"+rztobj.data.score)
    // rztobj.data.totalScore=rztobj.data.score;
    //   window['bindJsonToTable'](rztobj)


}

function orderQryShagnxiafen415()
{
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);



    rzt=  dsl_callFunCmdMode("orderQryShagnxiafen",$("#uname").val() )

    // console.log("[playerStat237] rzt=>" + rzt)
}

function  playerStat237()
{

    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);



    timestamp = time();

    _paraValue = sprintf("account=%s", $("#uname").val() );
    echo("_paraValue==>"+_paraValue)
    let url = buildUrlNget(_paraValue, timestamp, apitype_PlayerScore);
    console.log(url)

    $.get(url,function(data){
        console.log("[playerStat237] rzt=>" + data)
        rztobj=JSON.parse(data);

        // $("#loaddiv").hide();

        //rzt=  dsl_callFunCmdMode("playerStat",$("#uname").val() )
        //  rzt=  dsl_callFunCmdMode("PlayerScoreQry",$("#uname").val() )


        //  {"maintype":"/GameHandle","type":7,"data":{"code":0,"agentid":111356,"linecode":"10001_1","status":0,"userid":32076939,"account":"uname1","totalScore":300.0,"integralvalue":6.0,"addscore":300.0,"subscore":0.0,"addscoretimes":2,"subscoretimes":0,"totalwinlose":0.0,"totalrevenue":0.0}}

        // rztobj=JSON.parse(rzt);


        if(rztobj.data.code==0)
            window['bindJsonToTable'](rztobj)
        else
            alert( window["errcodeMsg"+rztobj.data.code] +" "+ data)

        //  console.log("[playerStat237] rzt=>" + rzt)




    })



}
function  shangfen1236()
{

    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);



    rzt=  dsl_callFunCmdMode("shangfen",$("#uname").val(),$("#score").val())



    console.log("[shangfen1236] rzt=>" + rzt)
    rztobj=JSON.parse(rzt);
    if(rztobj.data.code==0)
        alert("上分成功")
    else
        alert(rzt)
}
