// JavaScript Document


function getElementsByClassName (className) {
     var all = document.all ? document.all : document.getElementsByTagName( ' *' );
     var elements = new Array();
     for ( var e = 0; e < all.length; e ++ ) {
        elements[elements.length] = all[e];
        break ;
      }
  
    return elements; 
	
	 }  