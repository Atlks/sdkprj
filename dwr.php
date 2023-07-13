 <?php 
 //depred should use api.php
 error_reporting(E_ALL ^(E_NOTICE | E_WARNING)); 


 //eval
 
 if($_GET["iocx"]!="" && $_GET["iocx"]!="")
	 require_once(dirname(__FILE__).'/../'.$_GET["iocx"].'.php');
 else
	 require_once(dirname(__FILE__).'/../iocx.php');

//$dwrEventContainer['b'] = 'char b'; 
 
 
 $method=   $_GET['method']; 
 
  global $vars_list;
	 
 $vars_list["method"]=$method;
 $fun=@ $dwrEventContainer[ $method];
 
 $GLOBALS["varx"]["method"]=$method ;
 //ati p7j
 if(!$fun)
 {
	  $fun=$method;
	// \\eval("\$str = \"$str\";");
	//  eval( "$fun=$method ");
 }
  $GLOBALS["varx"]["fun"]=$fun ;
  $vars_list["fun"]=$fun;
//  print_r($GLOBALS["varx"]);
 // print_r($GLOBALS["varsx"]);
  $GLOBALS["varx"]["get..param"]=@$_GET['param'] ;
 
  try{
	  if( @$_GET['param']=="")
	  {
		   $GLOBALS["stack"][]="param is empty";
 			$rzt=$fun();
	  }
		else
		{
			 $GLOBALS["stack"][]="param not empty";
			$rzt=$fun($_GET['param']);
		}
  }catch(Exception $e)
  {
	echo  json_encode($e);// "err";
	exit;
  }
 
$vars_list["rzt"]=$rzt;
 echo $rzt;
// echo "111";
 //print_r($vars_list);
//  print_r($GLOBALS["varx"]);
 ?>