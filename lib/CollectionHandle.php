<?php
use Illuminate\Support\Collection;

/*
 *    补充Collection 在 Laravel 4.0 不足的地方
 */
Class CollectionHandle
{
    protected $oCollection;

    public function __construct(Collection $oCollection = null)
    {
        $this->oCollection = $oCollection;
        return $this;
    }

    /**
     * 设定集合
     *
     * @author Wright
     * @date     2017-03-08
     *
     * @param  object      $oCollection
     * @return  object      $this
     */
    public function setCollection(Collection $oCollection)
    {
        $this->oCollection = $oCollection;
        return $this;
    }

    /**
     * 取出集合
     *
     * @author Wright
     * @date     2017-03-08
     *
     * @return  object $oCollection
     */
    public function getCollection()
    {
        return $this->oCollection;
    }

     /**
     * 取出集合内的第一个物件
     *
     * @author Wright
     * @date     2017-03-08
     *
     * @return  object
     */
    public function getFirst()
    {
        return $this->oCollection->first();
    }

    /**
     * 滤出符合条件的model物件
     *
     * @author Wright
     * @date     2017-03-08
     *
     * @param  string        $sKey
     * @param  string        $sValue
     * @param  string        $sOperator     运算子
     * @return  object        $oCollection
     */
    public function search($sKey, $sValue, $sOperator = '==')
    {
        $oCollection = $this->oCollection->filter(function ($item) use ($sKey, $sValue, $sOperator)
        {
            eval('$bFilterResult = $item->$sKey ' . $sOperator . ' $sValue;');
            return $bFilterResult;
        });

        return new self($oCollection);
    }

}