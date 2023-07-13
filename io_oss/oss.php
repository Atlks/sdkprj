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
     //   $loc="cn";
        $dbg['loc']=$loc;
      

        if($loc=="cn")
             return    $this->  upldoss737();    
        else
        {   //ovss   
            $dbg['ovss blk']=1; 
        //     echo json_encode($dbg);
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
        if($filetype=="php")
        die("只能上传ipa apk等文件");
      // die($filetype);
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
        $accessKeyId =  config('accessKeyId');
        $accessKeySecret = config('accessKeySecret');
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint =  config('endpoint');
        // 填写Bucket名称，例如examplebucket。
        $bucket= config('bucket');
        // <yourObjectName>表示上传文件到OSS时需要指定包含文件后缀，不包含Bucket名称在内的完整路径，例如abc/efg/123.jpg。
        $filInfo=$this-> getSaveFileInfo();
        $object_path = $filInfo['filepath'];
        $content = $filInfo['file'];    //  tp file obj
       //  $content ="aaaaaa";

        file_put_contents("dbg815.txt",$object_path."\r\n",FILE_APPEND );
        //try {

            error_reporting ( E_ALL);
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $dbg['accessKeyId']=$accessKeyId;  $dbg['accessKeySecret']=$accessKeySecret;  $dbg['endpoint']=$endpoint;
                file_put_contents("dbg815.txt",json_encode( $dbg)."\r\n",FILE_APPEND );
            file_put_contents("dbg815.txt",json_encode( $ossClient)."\r\n",FILE_APPEND );



            $fh = fopen($content->getLinkTarget(), "rb");
            //仅读取前面的8个字节
            $file_conBin = fread($fh, filesize($content->getLinkTarget()));
            fclose($fh);
            $ossClient->putObject($bucket, $object_path, $file_conBin);
            //  $content->getLinkTarget()    C:\Windows\php6340.tmp
        // } catch (OssException $e) {
        //     print $e->getMessage();
        // }
        $result["path"] = $object_path;
        return json($result);
    }


     /**
     * 首页
     *  http://localhost:81/index.php/api/upldoss/upldoss737
     */
    public function ossdown()
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
       
       //  $content ="aaaaaa";
       $object_path="cache-uploads/20230704//1688449310.ipa";
        file_put_contents("dbg815.txt",$object_path."\r\n",FILE_APPEND );
        //try {

            error_reporting ( E_ALL);
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $dbg['accessKeyId']=$accessKeyId;  $dbg['accessKeySecret']=$accessKeySecret;  $dbg['endpoint']=$endpoint;
                file_put_contents("dbg815.txt",json_encode( $dbg)."\r\n",FILE_APPEND );
            file_put_contents("dbg815.txt",json_encode( $ossClient)."\r\n",FILE_APPEND );

         //   $ossClient->putObject($bucket, $object_path, $content->getLinkTarget());

         $content = $ossClient->getObject($bucket,  $object_path);
         print("object content: " . $content);
         $handle = fopen("ot1236.txt","w+");
         fwrite($handle,   $content );
        fclose(  $handle );
     
         file_put_contents("dbg815.txt",json_encode( "object content:")."\r\n",FILE_APPEND );
         file_put_contents("dbg815.txt",json_encode( $content)."\r\n",FILE_APPEND );


        // } catch (OssException $e) {
        //     print $e->getMessage();
        // }
        $result["path"] = $object_path;
        return json($result);
    }
