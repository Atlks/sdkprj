function clk() {
    document.getElementById("fname").value = 111;
    console.log(1111111111111111)


    writeFileSyncx("43200x.txt", "999");
    mainPrcsFun1();
}


function writeFileSyncx(fil, str) {
    var fs = require("fs");
    var path = require("path");
    fs.mkdirSync(path.dirname(fil), { recursive: true });
    //   fs.mkdirSync(appRoot + '/css

    fs.writeFileSync(fil, str);
}