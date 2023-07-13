// JavaScript Document
function sendNSCommand()
{
//arguments
var s=(arguments);
var argsArray = Array.prototype.slice.call(arguments);

window.external.sendNSCommand(argsArray[0],argsArray[1],argsArray[2],argsArray[4],argsArray[5],argsArray[6],argsArray[7]);
//alert(window.external);
}