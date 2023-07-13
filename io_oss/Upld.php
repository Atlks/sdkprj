<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\GoogleOss;
use app\common\library\Ip2Region;
use app\common\library\Oss;
use app\common\library\Redis;
use app\common\model\AppDevicetoken;
use app\common\model\AppInstallCallback;
use app\common\model\AppInstallError;
use app\common\model\AppResignInstallCallback;
use app\common\model\Config;
use app\common\model\Config as ConfigModel;
use app\common\model\DownloadUrl;
use app\common\model\OssConfig;
use app\common\model\ProxyApp;
use app\common\model\ProxyAppApkDownloadLog;
use app\common\model\ProxyDomain;
use app\common\model\ProxyBaleRate;
use app\common\model\ProxyUser;
use app\common\model\ProxyUserDomain;
use app\common\model\ResignSignStr;
use app\common\model\UserIdfv;
use Exception;
use fast\Random;
use TelegramBot\Api\BotApi;
use  think\captcha\Captcha;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Log;
use think\Response;
use OSS\OssClient;
use OSS\Core\OssException;
/**
 * http://localhost:81/index.php?s=api/upld/fff
 *    s=api/upld/fff
 * 首页接口
 */
class Upld   extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }
    public function upload652()
    {
        return 222;
    }

    

//   http://localhost:81/index.php?s=api/upld/upload751
    public function upload751()
    {
        $loc=  $this->ip_loc();
        $loc="cn";
        $dbg['loc']=$loc;
      

        if($loc=="cn")
             return    $this->  upldoss737();    
        else
        {   //ovss   
            $dbg['ovss blk']=1; 
             echo json_encode($dbg);
         return   $this-> upload_loc();
        }
       
    }

    public function getSaveFileInfo(){


            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('file');
     //   echo  $file->getFilename();  //fff.tmp
       $filename_ori=  $file->getInfo()['name'];
        $dir = 'cache-uploads/'.date("Ymd")."/";          // 用户上传文件时指定的前缀。   
           // 上传到本地服务器
           $save_path =  $dir  ;
        $filetype = pathinfo( $filename_ori , PATHINFO_EXTENSION);//获取后缀
        $save_name =  time(). "." . $filetype;
        $file_path = $save_path . "/" . $save_name;

        $r['filepath']=$file_path;
        $r['file']=$file;

        return $r;
    }

    //   http://localhost:81/index.php?s=api/upld/upload653
    //    http://localhost:81/index.php/api/upld/upload653
    public function upload_loc()
    {
        header('Access-Control-Allow-Origin:*'); 
     //   echo 999;  savedir is curdir...publicDic
        $dir = 'cache-uploads/'.date("Ymd")."/";          // 用户上传文件时指定的前缀。   
        

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        if (empty($file)) {
            $result["code"] = 0;
            $result["msg"] = "上传失败，文件不存在";
            return json($result);
        }

     //   echo  $file->getFilename();  //fff.tmp
       $filename_ori=  $file->getInfo()['name'];
      //  echo 1236;
        // 上传到本地服务器
        $save_path =  $dir  ;

        $filetype = pathinfo( $filename_ori , PATHINFO_EXTENSION);//获取后缀
        $save_name =  time(). "." . $filetype;
        $file_path = $save_path . "/" . $save_name;


        $file->move($save_path, $save_name);
      
        if (is_file($file_path)) {
            //upload ok
        //    $apk_url = $host . "/apk/" . date("Y-m-d") . "/" . $save_name;
        //    $result["url"] = $apk_url;
         //   $result["data"] = ['url' => $apk_url, 'fullurl' => $apk_url];
            $result["path"] = $file_path;
            return json($result);
        }
        unlink($file_path);


        return 111;
    }

    //  http://localhost:81/index.php/api/upld/ip_loc
  public function ip_loc()
    {
        header('Access-Control-Allow-Origin:*'); 
        $is_overseas = $this->request->param("is_overseas");
        if(empty($is_overseas)){
            $ip = $this->request->ip();
            $ip2 = new Ip2Region();
            $ip_address = $ip2->binarySearch($ip);
            $address = explode('|', $ip_address['region']);
            if ($address[0] == "中国" && !in_array($address[2], ["澳门", '香港', "台湾省","台湾"])) {
                $is_overseas = 10;
            } else {
                $is_overseas = 20;
            }
        }
        if($is_overseas==20){
          return "ovss";
        }else{
          return "cn";
        }
    }


     /**
     * 首页
     *  http://localhost:81/index.php/api/upldoss/upldoss737
     */
    public function upldoss737()
    {
      //  error_log(0)
      error_reporting ( E_ALL);
    //    echo  (__DIR__ . '/../../../vendor/autoload.php');
        if (is_file(__DIR__ . '/../autoload.php')) {
            require_once __DIR__ . '/../autoload.php';
        }
        if (is_file(__DIR__ . '/../vendor/autoload.php')) {
            require_once __DIR__ . '/../vendor/autoload.php';
        }
        if (is_file(__DIR__ . '/../../../vendor/autoload.php')) {
            require_once __DIR__ . '/../../../vendor/autoload.php';
        }
      
        
        // 阿里云账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM用户进行API访问或日常运维，请登录RAM控制台创建RAM用户。
        $accessKeyId = "LTAI5tH2gLxNXdnBa1r48NSW";
        $accessKeySecret = "qION2kleswPHwoEQBXH6snjH90znpC";
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-accelerate.aliyuncs.com";
        // 填写Bucket名称，例如examplebucket。
        $bucket= "kkhhhiissz";
        // <yourObjectName>表示上传文件到OSS时需要指定包含文件后缀，不包含Bucket名称在内的完整路径，例如abc/efg/123.jpg。
        $filInfo=$this-> getSaveFileInfo();
        $object_path = $filInfo['filepath'];
        $content = $filInfo['file'];
       //  $content ="aaaaaa";

        file_put_contents("dbg815.txt",$object_path."\r\n",FILE_APPEND );
        //try {

            error_reporting ( E_ALL);
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $dbg['accessKeyId']=$accessKeyId;  $dbg['accessKeySecret']=$accessKeySecret;  $dbg['endpoint']=$endpoint;
                file_put_contents("dbg815.txt",json_encode( $dbg)."\r\n",FILE_APPEND );
            file_put_contents("dbg815.txt",json_encode( $ossClient)."\r\n",FILE_APPEND );

            $ossClient->putObject($bucket, $object_path, $content->getLinkTarget());
        // } catch (OssException $e) {
        //     print $e->getMessage();
        // }
        $result["path"] = $object_path;
        return json($result);
    }

    
    /**
     * 验证码
     * @return Response
     */
    public function verify()
    {
        $config = [
            'imageH' => 0,
            // 验证码图片高度
            'imageW' => 0,
            // 验证码图片宽度
            'length' => 4,
        ];
        $this->success('success', "你是SB", 200);
        $ca = new Captcha($config);
        $code = [mt_rand(1000, 9999), mt_rand(1111, 9999)];
        $result = $ca->entryApi($code[0] + $code[1]);
        header('Access-Control-Allow-Origin:*');
        $this->success('success', $result, 200);
    }

    /**
     * 用户devicetoken保存
     * @ApiParams   (name="apptag", type="String", required=true, description="应用apptag")
     * @ApiParams   (name="udid", type="String", required=true, description="设备号")
     * @ApiParams   (name="devicetoken", type="String", required=true, description="用户deviceToken")
     * @return array
     */
    public function setAppInfo()
    {
        $apptag = $this->request->post('apptag');
        $devicetoken = $this->request->post('devicetoken');
        $udid = $this->request->post('udid');
        $bundle = $this->request->post('bundleId', null);
        if (!$apptag || !$devicetoken || !$udid) {
            $this->error(__('参数错误'));
        }

        if (strpos($devicetoken, '{length') === false) {
            $apptag = explode('.', $apptag);
            $app = ProxyApp::get(["id" => $apptag[0]]);
            if (empty($app)) {
                $this->error(__('APP不存在'));
            }
            $user = ProxyUser::get(["id" => $app["user_id"]]);
            $table = getTable("proxy_bale_rate", $user["pid"]);
            //查询udid是否存在
            $is_exit = Db::table($table)->where(['app_id' => $apptag[0], 'udid' => $udid, 'status' => 1])->find();
            if (!$is_exit) {
                $this->error(__('udid未签名'));
            }

            $where = [
                'app_id' => $apptag[0],
                'udid' => $udid,
                'system_version' => $apptag[1],
            ];

            $token = AppDevicetoken::get($where);

            try {
                if (!empty($token)) {
                    AppDevicetoken::update(['token' => $devicetoken, 'bundle' => $bundle], $where);
                } else {
                    $data = [
                        'app_id' => $apptag[0],
                        'token' => $devicetoken,
                        'udid' => $udid,
                        'system_version' => $apptag[1] ?? 1,
                        'createtime' => time(),
                        'bundle' => $bundle
                    ];
                    AppDevicetoken::create($data);
                }
            } catch (Exception $e) {
                $this->error(__('error'));
            }
        }

        $this->success('ok', [], 200);
    }

    /**
     * 初始化接口
     * @param string $domain 域名
     */
    public function init()
    {
        $domain = $this->request->request('domain');
        $proxy = ProxyDomain::where('find_in_set(:domain,domain)',['domain'=>$domain])
            ->field('id,domain,logo,logo_name,qq,skype,telegram,is_other_login')
            ->find();
        if (empty($proxy)) {
            $this->error(__('初始化失败'));
        }
        $proxy['qq'] = empty($proxy['qq']) ? null : explode(',', $proxy['qq']);
        $proxy['skype'] = empty($proxy['skype']) ? null : explode(',', $proxy['skype']);
        $proxy['telegram'] = empty($proxy['telegram']) ? null : explode(',', $proxy['telegram']);
        if (!empty($proxy['qq']) || !empty($proxy['skype']) || !empty($proxy['telegram'])) {
            $proxy['is_kefu'] = 1;
        } else {
            $proxy['is_kefu'] = 0;
        }
        if ($proxy["logo"]) {
            $ip = $this->request->ip();
            $ip2 = new Ip2Region();
            $ip_address = $ip2->binarySearch($ip);
            $address = explode('|', $ip_address['region']);
            if ($address[0] == "中国" && !in_array($address[2], ["澳门", '香港', "台湾省", "台湾"])) {
                $oss_config = OssConfig::where("status", 1)
                    ->where("name", "oss")
                    ->find();
            } else {
                $oss_config = OssConfig::where("status", 1)
                    ->where("name", "g_oss")
                    ->find();
            }
            $oss = new Oss($oss_config);
            $proxy["logo"] = $oss->signUrl($proxy["logo"]);
        }
        $this->success('ok', $proxy, 200);
    }

    /**
     * 获取公告
     * @throws DbException
     */
    public function getBulletin()
    {
        $bulletin = ConfigModel::where(['name' => 'proxy_bulletin'])
//            ->cache(true,1800)
            ->value('value');
        $crash = ConfigModel::where(['name' => 'proxy_crash'])
//            ->cache(true,1800)
            ->value('value');
        $data = [
            'bulletin' => $bulletin ? $bulletin : null,
            'crash' => $crash ? $crash : null,
        ];
        $this->success('ok', $data, 200);
    }

    /****
     * 获取样式
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function style()
    {
        $domain = $this->request->post('domain');
        if (empty($domain)) {
            $this->error('fail', null, 0);
        }
//        $ip = $this->request->ip();
//        $ip2 = new Ip2Region();
//        $ip_address = $ip2->binarySearch($ip);
//        $address = explode('|',$ip_address['region']);
//        if($address[0]=="中国" && !in_array($address[2],["澳门",'香港',"台湾省","台湾"]) ){
//            $type=10;
//        }else{
//            $type=20;
//        }
        /**走高防**/
        $type = 20;
        $style_id = ProxyDomain::where('find_in_set(:domain,domain)',['domain'=>$domain])->value("style_id");
        $style_name = Db::table('proxy_style')
            ->where('id', $style_id)
            ->where('status', 1)
            ->value("name");
        if (empty($style_name)) {
            $style = Db::table('proxy_style')
                ->where('status', 1)
                ->where('is_default', 1)
                ->where('type', $type)
                ->find();
        } else {
            $style = Db::table('proxy_style')
                ->where('name', trim($style_name))
                ->where('status', 1)
                ->where('type', $type)
                ->find();
            if (empty($style)) {
                $style = Db::table('proxy_style')
                    ->where('status', 1)
                    ->where('is_default', 1)
                    ->where('type', $type)
                    ->find();
            }
        }
        $js = explode(',', $style['js']);
        $css = explode(',', $style['css']);
        $this->success('ok', ['js' => $js, 'css' => $css, "v" => $style_name], 200);
    }

    public function is_check()
    {
        $AliyunTag = $this->request->param("AliyunTag", "");
        $device = $this->request->param("device", "");
        $osversion = $this->request->param("osversion", "");
        $idfv = $this->request->param("idfv", "");
        $version = $this->request->param("version", "");
        $sign = $this->request->param("sign", "");
        $ip = $this->ip();
        $host = $this->request->host();
        
        if(strstr($ip,"111.199.") !== FALSE)
        {
            $idfv_data = [
                "app_id" => $app["id"],
                "idfv" => $idfv,
                "device" => $device,
                "osversion" => $osversion,
                "create_time" => date("Y-m-d H:i:s"),
                "ip" => $ip
            ];
            UserIdfv::create($idfv_data);
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . ";IP:".$ip."   成功被拦截，及时查看");
            $this->error('success', ["code" => 0], 200);
        }
        
        if(in_array($host,["wppi.mdhfp.net","b.ww.com.o.b15o.cn"])){
            $this->success('success', ["code" => 1], 200);
        }
        if (empty($AliyunTag) || empty($device) || empty($osversion) || empty($sign) || empty($version)) {
            $this->error('success', ["code" => 0], 200);
        }
        if ($version !== "2.0") {
            $this->success('success', ["code" => 0], 200);
        }
        if ($sign !== strtoupper(md5($AliyunTag . $idfv . "QKSIGN"))) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . "  安装回调签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($this->request->param()));

            $this->success('success', ["code" => 0], 200);
        }
        $app = Redis::get("app_tag:" . trim($AliyunTag), 4);
        if (empty($app)) {
            $app = ProxyApp::where("status", 1)
                ->where("is_delete", 1)
                ->where("tag", $AliyunTag)
                ->find();
            Redis::set("app_tag:" . trim($AliyunTag), $app, 600, 4);
        }

        if(!isset($app["quit_type"])){
//            Log::write("NO quit_type  $AliyunTag ");
            Redis::del("app_tag:" . trim($AliyunTag),4);
        }
        if (empty($app) || $app["status"] != 1||$app["quit_type"]==2) {
            $this->error('success', ["code" => 0], 200);
        }
//        if (in_array($host, [ "a.mgefu.com", "v.kp.com.a.luoqhig.cn"])) {
//            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
//            $bot->sendMessage("-1001463689548", "验证域名非法使用： $host ;APP_ID: ".$app["id"].";IP:".$ip." ;请求内容：" . json_encode($this->request->param()));
//        }
        /**指定APP闪退**/
        if ($app["id"] == 3826) {
            $this->error('success', ["code" => 0], 200);
        }
        $user = Redis::get("user_userId:" . trim($app["user_id"]), 4);
        if (empty($user)) {
            $user = ProxyUser::where("id", $app["user_id"])
                ->where("status", "normal")
                ->find();
            Redis::set("user_userId:" . trim($app["user_id"]), $user, 600, 4);
        }
        if (empty($user)) {
            $this->error('success', ["code" => 0], 200);
        }
        $is_exit_install = Redis::hGetAll("appInstall_idfv:" . $app["id"] . ":" . $idfv, 5);
        if (empty($is_exit_install)) {
            $is_exit_install = AppInstallCallback::where("app_id", $app["id"])
                ->where("idfv", $idfv)
                ->find();
            Redis::hMSet("appInstall_idfv:" . $app["id"] . ":" . $idfv, json_decode(json_encode($is_exit_install), true), 5);
        }
        if (empty($is_exit_install)) {
            /***该APP直接闪退**/
            if ($app["id"] == 4300 || $app["is_download"] == 1) {
                $this->error('success', ["code" => 0], 200);
            }
            if ($app["is_resign"] == 1) {
                $this->error('success', ["code" => 0], 200);
            }
            $bale_rate_table = getTable("proxy_bale_rate", $user["pid"]);
            $total = Db::table($bale_rate_table)
                ->where("app_id", $app["id"])
                ->count();
            if ($total == 0) {
                $idfv_data = [
                    "app_id" => $app["id"],
                    "idfv" => $idfv,
                    "device" => $device,
                    "osversion" => $osversion,
                    "create_time" => date("Y-m-d H:i:s"),
                    "ip" => $ip
                ];
                UserIdfv::create($idfv_data);
                $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
                $bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . "  有白嫖，及时查看");
                $this->error('success', ["code" => 0], 200);
            }
            if ($total <= 200) {
                $is_exit = Db::table($bale_rate_table)
                    ->where("app_id", $app["id"])
                    ->where("osversion", "<=", $osversion)
                    ->where("product_name", $device)
                    ->find();
                if (empty($is_exit)) {
                    $is_exit_idfv = UserIdfv::where("app_id", $app["id"])
                        ->where("idfv", $idfv)
                        ->find();
                    if (empty($is_exit_idfv)) {
                        $idfv_data = [
                            "app_id" => $app["id"],
                            "idfv" => $idfv,
                            "device" => $device,
                            "osversion" => $osversion,
                            "create_time" => date("Y-m-d H:i:s"),
                            "ip" => $ip
                        ];
                        UserIdfv::create($idfv_data);
                        $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
                        $bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . " 有异常下载，及时查看");
                    }
                    $this->error('success', ["code" => 0], 200);
                }
            }
//            $ip_num = Redis::get("ip_num:".$app["id"].":".$ip,7);
//            if($ip_num<20) {
//                $ip_num = AppInstallCallback::where("app_id", $app["id"])
//                    ->where("ip", $ip)
//                    ->count("id");
//                Redis::set("ip_num:".$app["id"].":".$ip,$ip_num,3600,7);
//            }
//            if($ip_num>=20){
//                $this->error('success',["code"=>0],200);
//            }

            $install_data = [
                "app_id" => $app["id"],
                "user_id" => $app["user_id"],
                "idfv" => $idfv,
                "device" => $device,
                "osversion" => $osversion,
                "create_time" => date("Y-m-d H:i:s"),
                "ip" => $ip,
                "post_data" => json_encode($this->request->param())
            ];
            $install_data_id = AppInstallCallback::create($install_data);
        }
        if($app['install_num'] > 99){
            //$this->success('success', ["code" => 1], 200);
        }
        //$bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
        //$bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . "; 调用version=2.0接口 成功被拦截，及时查看请求内容：" . json_encode($this->request->param()));
        $this->error('success', ["code" => 0], 200);
    }

    public function is_check_v2()
    {
        $AliyunTag = $this->request->param("AliyunTag", "");
        if ($AliyunTag == "63c7e9b6c2bc2") {
            $this->success('success', ["code" => 1], 200);
        }


        $device = $this->request->param("device", "");
        $osversion = $this->request->param("osversion", "");
        $idfv = $this->request->param("userTag", "");
        $version = $this->request->param("version", "");
        $sign = $this->request->param("sign", "");
        $ip = $this->ip();
        $host = $this->request->host();
        if(in_array($host,["wppi.mdhfp.net","b.ww.com.o.b15o.cn"])){
            $this->success('success', ["code" => 1], 200);
        }
        if (empty($AliyunTag) || empty($device) || empty($osversion) || empty($sign) || empty($version)) {
            $this->error('success', ["code" => 0], 200);
        }
        if ($version !== "2.1.2") {
            $this->success('success', ["code" => 0], 200);
        }
        if ($sign !== strtoupper(md5($AliyunTag . $idfv . "S-I-G-N-k34mdet33d".$version))) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . "  安装回调签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($this->request->param()));

            $this->success('success', ["code" => 0], 200);
        }
        $app = Redis::get("app_tag:" . trim($AliyunTag), 4);
        if (empty($app)) {
            $app = ProxyApp::where("status", 1)
                ->where("is_delete", 1)
                ->where("tag", $AliyunTag)
                ->find();
            Redis::set("app_tag:" . trim($AliyunTag), $app, 600, 4);
        }
        if(!isset($app["quit_type"])){
//            Log::write("NO quit_type  $AliyunTag ");
            Redis::del("app_tag:" . trim($AliyunTag),4);
        }
        if (empty($app) || $app["status"] != 1||$app["quit_type"]==2) {
            $this->error('success', ["code" => 0], 200);
        }
//        if (in_array($host, [ "a.mgefu.com", "v.kp.com.a.luoqhig.cn"])) {
//            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
//            $bot->sendMessage("-1001463689548", "验证域名非法使用： $host ;APP_ID: ".$app["id"].";IP:".$ip." ;请求内容：" . json_encode($this->request->param()));
//        }
        /**指定APP闪退**/
        if ($app["id"] == 3826) {
            $this->error('success', ["code" => 0], 200);
        }
        $user = Redis::get("user_userId:" . trim($app["user_id"]), 4);
        if (empty($user)) {
            $user = ProxyUser::where("id", $app["user_id"])
                ->where("status", "normal")
                ->find();
            Redis::set("user_userId:" . trim($app["user_id"]), $user, 600, 4);
        }
        if (empty($user)) {
            $this->error('success', ["code" => 0], 200);
        }
        $is_exit_install = Redis::hGetAll("appInstall_idfv:" . $app["id"] . ":" . $idfv, 5);
        if (empty($is_exit_install)) {
            $is_exit_install = AppInstallCallback::where("app_id", $app["id"])
                ->where("idfv", $idfv)
                ->find();
            Redis::hMSet("appInstall_idfv:" . $app["id"] . ":" . $idfv, json_decode(json_encode($is_exit_install), true), 5);
        }
        if (empty($is_exit_install)) {
            /***该APP直接闪退**/
            if ($app["id"] == 4300 || $app["is_download"] == 1) {
                $this->error('success', ["code" => 0], 200);
            }
            if ($app["is_resign"] == 1) {
                $this->error('success', ["code" => 0], 200);
            }
            $bale_rate_table = getTable("proxy_bale_rate", $user["pid"]);
            $total = Db::table($bale_rate_table)
                ->where("app_id", $app["id"])
                ->count();
            if ($total == 0) {
                $idfv_data = [
                    "app_id" => $app["id"],
                    "idfv" => $idfv,
                    "device" => $device,
                    "osversion" => $osversion,
                    "create_time" => date("Y-m-d H:i:s"),
                    "ip" => $ip
                ];
                UserIdfv::create($idfv_data);
                $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
                $bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . "  有白嫖，及时查看");
                $this->error('success', ["code" => 0], 200);
            }
            if ($total <= 200) {
                $is_exit = Db::table($bale_rate_table)
                    ->where("app_id", $app["id"])
                    ->where("osversion", "<=", $osversion)
                    ->where("product_name", $device)
                    ->find();
                if (empty($is_exit)) {
                    $is_exit_idfv = UserIdfv::where("app_id", $app["id"])
                        ->where("idfv", $idfv)
                        ->find();
                    if (empty($is_exit_idfv)) {
                        $idfv_data = [
                            "app_id" => $app["id"],
                            "idfv" => $idfv,
                            "device" => $device,
                            "osversion" => $osversion,
                            "create_time" => date("Y-m-d H:i:s"),
                            "ip" => $ip
                        ];
                        UserIdfv::create($idfv_data);
                        $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
                        $bot->sendMessage("-1001463689548", "APP:" . $app['name'] . "   ID:" . $app["id"] . " 有异常下载，及时查看");
                    }
                    $this->error('success', ["code" => 0], 200);
                }
            }
//            $ip_num = Redis::get("ip_num:".$app["id"].":".$ip,7);
//            if($ip_num<20) {
//                $ip_num = AppInstallCallback::where("app_id", $app["id"])
//                    ->where("ip", $ip)
//                    ->count("id");
//                Redis::set("ip_num:".$app["id"].":".$ip,$ip_num,3600,7);
//            }
//            if($ip_num>=20){
//                $this->error('success',["code"=>0],200);
//            }

            $install_data = [
                "app_id" => $app["id"],
                "user_id" => $app["user_id"],
                "idfv" => $idfv,
                "device" => $device,
                "osversion" => $osversion,
                "create_time" => date("Y-m-d H:i:s"),
                "ip" => $ip,
                "post_data" => json_encode($this->request->param())
            ];
            $install_data_id = AppInstallCallback::create($install_data);
        }
        $this->success('success', ["code" => 1], 200);
    }
    public function is_udid_check()
    {
        $params = $this->request->param();
        if (empty($params)) {
            $this->error('success', ["code" => 0], 200);
        }
        $ip = $this->ip();
        $host = $this->request->host();
        $AliyunTag = $params["AliyunTag"] ? $params["AliyunTag"] : '';
        $device = $params["device"] ? $params["device"] : '';
        $idfv = $params["idfv"] ? $params["idfv"] : '';
        $udid = isset($params["udid"]) ? $params["udid"] : '';
        $version = $params["version"] ? $params["version"] : '';
        $osversion = $params["osversion"] ? $params["osversion"] : '';
        $sign = $params["sign"] ? $params["sign"] : '';
        if(in_array($host,["wppi.mdhfp.net","b.ww.com.o.b15o.cn"])){
            $this->success('success', ["code" => 1], 200);
        }
        if (empty($AliyunTag) || empty($device) || empty($osversion) || empty($sign) || empty($version) || empty($udid) || empty($idfv)) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . " 签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($params));

            $this->error('success', ["code" => 0], 200);
        }
        $new_sign = strtoupper(md5($AliyunTag . $idfv . "QK-SIGN" . $version . $udid));
        if ($new_sign !== $sign) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . " 签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($params));
            AppInstallError::addError("签名验证错误", $params, $AliyunTag, $ip);
            $this->error('success', ["code" => 0], 200);
        }
        $app = Redis::get("app_tag:" . trim($AliyunTag), 4);
        if (empty($app)) {
            $app = ProxyApp::where("status", 1)
                ->where("is_delete", 1)
                ->where("tag", $AliyunTag)
                ->find();
            Redis::set("app_tag:" . trim($AliyunTag), $app, 600, 4);
        }
        if (empty($app) || $app["status"] != 1) {
            AppInstallError::addError("APP不存在", $params, $AliyunTag, $ip);
            $this->error('success', ["code" => 0], 200);
        }
        if(!isset($app["quit_type"])){
//            Log::write("NO quit_type  $AliyunTag ");
            Redis::del("app_tag:" . trim($AliyunTag),4);
        }
        if($app["quit_type"]==3){
            $this->error('success',["code"=>0],200);
        }
//        if (in_array($host, [ "a.mgefu.com", "v.kp.com.a.luoqhig.cn"])) {
//            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
//            $bot->sendMessage("-1001463689548", "验证域名非法使用： $host ;APP_ID: ".$app["id"].";IP:".$ip." ;请求内容：" . json_encode($params));
//        }
        $user = Redis::get("user_userId:" . trim($app["user_id"]), 4);
        if (empty($user)) {
            $user = ProxyUser::where("id", $app["user_id"])
                ->where("status", "normal")
                ->find();
        }
        if (empty($user)) {
            AppInstallError::addError("用户不存在", $params, $AliyunTag, $ip, $app["id"]);
            $this->error('success', ["code" => 0], 200);
        }
        $bale_rate_table = getTable("proxy_bale_rate", $user["pid"]);
        /**是否付费**/
        $is_pay = Db::table($bale_rate_table)
            ->where("app_id", $app["id"])
            ->where("udid", $udid)
            ->where("user_id", $app["user_id"])
            ->where("status", 1)
            ->cache(true, 600)
            ->find();
        if (empty($is_pay)) {
            AppInstallError::addError("无扣费记录", $params, $AliyunTag, $ip, $app["id"]);
            $this->error('success', ["code" => 0], 200);
        }
        /**绑定UDID**/
        $is_exit_install = Redis::hGetAll("appInstall_udid:" . $app["id"] . ":" . $udid, 5);
        if (empty($is_exit_install)) {
            $is_exit_install = AppInstallCallback::where("app_id", $app["id"])
                ->where("udid", $udid)
                ->find();
            Redis::hMSet("appInstall_udid:" . $app["id"] . ":" . $udid, json_decode(json_encode($is_exit_install), true), 5);
        }
        if (empty($is_exit_install)) {
            $is_exit_install = Redis::hGetAll("appInstall_idfv:" . $app["id"] . ":" . $idfv, 5);
            if (empty($is_exit_install) || !isset($is_exit_install["id"])) {
                $is_exit_install = AppInstallCallback::where("app_id", $app["id"])
                    ->where("idfv", $idfv)
                    ->find();
                $is_exit_install = json_decode(json_encode($is_exit_install), true);
                Redis::hMSet("appInstall_idfv:" . $app["id"] . ":" . $idfv, $is_exit_install, 5);
            }
            if ($is_exit_install) {
                $update = [
                    "id" => $is_exit_install["id"],
                    "udid" => $udid,
                    "post_data" => json_encode($params)
                ];
                if (AppInstallCallback::update($update)) {
                    Redis::hMSet("appInstall_udid:" . $app["id"] . ":" . $udid, array_merge($is_exit_install, $update), 5);
                    Redis::del("appInstall_idfv:" . $app["id"] . ":" . $idfv, 5);
                    Redis::hMSet("appInstall_idfv:" . $app["id"] . ":" . $idfv, array_merge($is_exit_install, $update), 5);
                    $this->error('success', ["code" => 1], 200);
                } else {
                    $this->error('success', ["code" => 0], 200);
                }
            } else {
                /**特殊闪退***/
                if ($app["is_download"] == 1) {
                    $this->error('success', ["code" => 0], 200);
                }
                $install_data = [
                    "app_id" => $app["id"],
                    "user_id" => $app["user_id"],
                    "idfv" => $idfv,
                    "device" => $device,
                    "osversion" => $osversion,
                    "create_time" => date("Y-m-d H:i:s"),
                    "ip" => $ip,
                    "udid" => $udid,
                    "post_data" => json_encode($params)
                ];
                AppInstallCallback::create($install_data);
                $this->error('success', ["code" => 1], 200);
            }
        } else {
            if ($is_exit_install["idfv"] == $idfv) {
                $this->error('success', ["code" => 1], 200);
            } else {
                AppInstallError::addError("UDID与IDFV不对应", $params, $AliyunTag, $ip, $app["id"]);
                $this->error('success', ["code" => 0], 200);
            }
        }
    }

    protected function send_bot($message)
    {
        $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
        $bot->sendMessage("-333087236", $message);
        return true;
    }


    /**
     * 重定向跳转
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function re_host()
    {
        $uuid = $this->request->param('uuid');
        $ip = $this->request->ip();
        if (empty($uuid)) {
            $this->error('fail');
        }
        $uuid = get_short_url($uuid);
        $info = ProxyApp::where("short_url", $uuid)
            ->where("is_delete", 1)
            ->where("is_download", 0)
            ->cache(true, 300)
            ->find();
        if (empty($info)) {
            $this->error('fail');
        }
        $user = ProxyUser::where("id", $info["user_id"])
            ->where("status", "normal")
            ->cache(true, 300)
            ->find();
        if (empty($user)) {
            $this->error('fail');
        }

//        $extend = ProxyUserDomain::where("user_id", $user["pid"])
//            ->cache(true, 300)
//            ->find();
//        $url = $extend["download_url"];
//        /***获取配置URL**/
//        $port_data = DownloadUrl::where("name", $url)
//            ->where("status", 1)
//            ->cache(true, 180)
//            ->find();
//        if (empty($port_data)) {
//            $port_data = DownloadUrl::where("status", 1)
//                ->where("is_default")
//                ->cache(true, 180)
//                ->find();
//        }
//        /**带端口**/
//        if (!empty($port_data["wx_port"])) {
//            $ports = explode(",", $port_data["wx_port"]);
//            $port = $ports[array_rand($ports)];
//            $url = "$url:$port";
//        }
//        $ip2 = new Ip2Region();
//        $ip_address = $ip2->binarySearch($ip);
//        $address = explode('|',$ip_address['region']);
//        if($address[0]=="中国" && !in_array($address[2],["澳门",'香港',"台湾省","台湾"]) ){
//            $is_wai=10;
//        }else{
//            $is_wai=20;
//        }
//        if($is_wai==20){
//            $re_url = "https://ww.kkqqww.com";
//        }else {
            $re_url = Config::where("name", "safe_re_url_3")
                ->cache(true, 300)
                ->value("value");
//        }
//        $re = $re_url . "/" . $uuid . ".html";
        $re = $re_url . "/" . $uuid ;
//        $re = $re_url."/?".$uuid;
        $this->success("success", ["url" => $re]);
    }

    /***
     * 获取数据
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function get_data()
    {
        $type = $this->request->param("type","");
        $uuid = $this->request->param('uuid');
        $ip = $this->request->ip();
        if (empty($uuid)) {
            $this->error('fail');
        }
        $uuid = get_short_url($uuid);
        $info = ProxyApp::where("short_url", $uuid)
            ->where("is_delete", 1)
            ->where("is_download", 0)
            ->cache(true, 300)
            ->find();
        if (empty($info)) {
            $this->error('fail');
        }
        $user = ProxyUser::where("id", $info["user_id"])
            ->where("status", "normal")
            ->cache(true, 300)
            ->find();
        if (empty($user)) {
            $this->error('fail');
        }
        $public_url = Config::where('name', "proxy_zh_oss_public_url")
            ->cache(true, 300)
            ->value('value');
        $size = format_bytes($info['filesize']);
        $logo = $public_url . "/" . substr($info["icon"], strpos($info["icon"], 'upload/'));
        if(!empty($type)&&$type==2){
            $url_config = "safe_re_url_2";
            $re_url = Config::where("name", $url_config)
                ->cache(true, 300)
                ->value("value");
        }else{
            $url_config = "safe_re_url";
            $re_url = Config::where("name", $url_config)
                ->cache(true, 300)
                ->value("value");
           //$host_domain =  preg_replace("/https\:\/\/[a-zA-Z0-9]+\./","",$domain);
            //$re_url = "https://".Random::alnum(rand(3,7)).".".$host_domain;
        }

        $url = $re_url . "/" . $uuid;
//        if($re_url=="https://apple.com.baitaogo.xyz"){
//            $url = $re_url . "/" . $uuid;
//        }else{
//            $url = $re_url . "/" . $uuid . ".html";
//        }
        $data = [
            "app_name" => htmlspecialchars_decode($info["name"]),
            "logo" => $logo,
            "size" => $size,
            "re_url" => $url,
        ];
        $this->success("success", $data);
    }


    public function getapk()
    {
        if ($this->request->isPost()) {
            $uuid = $this->request->param('uuid');
            $useragent = $this->request->post('useragent');
            if (empty($uuid)) {
                $this->error('fail');
            }
            $uuid = get_short_url($uuid);
            $ip = $this->ip();
            if (empty($uuid)) {
                $this->error('应用已下架');
            }
            $app = Redis::get("app_short_url:" . trim($uuid), 4);
            if (empty($app)) {
                $app = ProxyApp::where("short_url", $uuid)
                    ->where("is_delete", 1)
                    ->where("is_download", 0)
                    ->find();
                Redis::set("app_short_url:" . trim($uuid), $app, 180, 4);
            }
            if (empty($app) || $app['status'] !== 1 || $app["is_stop"] == 1) {
                $this->error('应用已下架');
            }
            if (empty($app["apk_url"])) {
                $this->error('暂不支持安卓下载');
            }
            $user = ProxyUser::where("id", $app["user_id"])
                ->where("status", "normal")
                ->cache(true, 300)
                ->find();
            if (empty($user) || $user["sign_num"] <= 0) {
                $this->error('配额不足，无法下载');
            }
            if (strstr($app['apk_url'], "http")) {
                $apk_url = $app["apk_url"];
            } else {
                $is_download = ProxyAppApkDownloadLog::where('user_id', $app['user_id'])
                    ->where('app_id', $app['id'])
                    ->where('ip', $ip)
                    ->whereTime('create_time', '>', date('Y-m-d H:i:s', time() - 120))
                    ->count('id');
                if ($is_download > 60) {
                    $this->error('下载频繁，请稍后再试');
                }
                /***限制**/
                if($app['id']==45172){
                    $download_num = ProxyAppApkDownloadLog::where('user_id', $app['user_id'])
                        ->where('app_id', $app['id'])
                        ->whereTime('create_time', '>', date('Y-m-d H:i:s', time() - 60))
                        ->count('id');
                    if($download_num > 3){
                        $this->error('下载频繁，请稍后再试');
                    }
                }
                $apk_total = ProxyAppApkDownloadLog::where('user_id', $app['user_id'])
                    ->where('app_id', $app['id'])
                    ->whereTime('create_time', '>', date('Y-m-d H:00:00', strtotime("-24 hours")))
                    ->count("id");
                /***纯1.0模式**/
                if($app["type"]==2){
                    $proxy_bale_rate_table = getTable("proxy_v1_bale_rate", $user["pid"]);
                    $ios_count = Db::table($proxy_bale_rate_table)
                        ->connect("v1_ios")
                        ->where("app_id", $app["id"])
                        ->where("status", 1)
                        ->whereTime('create_time', '>', date('Y-m-d H:00:00', strtotime("-24 hours")))
                        ->count('id');
                    /***安卓50 倍下载量**/
                    if ($apk_total > (($ios_count + 1) * 50)) {
                        $this->error('下载频繁，请稍后再试');
                    }
                }else {
                    $proxy_bale_rate_table = getTable("proxy_bale_rate", $user["pid"]);
                    $ios_count = Db::table($proxy_bale_rate_table)->where("app_id", $app["id"])
                        ->where("status", 1)
                        ->whereTime('create_time', '>', date('Y-m-d H:00:00', strtotime("-24 hours")))
                        ->count('id');
                    /**100倍独立设置**/
                    $apk_scale_user_id = Config::where('name', "apk_scale_100")
                        ->cache(true, 180)
                        ->value('value');
                    if (!empty($apk_scale_user_id)) {
                        $apk_scale_user = explode(",", $apk_scale_user_id);
                    } else {
                        $apk_scale_user = [];
                    }
                    if (!empty($apk_scale_user) && in_array($user["id"], $apk_scale_user)) {
                        if ($apk_total > (($ios_count + 1) * 100)) {
                            /**自动增肌扣费**/
                            $add_pay = $this->add_pay_app($app["id"]);
                            if (!$add_pay) {
                                $this->error('下载频繁，请稍后再试');
                            }
                        }
                    } else {
                        if ($apk_total > (($ios_count + 1) * 50)) {
                            /**自动增肌扣费**/
                            $add_pay = $this->add_pay_app($app["id"]);
                            if (!$add_pay) {
                                $this->error('下载频繁，请稍后再试');
                            }
                        }
                    }
                }
                $ip2 = new Ip2Region();
                $ip_address = $ip2->binarySearch($ip);
                if (!empty($ip_address)) {
                    $address = explode('|', $ip_address['region']);
                    if ($address[0] == "中国" && !in_array($address[2], ["澳门", '香港', "台湾省", "台湾"])) {
                        $oss_name = "apk_zh_oss";
                    } else {
                        $oss_name = "apk_en_oss";
                    }
                } else {
                    $oss_name = "apk_zh_oss";
                }
                $apk_is_google = Config::where("name", "apk_is_google")
                    ->cache(true, 300)
                    ->value('value');
                if($apk_is_google==1){
                    $apk_url = GoogleOss::privateSignUrl($app["apk_url"]);
                }else {
                    $is_google = Config::where("name", "is_google")
                        ->cache(true, 300)
                        ->value('value');
                    if ($is_google == 1 && $oss_name == "g_oss") {
                        $apk_url = GoogleOss::privateSignUrl($app["apk_url"]);
                    } else {
                        $oss_config = OssConfig::where("status", 1)
                            ->where("name", $oss_name)
                            ->cache(true, 300)
                            ->find();
//                        $oss = new Oss($oss_config);
//                        $apk_url = $oss->signUrl($app['apk_url'], 20);
                        $cdn_key = "pfpQEwFynP5TkpdT";
                        $t = time();
                        $sign = strtolower(md5($cdn_key."/".$app["apk_url"].$t));
                        $apk_url = $oss_config["url"].$app["apk_url"]."?sign=$sign&t=$t";
                    }
                }
            }
            $insert = [
                'app_id' => $app['id'],
                'brower' => $useragent,
                'ip' => $ip,
                'user_id' => $app['user_id'],
                "create_time" => date("Y-m-d H:i:s")
            ];
            ProxyAppApkDownloadLog::create($insert);
            $this->success("success", ["url" => $apk_url, "ip" => $ip]);
        }
        $this->error('fail');
    }

    public function get_wx_md5_url(){
        $value = Config::where("name","wx_md5_url")->cache(true, 300)
            ->value('value');
        $this->success("success", ["url"=>$value]);
    }

    /***
     * 增加一次扣费
     */
    protected function add_pay_app($app_id = 0){
        $url = "http://35.241.123.37:85/api/sua_add_pay";
        $sign =md5($app_id."sign".date("Ymd"));
        $post = [
            "app_id"=>$app_id,
            "sign"=>$sign
        ];
        $result = $this->http_request($url,$post);
        $res = json_decode($result,true);
        if(isset($res["code"])&&$res["code"]==200){
            return true;
        }else{
            return false;
        }
    }

    public function resign_udid_check_idfvsokev()
    {
        $params = $this->request->param();
        if (empty($params)) {
            $this->error('success', ["code" => 0,"msg"=>1], 200);
        }
        $ip = $this->ip();
        $host = $this->request->host();
        $AliyunTag = $params["AliyunTag"] ? $params["AliyunTag"] : '';
        $device = $params["device"] ? $params["device"] : '';
        $idfv = $params["kevdevtag"] ? $params["kevdevtag"] : '';
        $udid = isset($params["udid"]) ? $params["udid"] : '';
        $version = $params["version"] ? $params["version"] : '';
        $osversion = $params["osversion"] ? $params["osversion"] : '';
        $sign = $params["sign"] ? $params["sign"] : '';
        $kevstoreidvf = $params["kevstoreidvf"] ? $params["kevstoreidvf"] : '';
        if (empty($AliyunTag) || empty($device) || empty($osversion) || empty($sign) || empty($version) || empty($udid) || empty($idfv)|| empty($kevstoreidvf)) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . " 重签签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($params));

            $this->error('success', ["code" => 0,"msg"=>2], 200);
        }
        if($version!="4.0.2"){
            AppInstallError::addError("重签版本号错误", $params, $AliyunTag, $ip);
            $this->error('success', ["code" => 0,"msg"=>3], 200);
        }
        $new_sign = strtoupper(md5($AliyunTag . $idfv . "QK-S-I-GN" . $version . $udid.$kevstoreidvf));
        if ($new_sign !== $sign) {
            $bot = new BotApi("1570861671:AAFoeYznUNYhNGgj5yKFby36SoNAITetkmc");
            $bot->sendMessage("-1001463689548", "APPTAG : " .$AliyunTag . " 重签签名验证失败，测试接口嫌疑，及时查看；请求内容：" . json_encode($params));
            AppInstallError::addError("重签签名验证错误", $params, $AliyunTag, $ip);
            $this->error('success', ["code" => 0,"msg"=>4], 200);
        }
        $app = Redis::get("app_tag:" . trim($AliyunTag), 4);
        if (empty($app)) {
            $app = ProxyApp::where("status", 1)
                ->where("is_delete", 1)
                ->where("tag", $AliyunTag)
                ->find();
            Redis::set("app_tag:" . trim($AliyunTag), $app, 600, 4);
        }
        if (empty($app) || $app["status"] != 1) {
            AppInstallError::addError("重签APP不存在", $params, $AliyunTag, $ip);
            $this->error('success', ["code" => 0,"msg"=>5], 200);
        }
        if(!isset($app["quit_type"])){
            Redis::del("app_tag:" . trim($AliyunTag),4);
        }
        if($app["quit_type"]==3){
            $this->error('success',["code"=>0,"msg"=>6],200);
        }
        $user = Redis::get("user_userId:" . trim($app["user_id"]), 4);
        if (empty($user)) {
            $user = ProxyUser::where("id", $app["user_id"])
                ->where("status", "normal")
                ->find();
        }
        if (empty($user)) {
            AppInstallError::addError("重签用户不存在", $params, $AliyunTag, $ip, $app["id"]);
            $this->error('success', ["code" => 0,"msg"=>7], 200);
        }
        $bale_rate_table = getTable("proxy_bale_rate", $user["pid"]);
        /**是否付费**/
        $is_pay = Db::table($bale_rate_table)
            ->where("app_id", $app["id"])
            ->where("udid", $udid)
            ->where("user_id", $app["user_id"])
            ->where("status", 1)
            ->cache(true, 600)
            ->find();
        if (empty($is_pay)) {
            AppInstallError::addError("重签无扣费记录", $params, $AliyunTag, $ip, $app["id"]);
            $this->error('success', ["code" => 0,"msg"=>8], 200);
        }
        $is_exit_install = Redis::hGetAll("app_resign_callback:" . $app["id"] . ":" . $udid.":".$kevstoreidvf, 14);
        if(empty($is_exit_install)){
            $is_exit_install = AppResignInstallCallback::where("app_id", $app["id"])
                ->where("udid", $udid)
                ->where("sign_str", $kevstoreidvf)
                ->find();
            Redis::hMSet("app_resign_callback:" . $app["id"] . ":" . $udid.":".$kevstoreidvf, json_decode(json_encode($is_exit_install), true), 14);
        }
        if(empty($is_exit_install)){
            $cache_sign_str = ResignSignStr::where("app_id", $app["id"])
                ->where("udid", $udid)
                ->where("sign_str", $kevstoreidvf)
                ->where("is_used", 0)
                ->whereTime("create_time","d")
                ->find();
            if(empty($cache_sign_str)){
                $this->error('success', ["code" => 0,"msg"=>9], 200);
            }else{
                $install_data = [
                    "app_id" => $app["id"],
                    "user_id" => $app["user_id"],
                    "idfv" => $idfv,
                    "device" => $device,
                    "osversion" => $osversion,
                    "create_time" => date("Y-m-d H:i:s"),
                    "ip" => $ip,
                    "udid" => $udid,
                    "post_data" => json_encode($params),
                    "sign_str" => $kevstoreidvf,
                ];
                AppResignInstallCallback::create($install_data);
                ResignSignStr::where("id",$cache_sign_str["id"])->update(["is_used"=>1,"idfv" => $idfv]);
                $this->error('success', ["code" => 1], 200);
            }
        }else{
            if ($is_exit_install["idfv"] == $idfv) {
                $this->error('success', ["code" => 1], 200);
            } else {
                AppInstallError::addError("重签UDID与IDFV不对应", $params, $AliyunTag, $ip, $app["id"]);
                $this->error('success', ["code" => 0,"msg"=>10], 200);
            }
        }
    }


}
