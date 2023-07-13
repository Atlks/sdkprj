/**
 * Created by Administrator on 2017/6/7.
 */
var log4js=require('log4js');//注意log4js的module位置引用是否正确
//log the cheese logger messages to a file, and the console ones as well.
log4js.configure({
    appenders: [
        {
            type: "file",
            filename: "logs/nodeerr_picfile_gender_finder.log"
            // category:'app' //之间加了category后发现无法写入文件，
        },
        {
            type: "console"
        }
    ],
    replaceConsole: true
});


var logger=log4js.getLogger();
logger.setLevel('debug');
logger.trace('Entering cheese testing');
/**
 * { lYear: 2017,
  lMonth: 5,
  lDay: 13,
  Animal: '鸡',
  IMonthCn: '五月',
  IDayCn: '十三',
  cYear: 2017,
  cMonth: 6,
  cDay: 7,
  gzYear: '丁酉',
  gzMonth: '丙午',
  gzDay: '乙丑',
  isToday: true,
  isLeap: false,
  nWeek: 3,
  ncWeek: '星期三',
  isTerm: false,
  Term: null,
  astro: '双子座' }
 * @type {exports|module.exports}
 */
var lunarUtil    = require("./calendar_lunar.js");

/*
function getTableRows_byLunarYearMonth( year,month)
{
    var table=[];
    var row={};
    var month=5
    for(var i=1;i<=30;i++)
    {
        if(i==25)
            console.log("dbg")
        var r=lunarUtil.calendarObj.lunar2solar(year,month,i);

        if( r.nWeek==undefined &&i==30){
            table.push(row);
            continue;
        }


        if(r.nWeek==1)
        {
            table.push(row);
            row={};//renew one
        }


        var cell_obj={}
        cell_obj. solar_str= r.cMonth+"-"+ r.cDay;
        cell_obj.lunar_str= r.lMonth+"-"+ r.lDay;
        cell_obj.week=r.nWeek;
        row["week"+r.nWeek]=JSON.stringify( cell_obj);


        console.log(r)
    }
    return table;
}
*/
//var table= lunarUtil.getTableRows_byLunarYearMonth(2017,5);
var table= lunarUtil.getRowsList_byLunarYearMonth(2017,5);

console.log("-------------------------------------show table-");
console.log(table)



