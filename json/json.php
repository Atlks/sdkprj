
<?php
  

//  json_encode增加了JSON_UNESCAPED_UNICODE , JSON_PRETTY_PRINT 等几个常量参数。使显示中文与格式化更方便。
function  json_encodex($obj)
{
	return   json_encode($obj,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	
}


