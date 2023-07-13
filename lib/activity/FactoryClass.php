<?php
/**
 * Class FactoryClass - 类对象工厂
 *
 * @author Johnny 
 */
use Illuminate\Support\Collection as Collection;
use \Illuminate\Support\MessageBag;
abstract class FactoryClass
{
    /**
     * 能够处理的类实例
     *
     */
    const CAN_HANDLE_OBJECT_CLASS='FactoryObjectClassInterface';
    /**
     * 单例工厂
     * @var array
     */
    static private $_classes=[];
    /**
     * 类生成参数数据
     * @var Collection
     */
    public $data;

    /**
     * @var array
     */
    protected $tasks=[];

    /**
     * @var MessageBag
     */
    protected $messages;

    /**
     * 参数列表
     *
     * @var array
     */
    static protected $params=[];

    /**
     * 构造函数
     *
     * @param array $data
     */
    protected function __construct($data=[])
    {
        //初始化配置
        $this->init((array) $data);
        $this->clearMessages();
        $this->tasks= new Collection();
    }

    /**
     *
     * 初始化错误提示
     *
     */
    protected function clearMessages()
    {
        $this->messages   = new MessageBag();
        return $this;
    }

    /**
     * 运行信息
     *
     * @return MessageBag
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * 初始化配置
     *
     * @param $data
     */
    protected function init($data)
    {
        $_data  = [];
        foreach (static::params() as $key => $value)
        {
            $_data[$key]    = (isset($data[$key])) ? $data[$key] : null;
        }

        $this->data = new Collection($_data);
    }

    /**
     *
     * 载入需要处理的任务,适合于需要批量提交或者事务的操作,与all结合使用
     *
     * @param FactoryObjectClassInterface $object
     */
    public function load(FactoryObjectClassInterface $object)
    {
        $can_class  = static::CAN_HANDLE_OBJECT_CLASS;
        if (!($object instanceof $can_class))
        {
            $className = get_class($object);
            throw new Exception("{$can_class} must be instance of {$className}");
        }

        $this->tasks->push($object);

        return $this;
    }

    /**
     * 流程执行
     *
     * @param FactoryObjectClassInterface $object
     * @return bool
     */
    protected function _run(FactoryObjectClassInterface $object)
    {
        if ($this->complete($object))
        {
            return $object->completed();
        }
        return false;
    }

    /**
     * 处理第一个任务
     *
     * @return bool
     * @throws Exception
     */
    public function process()
    {
        return $this->_run($this->tasks->shift());
    }

    /**
     * 批量处理已载入的所有任务,适合于需要批量提交或者事务的操作,与load结合使用
     *
     * @return array
     * @throws Exception
     */
    public function all()
    {
        $result = true;
        while(!$this->tasks->isEmpty())
        {
            $result = $this->process() && $result;
        }

        return $result;
    }


    /**
     * 完成状态
     *
     * @param FactoryObjectClassInterface $object
     * @return bool
     */
    abstract protected function complete($object);

    /**
     * 获得所有参数列表
     *
     * @return array
     */
    static public function params()
    {
        return static::$params;
    }

    /**
     * 创建工厂单例
     *
     * @param $class
     * @return FactoryClass
     * @throws Exception
     */
    static public function Factory(FactoryClassInterface $class)
    {
        $class_name = $class->getClassName();
        $params     = $class->getParams();

        $key    = md5($class_name.'___'.serialize($params));
        if (isset(self::$_classes[$key]))
        {
            return self::$_classes[$key];
        }
        
        $object = new $class_name($params);

        if (!($object instanceof self))
        {
            throw new Exception("{$class_name} must be instance of FactoryClass");
        }

        return self::$_classes[$key] = $object;
    }
}

/**
 * 类工厂器接口
 *
 * Interface FactoryClassInterface
 */
interface FactoryClassInterface
{
    /**
     * 获取类名
     *
     * @return mixed
     */
    public function getClassName();

    /**
     * 获取实例化所需要的参数
     *
     * @return mixed
     */
    public function getParams();
}

/**
 * 类工厂器处理对象类
 *
 * Interface FactoryObjectClassInterface
 */
interface FactoryObjectClassInterface
{
    /**
     * 完成
     *
     * @return mixed
     */
    public function completed();
}