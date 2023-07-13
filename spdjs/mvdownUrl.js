var urltmp = "https://cn.pornhub.com/video?c=${cate}&page=${page}";


url="https://cn.pornhub.com/view_video.php?viewkey=ph5e49b6ff6718b"

cookiestr="platform_cookie_reset=pc; bs=1c4kzj3f66wkucadhfs8a2yaucrum4kd; ss=921634582515377434; _ga=GA1.2.2131912552.1582104044; _gid=GA1.2.2143965950.1582104044; RNLBSERVERID=ded6890; performance_timing=categories; il=v1c-vEFuIJbynM-gZ5Q4kiNy96pIneiOVPPPu_z9EqSZYxNTg5OTY1OTA5U2UwVjRuNEtsSl9wUnRLWTJnQktSZlRiaGdON1Z6X0M2U3pfbDdQLQ..; expiredEnterModalShown=1; ua=65f29516619e512285e456d1418987ae; platform=pc";

const request = require('request');
//console.log   "user-agent","Mozilla/5.0"
request(url, { headers: { 'User-Agent': "Mozilla/5.0", 'Cookie': cookiestr } }, (err, res, body) => {
    if (err) { return console.log(err); }
    console.log(res);
          //  console.log(body);

          var fs = require("fs");

          fs.writeFileSync(fname, body);


}