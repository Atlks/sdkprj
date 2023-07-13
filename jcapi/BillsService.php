<?php
/**
 * 赛事相关接口
 * User: damon
 * Date: 2/4/16
 * Time: 3:20 PM
 */

class BillsService extends BaseService
{
    protected $logFile = 'bills';
    /**
     * 获取赛事数据
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @param string $isHot 是否热门
     * @param string $isSingle 是否单关
     * @return array []
     */
    public function addBills($data){
        return $this->_doApi('data-api','bills',['game_type'=>'football'],$data);
    }

    public function getBills($sn){
        return $this->_doApi('data-api','bill-results',['game_type'=>'football'],['sn'=>$sn]);
    }

    //订单列表 投注记录页面列表数据
    public function billList($sUsername,$aParam,$iPage = 1){
        $aData = ['username'=>$sUsername,'page'=>$iPage];
        foreach($aParam as $k => $param){
            $aData[$k] = json_encode($param);
        }
        return $this->_doApi('data-api','bills',$aData);
    }

    //注单详情 订单详情页面列表数据
    public function billDetail($sUsername,$id){
        return $this->_doApi('data-api','bill-detail',['username'=>$sUsername,'bill_id'=>$id]);
    }

    //出票记录 出票详情页面数据
    public function ticketDetail($sn){
        return $this->_doApi('data-api','bill-results',['game_type'=>'football'],['sn'=>$sn]);
    }

    /**
     * 获取最近中奖金额
     * @return array|mixed|string
     */
    public function getLatestWinBills(){
        return $this->_doApi('data-api','latest-win-bills',[],[]);
    }

    /**
     * 交易记录接口
     * @param $aParams
     * @param $iPerpage
     * @param $iPage
     * @return array|mixed|string
     */
    public function getTransactions($aParams,$iPerpage,$iPage){
        $aData = ['perpage'=>$iPerpage,'page'=>$iPage];
        foreach($aParams as $k => $param){
            $aData[$k] = json_encode($param);
        }
        return $this->_doApi('data-api','transactions',$aData,[]);
    }
}
