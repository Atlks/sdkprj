<?php
/**
 * 流水相关接口
 * User: damon
 * Date: 5/17/16
 * Time: 08:27 PM
 */

class TurnoverService extends BaseService
{
    protected $logFile = 'turnover';

    public function effectiveTurnover(){
        return $this->_doApi('data-api','effective-turnover',[]);
    }

    public function projectTurnover($date){
        return $this->_doApi('data-api','finished-sales-by-bill',['date' => $date]);
    }

}

