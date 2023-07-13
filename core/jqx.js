// JavaScript Document


 $(function(){ 
// do something 
//alert($(document.body));
       $(document.body).on("swipe",function(){
      if(confirm("reload??"))
	  		window.location.reload();
		  
	});
}); 


function  isChecked(objID)
{
	 return ($("#"+objID).is(':checked'));	
}

function getRadioValue(objName)
{
  var val=$('input:radio[name="'+objName+'"]:checked').val();
  return	val;
}