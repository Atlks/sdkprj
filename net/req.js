// JavaScript Document


UrlParm = function() { // url参数
  var data, index;
  (function init() {
    data = [];
    index = {};
    var u = window.location.search.substr(1);
    if (u != '') {
      var parms = decodeURIComponent(u).split('&');
      for (var i = 0, len = parms.length; i < len; i++) {
        if (parms[i] != '') {
          var p = parms[i].split("=");
          if (p.length == 1 || (p.length == 2 && p[1] == '')) {
            data.push(['']);
            index[p[0]] = data.length - 1;
          } else if (typeof(p[0]) == 'undefined' || p[0] == '') {
            data[0] = [p[1]];
          } else if (typeof(index[p[0]]) == 'undefined') { // c=aaa
            data.push([p[1]]);
            index[p[0]] = data.length - 1;
          } else {// c=aaa
            data[index[p[0]]].push(p[1]);
          }
        }
      }
    }
  })();
  return {
    // 获得参数,类似request.getParameter()
    parm : function(o) { // o: 参数名或者参数次序
      try {
        return (typeof(o) == 'number' ? data[o][0] : data[index[o]][0]);
      } catch (e) {
      }
    },
    //获得参数组, 类似request.getParameterValues()
    parmValues : function(o) { //  o: 参数名或者参数次序
      try {
        return (typeof(o) == 'number' ? data[o] : data[index[o]]);
      } catch (e) {}
    },
    //是否含有parmName参数
    hasParm : function(parmName) {
      return typeof(parmName) == 'string' ? typeof(index[parmName]) != 'undefined' : false;
    },
    // 获得参数Map ,类似request.getParameterMap()
    parmMap : function() {
      var map = {};
      try {
        for (var p in index) {  map[p] = data[index[p]];  }
      } catch (e) {}
      return map;
    }
  }
}();

//使用示例:
//url: http://127.0.0.1/demo.jsp?a&page=2&b=dd&c=123&b=dd2
//UrlParm.parm(0)             // 结果:  "";
//UrlParm.parm('a')            // 结果:  "";
//UrlParm.parm('page')       // 结果:  "2";
//UrlParm.parm(1)             // 结果:  "2";
//UrlParm.parm("b")           // 结果:  "dd";
//UrlParm.parmValues("b")  // 结果:  ["dd","dd2"];
//UrlParm.hasParm("b")      // 结果:  true;
//UrlParm.hasParm("x")      // 结果:  false;
//UrlParm.parmMap()        // 结果:  {a:[""],page:[2],b:["dd","dd2"],c:["123"]};