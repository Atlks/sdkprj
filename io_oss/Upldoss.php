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
class Upldoss   extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *  http://localhost:81/index.php/api/upldoss/upldoss737
     */
    public function upldoss737()
    {
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
        $endpoint = "oss-accelerate.aliyuncs.com";
        // 填写Bucket名称，例如examplebucket。
        $bucket= "kkhhhiissz";
        // <yourObjectName>表示上传文件到OSS时需要指定包含文件后缀，不包含Bucket名称在内的完整路径，例如abc/efg/123.jpg。
        $object = "abc/efg/123.jpg";
        $content = "Hi, OSS.";
        
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->putObject($bucket, $object, $content);
        } catch (OssException $e) {
            print $e->getMessage();
        }
        echo 666;
    }


}
