function senfe(o,a,b,c,d){
		var t=document.getElementById(o).getElementsByTagName("tr");
		for(var i=0;i<t.length;i++){		
			t[i].style.backgroundColor=(t[i].sectionRowIndex%2==0)?a:b;
			t[i].onclick=function(){
				if(this.x!="1"){
					this.x="1";
					this.style.backgroundColor=d;
				}else{	
					this.x="0";
					this.style.backgroundColor=(this.sectionRowIndex%2==0)?a:b;
				}
			}
			t[i].onmouseover=function(){
				if(this.x!="1")this.style.backgroundColor=c;
			}
			t[i].onmouseout=function(){
				if(this.x!="1")this.style.backgroundColor=(this.sectionRowIndex%2==0)?a:b;
			}
		}
	}

senfe("linkInfoTbody","#fff","#ccc","#cfc","#7993B4");

/*$(function() {
	$.post("ajaxDictionaryList",{"code":code},function(data){ 
		  $("#linkInfoTbody tr").each(function(){ 
			  var tdScreen = $(this).children("td[name='tdDictionary']");
			  $.each(data, function(i, txt){  
				  var screen = $.trim(tdScreen.text());
					 if(screen == txt.DCode){
						 tdScreen.text(txt.DName); 
					 }
			  }); 
	      })  
	},"json"); 
}); */

//$("#table1 tr").hover(function(){   

//	$(this).children("td").addClass("hover")   

//	},function(){   

//	$(this).children("td").removeClass("hover")   

//	})   


//2.奇偶行不同颜色

//$("#table1 tbody tr:odd").css("background-color", "#bbf");   

//$("#table1 tbody tr:even").css("background-color","#ffc");   

//$("#table1 tbody tr:odd").addClass("odd")   

//$("#table1 tbody tr:even").addClass("even")   