 <?php 
 // "D:\workspace 空格\amaz_spider\WpfApplication1\php5.3.10\php.exe"  -c "D:\workspace 空格\amaz_spider\WpfApplication1\php5.3.10\php.ini"  -f "D:\workspace 空格\amaz_spider\WpfApplication1\com.attilax/api.php" "tagP823=1&textfield=2015-9-1&textfield2=09%253A10&prod_name=iphone%2bcase&select=%25E6%258E%2592%25E5%2590%258Dxy&select3=%25E6%258E%2592%25E5%2590%258Dxy&select4=%25E5%25A5%25BD%25E8%25AF%2584&select5=%25E5%25A5%25BD%25E8%25AF%2584&select6=%25E8%25B7%259F%25E5%258D%2596%25E4%25B8%25AA%25E6%2595%25B0&select9=%25E8%25B7%259F%25E5%258D%2596%25E4%25B8%25AA%25E6%2595%25B0&select7=%25E5%25A5%25BD%25E8%25AF%2584%25E6%2595%25B0%25E7%259B%25AE&select8=%25E5%25A5%25BD%25E8%25AF%2584%25E6%2595%25B0%25E7%259B%25AE&select2=%25E5%25BA%2597%25E9%2593%25BA%25E8%25AF%2584%25E4%25BB%25B7%25E6%2595%25B0&select10=%25E5%25BA%2597%25E9%2593%25BA%25E8%25AF%2584%25E4%25BB%25B7%25E6%2595%25B0&method=search_context&$callback=search_context_finish&$parser=php"
  error_reporting(E_ALL ^(E_NOTICE | E_WARNING)); 

	function   urlParams2Map( $params) {
		 $o=array();
		$a=explode('&',$params);
		 $GLOBALS["varx"]["a"]=$a ;
		  $GLOBALS["varx"]["params"]=$params;
	  foreach( $a as $k2=>$v2 )
	  {
		 
		  $a2=explode("=",$v2);
		   $k=$a2[0];
		   $v=$a2[1];
		   $o[$k]=$v;
	  }
		   $GLOBALS["varx"]["o"]=$o ;
		return $o;
		
	}
//echo "tag921";
 //eval

// print_r($_GET);
 
 // print_r("----count:".count($_GET));
 if(count($_GET)==0) //cli mode
 {
	 
	 $param=$argv[1]; 
	  $GLOBALS["varx"]["argv"]=$argv ;
	 
	 $_GET=urlParams2Map($param); 
	   $GLOBALS["varx"]["get"]=$_GET ;
	  
	 
 }
 // print_r( $GLOBALS["varx"]);
// print_r($_GET);
 if($_GET["iocx"]!="" && $_GET["iocx"]!="")
	 require_once(dirname(__FILE__).'/../'.$_GET["iocx"].'.php');
 else
	 require_once(dirname(__FILE__).'/../iocx.php');
//echo "tag92a1";
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
 //
 // print_r($GLOBALS["varsx"]);
  $GLOBALS["varx"]["get..param"]=@$_GET['param'] ;
  // print_r($GLOBALS["varx"]);
  // echo "tg";
  try{
	  if( @$_GET['param']=="")
	  {
		//  echo "tag1";
		   $GLOBALS["stack"][]="param is empty";
 			$rzt=$fun();
	  }
		else
		{//   echo "tag2";
			 $GLOBALS["stack"][]="param not empty";
			$rzt=$fun($_GET['param']);
		}
  }catch(Exception $e)
  {
	   echo "tag3";
	   //todxo p91
	    echo '\r\n getLine: ' .$e->getLine();
		 echo '\r\ngetFile: ' .$e->getFile();
	   echo '\r\nMessage: ' .$e->getMessage();
	   echo "-------code:".$e-> getCode();
	    echo "-------getTraceAsString:".$e-> getTraceAsString ();
		
	echo  json_encode($e);// "err";
	exit;
  }
 
  $GLOBALS["varx"]["rzt"]=$rzt ;

$vars_list["rzt"]=$rzt;
 echo  json_encode($rzt);
// echo "111";
 //print_r($vars_list);
//  print_r($GLOBALS["varx"]);
 ?>