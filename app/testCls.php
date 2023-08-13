<?php

namespace app;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use app\model\Setting;
use think\view\driver\Php;

//   C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\modyfing\jbbot\think swoole2 

function testKaij()
{
  echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@" . PHP_EOL;
  echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@." . PHP_EOL;
  echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@." . PHP_EOL;

  $gmLgcSSc = new    \app\common\GameLogicSsc();

  $data['hash_no'] = 17870669;
  $data['lottery_no'] = 17870669;
  $gmLgcSSc->lottery->setData($data);
  $gmLgcSSc->hash_no =   $data['hash_no'];
  $gmLgcSSc->lottery_no = $data['hash_no'];

  global $lottery_no;
  $lottery_no = 17890257;
  kaij_draw_evt();
  echo 999;

  // var_dump($gmLgcSSc->DrawLotteryV2("0xajfdklsjfl91690"))  ;
}


function painTest()
{
  $gmLgcSSc = new   \app\common\GameLogicSsc();
  $gmLgcSSc->SendTrendImage(3);
  //  imagepng($img, app()->getRootPath() . "public/trend.jpg");
}
class testCls extends Command
{
  protected function configure()
  {
    // 指令配置
    $this->setName('testClsNm')
      ->setDescription('the cmd2 command');
  }

  protected function execute(Input $input, Output $output)
  {
    painTest();
    die();

    testKaij();
    die();
    // 指令输出
    //  $output->writeln('cmd2');
    $gmLgcSSc = new   \app\common\GameLogicSsc();  //comm/gamelogc
    //  $gmLgcSSc->SendTrendImage(7); // 生成图片
    //  $cfile = new \CURLFile(app()->getRootPath() . "public/trend.jpg");
    echo 000;

    $qihao = 17875980;

    $gmLgcSSc = new   \app\common\GameLogicSsc();  //comm/gamelogc
    var_dump($gmLgcSSc->calcIncome(17875980));
    die();

    $rows =  \think\facade\Db::name('bet_record')->where('lotteryno', '=', 17875980)->select();
    var_dump($rows);
    //  var_dump( $rows[0]['UserName']);
    foreach ($rows as $row) {
      $betamt = $row['Bet'] / 100;

      var_dump($row['Payout'] / 100);
      var_dump($betamt);
      $payout = $row['Payout'];
      var_dump($row['Payout'] / 100 - $betamt);
      $income = $row['Payout'] / 100 -  $betamt;
      $uid = $row['UserId'];
      $uname = $row['UserName'];
      $txt = "$uname [$uid] 下注金额:$betamt 盈亏: $income \r\n";
      var_dump($txt);
      $a[] = $txt;
    }

    var_dump($a);
  }
}
