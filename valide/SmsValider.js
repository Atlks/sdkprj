

//@inject  validor_BefSendSms
function SmsValider(ctrlId)
{


this.ctrlId=ctrlId;
this.tmpl="您的验证码为：$capt$请勿向任何人泄露。非本人操作请忽略本短信";
this.senderCssSelector="#username";




}

SmsValider.prototype.captch_click=function()
{

	AtiValid.valid("username");

	var sms=this.tmpl;
sms=encodeURIComponent(sms);
var brj=new AtiJsBridge();

brj.exe("$method=com.attilax.sms.SmsCaptchaService.send&param1="+$("#username").val() +"&param2="+sms  ,function(data){

	  try{
								  callback_checkJavaEx(data);
							  }catch(e)
							  {
							  		showErr(e);
							  		return;
							  }

alert("发送成功，请等待接收。。。");

} );
}

SmsValider.prototype.ini=function()
{
	var self=this;
   $("#capt_btn").on("click",  function () {
             var fun=    self.captch_click.bind(self);
                fun();
            });

}


