<?php
/**
 * 资金相关接口
 * User: damon
 * Date: 3/25/16
 * Time: 3:20 PM
 */

class TransferService extends BaseService
{
    protected $logFile = 'transfer';
    protected $protocolType = 'https';

    public function transferIn($username,$amount){
        return $this->_doApi('data-api','transfer-in',[],['amount'=>$amount,'username'=>$username]);
    }

    public function transferOut($username,$amount){
        return $this->_doApi('data-api','transfer-out',[],['amount'=>$amount,'username'=>$username]);
    }

    public function balance($username){
        return $this->_doApi('data-api','balance',['username'=>$username]);
    }

    /**
     * 累计中奖金额
     * @return array|mixed|string
     */
    public function getAccPrice(){
        return $this->_doApi('data-api','accumulate-prize',[]);
    }
}

