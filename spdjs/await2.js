async function getDetailLinkV2() {


    await setTimeout(await async function () {

        console.log("---aft 5 dec")
    }, 5000);

}



(async () => {



    var asyncMd = require('async');


    var task = [];
    task.push(async function (callback) {
        await getDetailLinkV2();
    })



    asyncMd.waterfall(task,async function (err, result) {
        console.timeEnd('访问3个网站时间统计');
        if (err) return console.log(err);
        console.log('全部访问成功');

    });



    console.log("f")

})();