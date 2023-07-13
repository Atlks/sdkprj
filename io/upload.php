<?php
 
	//var_dump($_FILES);
	
	//		//第三个参数是“true”表示能创建多级目录，iconv防止中文目录乱码

	//	$res=mkdir(iconv("UTF-8", "GBK", $path),0777,true); 
	$fname=time();
	$f=dirname(dirname(dirname(__FILE__))).'/uploadx/'.$fname.'.jpg';
	@mkdir(dirname( $f),0777,true); 
//	print_r($_FILES);
$file_frm_client=$_FILES['upfile']['tmp_name'];
if(!$file_frm_client)
	$file_frm_client=$_FILES[0]['tmp_name'];
	move_uploaded_file($file_frm_client, $f);
	//header('location: test.php');
	echo $fname.".jpg";
	setcookie("filex",$fname.".jpg");
 	setcookie("file_url","uploadx/".$fname.".jpg");
?>