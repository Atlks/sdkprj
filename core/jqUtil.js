// JavaScript Document

function escapeJquery(srcString)
{
	// 转义之后的结果
	var escapseResult = srcString;

	// javascript正则表达式中的特殊字符
	var jsSpecialChars = ["\\", "^", "$", "*", "?", ".", "+", "(", ")", "[",
			"]", "|", "{", "}"];

	// jquery中的特殊字符,不是正则表达式中的特殊字符
	var jquerySpecialChars = ["~", "`", "@", "#", "%", "&", "=", "'", "\"",
			":", ";", "<", ">", ",", "/"];

	for (var i = 0; i < jsSpecialChars.length; i++) {
		escapseResult = escapseResult.replace(new RegExp("\\"
								+ jsSpecialChars[i], "g"), "\\"
						+ jsSpecialChars[i]);
	}
//alert("--"+escapseResult);
	for (var i = 0; i < jquerySpecialChars.length; i++) {
		escapseResult = escapseResult.replace(new RegExp(jquerySpecialChars[i],
						"g"), "\\" + jquerySpecialChars[i]);
	}


//if(escapseResult.substr(0,1)=="\\")
//	return "\\"+escapseResult;
//	else
	return escapseResult;
}

