<?php
echo "start...";
//echo fib(9999);
//echo fib2(123456789);
//  D:\wamp\bin\php\php7.1.9\php.exe  "C:\Users\ati\OneDrive\桌面\prjs hsu6\prjphp\www\api\perf.php"
//echo fib8(123456789);
list2();



function list2()

{
	
 
$pdo = new PDO("mysql:host=localhost;port=3306;dbname=db1", 'root', '');//创建一个pdo对象
$pdo->exec("set names 'utf8'");
$sql = "select * from user";


$sth = $pdo->query($sql);
$rows = $sth->fetchAll();
 
 $r='';
 foreach($rows as $value){
	//echo $value.'<br />';
	 $r=$value['name'].$r.list3();
	 //echo $r;
	 $r=substr($r,0,20);
}
//echo json_encode($rows);
return  $r;	
	
}

function list3()

{
	
 
$pdo = new PDO("mysql:host=localhost;port=3306;dbname=db1", 'root', '');//创建一个pdo对象
$pdo->exec("set names 'utf8'");
$sql = "select * from user limit 10";


$sth = $pdo->query($sql);
$rows = $sth->fetchAll();
 
 $r='';
 foreach($rows as $value){
	//echo $value.'<br />';
	 $r=$value['name'].$r;
	// echo $r;
	 $r=substr($r,0,20);
}
//echo json_encode($rows);
return  $r;	
	
}

function fib8($n) {
    
	$r=0;
    for ($i = 2; $i <= $n; $i++) {
         	  $tmp=  $tmp+1;
		  $tmp=  $tmp-2;
		  $tmp=  $tmp+1;
		  $tmp=  $tmp*2;
  # return  $tmp;
		  $tmp=  $tmp/2;
		$r=	  $tmp+$n+1;
    }
   return $r;
}
function fib9($n) {
    $f0 = 0;
    $f1 = 1;
    $f2 = 0;

    if ($n == 0 || $n == 1) {
        return $n;
    }

    for ($i = 2; $i <= $n; $i++) {
        $f2 = $f0 + $f1;
        $f0 = $f1;
        $f1 = $f2;
    }

    return $f2;
}




//D:\wamp\bin\php\php7.1.9\php.exe   "C:\Users\ati\OneDrive\桌面\prjs hsu6\prjphp\www\api\perf.php"
function fib($n = 1)
{
    // 低位处理
    // if ($n < 3) {
    //     return 1;
    // }
    // 递归计算前两位
    return fib($n - 1) + fib($n - 2);
}

function fib2($n = 1)
{
	$r=1;
     for ($i = 0; $i <= $n; $i++) {
        $r =($n+1-2+1)*2/2+1;
      //  echo $r;
    }
    return  $r;
}
?>

