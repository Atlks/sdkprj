// JavaScript Document


function bind_json2select(json_arr,controlId)
{
	json_arr=str2json(json_arr);
   $(json_arr).each(
   			function (i) {
            
                
                 var x = json_arr[i];
                 $("#"+controlId).append("<option value='" + eval("x.v" ) + "'>" + eval("x.t") + "</option>");
             }
			 );
         
		 
 }