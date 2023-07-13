<?php
/**
 * 赛事相关接口
 * User: damon
 * Date: 2/4/16
 * Time: 3:20 PM
 */

class GamesService extends BaseService
{
    protected $logFile = 'games';
    /**
     * 获取赛事数据
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @param string $isHot 是否热门
     * @param string $isSingle 是否单关
     * @return array []
     */
    public function getGamesData($gameType,$betDate = '',$isHot = '',$isSingle = ''){
        $data = [
            'game_type' => $gameType,
            'bet_date' => $betDate,
            'hot' => $isHot,
            'single' => $isSingle
        ];
        return $this->_doApi('data-api','games',$data);
    }

    /**
     * 获取热门比赛接口
     * @return array
     */
    public function getHotGames(){
        return $this->_doApi('data-api','hot-games',[],[]);
    }

    public function getOnsaleGamesCount(){
        return $this->_doApi('data-api','onsale-games-count',[],[]);
    }
}
