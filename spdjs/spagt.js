
var url = 'https://cn.pornhub.com/video?c=80&page=1';
const superagent = require('superagent');
 
superagent.get(url)
.query({ api_key: 'DEMO_KEY', date: '2017-08-02' })
.end((err, res) => {
  if (err) { return console.log(err); }
  console.log(res.body.url);
  console.log(res.body.explanation);
});

 