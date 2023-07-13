// JavaScript Document
function orderbyAsc  (arrdata,fld)
{
	  return arrdata.sort(function(a, b) {
		  var aval=(a[fld]);
		  if(aval==null)
		 	 aval=0;
		  var bval=b[fld];
		  if(bval==null)
			  bval=0
		   var rzt= aval- bval;
     	   return rzt;
  	  });
	
}


// 冒泡排序
 function bubbleSort(array,fld) {
    var i = 0,
    len = array.length,
    j, d;
    for (; i < len; i++) {
        for (j = 0; j < len; j++) {
            if (array[i][fld] < array[j][fld]) {
                d = array[j];
                array[j] = array[i];
                array[i] = d;
            }
        }
    }
    return array;
}


function orderbyDesc  (arrdata,fld)
{
	  return arrdata.sort(function(a, b) {
		    var aval=(a[fld]);
		  if(aval==null)
		 	 aval=0;
		  var bval=b[fld];
		  if(bval==null)
			  bval=0
		  var rzt= bval-aval;
     	   return rzt;
  	  });
	
}

function orderArrow_ini(jqobj,arrdata,fld,orderedEventHandler)
{
	var upobj=$(jqobj+" .fa-chevron-circle-up");
	var downobj=$(jqobj+" .fa-chevron-circle-down");
	upobj.show();
	downobj.hide();
	
	
	$(upobj).on('click',function(){
					$(this).hide();
				downobj.show();
				var arr_ordered=  orderbyDesc(arrdata,fld);
				console.log( JSON.stringify(arr_ordered));
				orderedEventHandler(arr_ordered);
				
	});
	
	
	downobj.on('click',function(){
					downobj.hide();
				upobj.show();
					var arr_ordered=orderbyAsc(arrdata,fld);
				console.log( JSON.stringify(arr_ordered));
				orderedEventHandler(arr_ordered);
	});

 
	
}

function showhide()
{
	
	//$("#button11").on('click',function(){
		
}