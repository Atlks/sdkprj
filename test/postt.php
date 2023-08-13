<?php



$txt=file_get_contents('C:/modyfing/jbbot/tlgrm/wbhkPost.json');

echo $txt;

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $txt,
    ),
);

$context  = stream_context_create($options);
$url='http://localhost/keywordHander.php';
echo file_get_contents($url, false, $context);


//cls
//echo file_get_contents('http://localhost/keywordHander.php');


//php test/postt.php