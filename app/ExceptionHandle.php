<?php
namespace app;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
        $errdir="";
        $j=json_encode($exception,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
      //  $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
      //  \think\facade\Log::error(  $lineNumStr);
        \think\facade\Log::error("----------------errrrrx_tp_ex_cathr---------------------------");
        \think\facade\Log::error("file_linenum:".$exception->getFile().":".$exception->getLine());
        \think\facade\Log::error("errmsg:".$exception->getMessage());
     //   \think\facade\Log::error("errtrace:".$exception->getTrace());
        \think\facade\Log::error("errtraceStr:".$exception->getTraceAsString());
        \think\facade\Log::error("----------------errrrr finish---------------------------");

       // file_put_contents( $errdir.date('Y-m-d H')."ex648_exhdlRpt.txt", $exception->getMessage() .PHP_EOL, FILE_APPEND);
      //  file_put_contents( $errdir.date('Y-m-d H')."ex648_exhdlRpt.txt",  $j.PHP_EOL, FILE_APPEND);
        var_dump($exception->getMessage().$exception->getFile().":".$exception->getLine());
        var_dump($exception->getTraceAsString());
        
        throw  $exception;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        $exception=$e;
        // 添加自定义异常处理机制
        \think\facade\Log::info($exception->getFile().":".$exception->getLine());
        \think\facade\Log::info($exception->getMessage());
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
