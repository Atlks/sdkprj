/*
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 * Created by Administrator on 2017/6/6.
 */


function minMin(r, g, b) {
    var m;
    m = r;
    if (m > g)

        m = g;
    if (m > b)
        m = b;

    return m;
}

function maxMax(r, g, b) {
    var m;
    m = r;
    if (m < g)

        m = g;
    if (m < b)
        m = b;

    return m;
}

var gm = require("gm")

function getCenterRang(f, wid2, hit2) {
    var images = require("images");
    var w = images(f).width();
    var w_center = w / 2;
    var height = images(f).height();
    var h_cen = height / 2;
    var x = w_center - (wid2 / 2);
    var y = h_cen - (hit2 / 2);

    console.log("wid_cen_x:" + w_center + ";hit_cen_y:" + h_cen)
    console.log("w:" + w + ";h:" + height)
    console.log("x:" + x + ";y:" + y)
    var o = {};
    o.wid_cen_x = w_center;
    o.hit_cen_y = h_cen;
    o.rangWid = wid2;
    o.ranghit = hit2;
    o.rangX = x;
    o.rangY = y;
    o.w = w;
    o.h = height;

    console.log(o);
    return o;
}

//ret gm obj
function crop(f, rang) {
    width = 150;
    height = 50;
    x = 0, y = 0;
    return gm(f).crop(rang.rangWid, rang.ranghit, rang.rangX, rang.rangY);

    /*
    *
    *
    *    .write('C:\\0000wechatpic\\a_tar.png', function(err){
    if (err) {
        console.log(err);

    }});
    * */


}

function getPixs(f, handler) {
    var getPixels = require("get-pixels")

    getPixels(f, handler(f));
}


function main() {
    var f = "C:\\0000wechatpic\\a.png";
    rangobj = getCenterRang(f, 500, 800);
    gmobj = crop(f, rangobj);
    gmobj.write('C:\\0000wechatpic\\a_tar2.png', function (err) {
        if (err) {
            console.log(err);

        }
    });
    console.log("--f")
}

/*
gtpixHandler=function(err, pixels) {
    if(err) {
        console.log("Bad image path")
        return
    }


    trave(pixels,function(x,y){
        r=   pixels.get(x,y,0);g=pixels.get(x,y,1);b=pixels.get(x,y,2);
        hsv=rgb2hsv(r,g,b);
        if( isWihteColor(hsv))
            WihteColorPixCount++;
        else if(isBlackColor(hsv) )
            BlackColorPixCount++;
        else
            otherColorPixCount++;
    })
    console.log(pixels)
}

*/

function isWihteColor(hsv) {
    if (hsv.s <= 5 && hsv.v > 95)
        return true;
    if (hsv.h == 0 && hsv.s == 0 && hsv.v >= 65)  //gray
        return true;
    return false;
}

function isBlackColor(hsv) {
    if (hsv.v < 5)
        return true;
    if (hsv.h < 5 && hsv.s < 5 && hsv.v < 25)
        return true;
    if (hsv.h == 0 && hsv.s == 0 && hsv.v < 65)  //gray
        return true;
    return false;
}

function rgb2hsv(r, g, b) {
    return RGB2HSV(r, g, b);
}

//360du,100%,100% mode
function RGB2HSV(rr, gg, bb) {
    var r = rr;
    var g = gg;
    var b = bb;
    var max = maxMax(r, g, b);
    var min = minMin(r, g, b);
    var h = 0;
    if (max == min)
        h = 0;
    else if (r == max && g >= b)
        h = (g - b) / (max - min) * 60;
    else if (r == max && g < b)
        h = (g - b) / (max - min) + 360;
    else if (g == max)
        h = (b - r) / (max - min) * 60 + 120;
    else if (b == max)
        h = (r - g) / (max - min) * 60 + 240;

    var s = (max - min) / max;
    if (max == 0)
        s = 0;
    //  HSV hsv = new HSV(h, s,  max/255);
    var hsv = {};
    hsv.h = h;
    hsv.s = s * 100;
    hsv.v = max / 255 * 100;
    return hsv;
}

function calcColorCount(pixels, wid, hit) {
    for (var w = 0; w < wid; w++)
        for (var h = 0; h < hit; h++) {
            r = pixels.get(w, h, 0);
            g = pixels.get(w, h, 1);
            b = pixels.get(w, h, 2);
            hsv = rgb2hsv(r, g, b);
            if (isWihteColor(hsv))
                WihteColorPixCount++;
            else if (isBlackColor(hsv))
                BlackColorPixCount++;
            else {
                otherColorPixCount++;
                // var debg={w:w,h:h,hsv:hsv};
                //   console.log(debg )
            }

        }

    var o = {};
    o.WihteColorPixCount = WihteColorPixCount;
    o.BlackColorPixCount = BlackColorPixCount;
    o.otherColorPixCount = otherColorPixCount;
    return o;
}

function travePicPixs(f, getPixAftFun) {
    var getPixels = require("get-pixels")

    getPixels(f, function (err, pixels) {
        if (err) {
            console.log(err);
            return;
        }
        var images = require("images");
        var images2 = images(f);
        var w = images2.width();
        var h = images2.height();
        getPixAftFun(pixels, w, h);
    });

}

var WihteColorPixCount = 0
var BlackColorPixCount = 0;
var otherColorPixCount = 0
//main()
f = 'C:\\0000wechatpic\\a_tar2.png';
travePicPixs(f, function (pixels, wid, hit) {
    var o = calcColorCount(pixels, wid, hit);
    console.log(o);
});

/*
*

var getPixels = require("get-pixels")

getPixels("lena.png", function(err, pixels) {
    if(err) {
        console.log("Bad image path")
        return
    }
    console.log(pixels)
})

* */