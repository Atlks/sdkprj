<?php

declare(strict_types=1);

namespace app\controller;

use think\Request;
//use app\model\Message;
use app\common\Game;
use app\model\BotWords;
use app\model\Setting;

class ProcessMessage
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public $Bot_Token = "";
    public function index()
    {
        //
        try {
            $update = json_decode(file_get_contents('php://input'), true);

            if (!$update) {
                return false;
            }
            $this->Bot_Token = Setting::find(1)->s_value;

            if (isset($update["message"])) {
                $this->processMessage($update["message"]);
            } elseif (isset($update["callback_query"])) {
                $this->processCallbackQuery($update["callback_query"]);
            }
        } catch (\TelegramBot\Api\InvalidJsonException $e) {
            echo $e->getMessage() . '<br/>';
        } catch (\TelegramBot\Api\HttpException $e) {
            echo $e->getMessage() . '<br/>';
        }
    }


    private function processMessage($message)
    {
        $bot = new \TelegramBot\Api\BotApi($this->Bot_Token);
        // process incoming message
        $message_id = $message['message_id'];
        $chat_id = $message['chat']['id'];
        $user_id = $message['from']['id'];
        $user_name = '';
        if (isset($message['from']['username']))
            $user_name = $message['from']['username'];
        $full_name = '';
        if (isset($message['from']['first_name']))
            $full_name = $message['from']['first_name'];
        if (isset($message['from']['last_name']))
            $full_name = $full_name . $message['from']['last_name'];

        if(isset($message['text']))
        {
            $text = $message['text'];
            if($text === "获取我的群信息")
            {
                $reply_text = "我的群 ".$message['chat']['title'] . " id: ". $chat_id;
                $bot->sendMessage($chat_id, $reply_text);
                return;
            }
        }

        if ($chat_id != Setting::find(2)->value) {
            /*
            $token = Setting::find(11)->s_value;
            $bot = new \TelegramBot\Api\BotApi($token);
            $ci = Setting::find(12)->value;
            $text = "接收到搞事信息\r\n信息id : $chat_id\r\n搞事人:$full_name,$user_name\r\n";
            if (isset($message['chat']['title']))
                $text = $text . "群名 : " . $message['chat']['title'] . "\r\n";
            if (isset($message['text']))
                $text = $text . "内容 : " . $message['text'];
            $bot->leaveChat($chat_id);
            */
            //$bot->sendMessage($ci, $text);
            return;
        }

        $reply_text = "默认信息";
        if (isset($message['text'])) {
            // incoming text message
            $text = $message['text'];
            $game = new Game();

            /*
          $data['text']=$text;
          $data['name']=$full_name;
          $data['chat_id']=$message_id;
          $data['time']=  date('Y-m-d  H:i:s',time());
          \think\facade\Db::connect('test')->table('message')->insert($data);
          */

            if (empty($game->getPlayer($user_id))) {
                $game->createPlayer($user_id, $full_name, $user_name);
            }

            $game->receive($message_id);
            $reply_text =  $game->player_exec($text, Setting::find(3)->value == 1);

            if (!empty($reply_text)) {

                if ($game->sendTrend()) {
                    $cfile = new \CURLFile(app()->getRootPath() . "public/trend.jpg");
                    $bot->sendPhoto($chat_id, $cfile);
                } else {
                    $keyboard = null;
                    if ($game->action()) {
                        $keyboard_array = json_decode(BotWords::where('Id', 1)->find()->Button_Text);
                        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($keyboard_array);
                    }
                    /*
                    $params =
                        [
                            'chat_id' => $chat_id,
                            'text' => $reply_text,
                            //'message_thread_id' => null,
                            'parse_mode' => $game->parse_mode(),
                            'disable_web_page_preview' => true,
                            'reply_to_message_id' => (int)$message_id,
                            'reply_markup' => is_null($keyboard) ? $keyboard : $keyboard->toJson(),
                            'disable_notification' => false,
                        ];
                        */
                    $bot->sendMessage($chat_id, $reply_text, $game->parse_mode(), false, null, $message_id, $keyboard);
                    //$this->apiRequestWebhook("sendMessage", $params);
                }
            }
        }
    }

    private function processCallbackQuery($callback_query)
    {
        $from = $callback_query['from']['id'];
        $func = $callback_query['data'];
        $res = "";
        if (!empty($func)) {
            $res = $this->$func($from);
        }
        if (!empty($res)) {
            $bot = new \TelegramBot\Api\BotApi($this->Bot_Token);
            $bot->answerCallbackQuery($callback_query['id'], $res, true);
        }
    }

    private function query_balance($from)
    {
        $game = new Game($from);
        return $game->callBalance();
    }

    private function query_records($from)
    {
        $game = new Game($from);
        return $game->callLastRecord();
    }

    private function query_rebates($from)
    {
        $game = new Game($from);
        return $game->queryRollover();
    }


    function apiRequestWebhook($method, $parameters)
    {
        if (!is_string($method)) {
            error_log("Method name must be a string\n");
            return false;
        }

        if (!$parameters) {
            $parameters = array();
        } else if (!is_array($parameters)) {
            error_log("Parameters must be an array\n");
            return false;
        }

        $parameters["method"] = $method;

        $payload = json_encode($parameters);
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($payload));
        echo $payload;

        return true;
    }
}
