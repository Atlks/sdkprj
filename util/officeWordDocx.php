<?php

$word = new COM("word.application") or die("Can't start Word!");
$url="C:\Users\ATI\Documents\欧盟通用数据保护条例GDPR.docx";
//打开路径为URL的word，doc或docx都可以
$word->Documents->OPen($url);

//读取内容
$test = $word->ActiveDocument->content->Text;
print_r(explode('\n',$test));
//echo $test;
