function hotkey(event)
{
var a=event.keyCode;
if((a==68)&&(event.ctrlKey)&& event.altKey )
{
//alert("你按了ctrl+alt+d键吧");
//okTips()
//tipsO81();
$('#dbgW').window('open');
}
}// end hotkey
document.onkeydown = hotkey; //当onkeydown 事件发生时调用hotkey函数
