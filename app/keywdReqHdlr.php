<?php

namespace app;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use app\model\Setting;
use think\view\driver\Php;

//define('BOT_TOKEN_req', '6426986117:AAFb3woph_1zOWFS5cO98XIFUPcj6GqvmXc');
//define('chat_id_req', '-1001903259578');
//$bot_token = "6426986117:AAFb3woph_1zOWFS5cO98XIFUPcj6GqvmXc";  //sscNohk
//$chat_id = -1001903259578;


//bot_sendMsgTxtMode($text, BOT_TOKEN, chat_id);
//die();

class keywdReqHdlr extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('keywdReqHdlr')->addArgument('argsx', Argument::OPTIONAL, "your argsx")
            ->setDescription('the cmd2 command');
    }

    // todo need log err in log file..
    protected function execute(Input $input, Output $output)
    {
        try{
            \think\facade\Log::info("-------------@@starty...------");
            \think\facade\Log::info("-------------@@starty...------");
            \think\facade\Log::info("-------------@@starty...------");
            $set = Setting::find(1);
    
            $GLOBALS['BOT_TOKEN']= $set->s_value ;
            //  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\modyfing\jbbot\think reqHdlr
            // 指令输出
            $name = trim($input->getArgument('argsx'));
            $output->writeln('cmd reqhdl' . $name);
            $json_t = urldecode($name);
            //  $json=json_decode( $name);
            \think\facade\Log::info("---------------- json_t ---------------------------");
            \think\facade\Log::info(  $json_t );
            var_dump($json_t);
            $json = json_decode($json_t, true);
            var_dump($json);

      //   die();
    
            $hdr =   new  \app\controller\Handle2();
            $hdr->Bot_Token= $GLOBALS['BOT_TOKEN'];

            var_dump($json);
         //   die();
            $ret =   $hdr->processMessage($json);
            $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            var_dump($lineNumStr);
            var_dump($ret);
    
            \think\facade\Log::info($lineNumStr);
            \think\facade\Log::info(json_encode($ret));
    
            //if here null maybe  processMessage  grp id chk fail.
            $urlprm = http_build_query($GLOBALS['bet_ret_prm']);
            $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            \think\facade\Log::info($lineNumStr);
            \think\facade\Log::info(" urlprm:" . $urlprm);
    
            require_once(__DIR__ . "/../lib/tlgrmV2.php");
          
            $r = bot_sendmsg_reply_byQrystr(  $GLOBALS['BOT_TOKEN'], $urlprm);
            \think\facade\Log::info("  " . $r);
            \think\facade\Log::info("-------------finish------");
            //     \think\facade\Log::info(  $ret );
            var_dump("97L");
        }  catch (\Throwable $exception) {
            $lineNumStr = __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            //   \think\facade\Log::info($lineNumStr);
            \think\facade\Log::error("----------------errrrr2---------------------------");
            \think\facade\Log::error("file_linenum:" . $exception->getFile() . ":" . $exception->getLine());
            \think\facade\Log::error("errmsg:" . $exception->getMessage());
            \think\facade\Log::error("errtraceStr:".$exception->getTraceAsString());
            var_dump($exception);

            // throw $exception; // for test
        }
       


        // echo   iconv("gbk","utf-8","php中文待转字符");//把中文gbk编码转为utf8
        //  main_process();



    }
}
