<?php
/**
 * 赔率相关接口
 * User: damon
 * Date: 2/4/16
 * Time: 3:20 PM
 */

class OddsService extends BaseService
{
    protected $logFile = 'odds';

    /**
     * 获取赔率数据
     * @param $sns 赛事编号
     * @return array 接口结果
     */
    public function getOddsData($gameType,$sns){
        $data = [
            'game_type' => $gameType,
            'bn' => implode(',',$sns)
        ];
        return $this->_doApi('data-api','odds',$data);
    }
}
