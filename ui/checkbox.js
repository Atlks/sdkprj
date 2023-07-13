// JavaScript Document

function setAllSelect(trigCheckboxId,otherBoxInDivId,otherBoxName)
{
	// 未选素材全选
	$("#"+trigCheckboxId).click(
			function() {
				if ($(this).attr("checked") == "checked") { // 全选
					$("#"+otherBoxInDivId+" input[name='"+otherBoxName+"']").each(
							function() {
								$(this).attr("checked", true);
							});
				} else { // 取消全选
					$("#"+otherBoxInDivId+" input[name='"+otherBoxName+"']").each(
							function() {
								$(this).attr("checked", false);
							});
				}
			});
			
			
}
/**
todox checkbox allSelect  
*/
function setAllSelect(trigCheckbox)
{
//	alert($(trigCheckbox).attr("checked"));
	// 未选素材全选
//	$(trigCheckbox).click(
//			function() {
				if ($(trigCheckbox).attr("checked") == "checked") { // 全选
					$("  input ").each(
							function() {
								$(this).attr("checked", true);
							});
				} else { // 取消全选
					$(" input ").each(
							function() {
								$(this).attr("checked", false);
							});
				}
		//	});
			
			
}


function getVals_byName(name)
{
	var el=$("input[name='"+name+"']:checked");
		    var dropIds ="nonex";
                   el.each(function(){  
						
                        dropIds=dropIds+","+($(this).val());  
                    });  	
}