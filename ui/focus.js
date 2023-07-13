// JavaScript Document


function setFocus(obj)
{

	$(obj).addClass('selected');
}
function cancelFocus(obj)
{
	$(obj).removeClass('selected');
 

}
function setSelect(obj)
{
$(obj).addClass('sltOnly');

}
function cancelSelect(obj)
{
$(obj).removeClass('sltOnly');
	
}
function setFocusNSelect(obj)
{
	setFocus(obj);
	setSelect(obj);

}
function cancelFocusNSelect(obj)
{
cancelFocus(obj); cancelSelect(obj);
}