require('chromedriver'); //导入chrome浏览器 driver

var webdriver = require('selenium-webdriver'); //导入selenium 库

var driver = new webdriver.Builder().forBrowser('chrome').build(); //创建一个chrome 浏览器实例




driver.get("https://cn.pornhub.com/video?c=27&page=5")


// setTimeout(function(){




// },5000);


driver.sleep(10 * 1000).then(function () { //等待20秒
    //driver.quit(); //关闭浏览器

    cookiestr = "platform_cookie_reset=pc; bs=1c4kzj3f66wkucadhfs8a2yaucrum4kd; ss=921634582515377434; _ga=GA1.2.2131912552.1582104044; _gid=GA1.2.2143965950.1582104044; RNLBSERVERID=ded6890; performance_timing=categories; il=v1c-vEFuIJbynM-gZ5Q4kiNy96pIneiOVPPPu_z9EqSZYxNTg5OTY1OTA5U2UwVjRuNEtsSl9wUnRLWTJnQktSZlRiaGdON1Z6X0M2U3pfbDdQLQ..; ";
    // exesrcRzt=driver.executeScript('alert()');
    //    try{
    //     exesrcRzt=driver.executeScript('document.cookie='+cookiestr);
    //     console.log(  driver.executeScript("return document.readyState"));
    //    // console.log(exesrcRzt);
    //    }catch(e)
    //    {
    //        console.log(e)
    //    }

    //  driver.get("https://cn.pornhub.com/view_video.php?viewkey=ph5e49b6ff6718b") //打开https://autowebtest.github.io/
    console.log(driver.getCurrentUrl());

    driver.getTitle().then(function (title) {


        console.log(title);

    });
    console.log(driver.getTitle())
    console.log(driver.getPageSource())

    driver.getPageSource().then(function (getPageSource) {


        console.log(getPageSource);

    });

    // driver.quit(); //关闭浏览器
})
