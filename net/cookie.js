// JavaScript Document

// Example: jeig haosyo not take effect in file propotocal...only http can use ..

// writeCookie("myCookie", "my name", 24);

// Stores the string "my name" in the cookie "myCookie" which expires after 24 hours.

function writeCookie(name, value, hours)

{

  var expire = "";

  if(hours != null)

  {

    expire = new Date((new Date()).getTime() + hours * 3600000);

    expire = "; expires=" + expire.toGMTString();
	 path="; path=/";

  }

  document.cookie = name + "=" + escape(value) + expire+path;

}

function setCookie(name, value, expires, path, domain, secure)
    {
        document.cookie = name + "=" + escape(value) +
            ((expires) ? "; expires=" + expires : "") +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            ((secure) ? "; secure" : "");
    }

// Example:

// alert( readCookie("myCookie") );

function readCookie(name)

{

  var cookieValue = "";

  var search = name + "=";

  if(document.cookie.length > 0)

  { 

    offset = document.cookie.indexOf(search);

    if (offset != -1)

    { 

      offset += search.length;

      end = document.cookie.indexOf(";", offset);

      if (end == -1) end = document.cookie.length;

      cookieValue = unescape(document.cookie.substring(offset, end))

    }

  }

  return cookieValue;

}

// * Dependencies * 

// this function requires the following snippets:

// JavaScript/images/switchImage

//

// BODY Example:

// <body onLoad="mySlideShow1.play(); mySlideShow2.play();">

// <img src="originalImage1.gif" name="slide1">

// <img src="originalImage2.gif" name="slide2">

//

// SCRIPT Example:

// var mySlideList1 = ['image1.gif', 'image2.gif', 'image3.gif'];

// var mySlideShow1 = new SlideShow(mySlideList1, 'slide1', 3000, "mySlideShow1");

// var mySlideList2 = ['image4.gif', 'image5.gif', 'image6.gif'];

// var mySlideShow2 = new SlideShow(mySlideList2, 'slide2', 1000, "mySlideShow2");

function SlideShow(slideList, image, speed, name)          

{

  this.slideList = slideList;

  this.image = image;

  this.speed = speed;

  this.name = name;

  this.current = 0;

  this.timer = 0;

}

SlideShow.prototype.play = SlideShow_play;  

function SlideShow_play()       

{

  with(this)

  {

    if(current++ == slideList.length-1) current = 0;

    switchImage(image, slideList[current]);

    clearTimeout(timer);

    timer = setTimeout(name+'.play()', speed);

  }

}

