<?php
/**
 * Class ActivityProfitSendPrizesCondition - 投注送奖品条件类
 *
 * @author Johnny 
 */
class ActivityProfitSendPrizesCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        'prize_ids'=>'奖品列表',
        //至少会赠送一次
        'max_times'=>'最多赠送多少次',
        //单笔下注金额,比如每99元送一次
        'nums'=>'每次下注金额',
        //保留参数,后期扩展
        'type'=>'频率(1:按天)',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $max_times  = intval($this->data->get('max_times'));
        $times   = $this->getTimes($userCondition);

        $profit  = Project::getCurrentDayTurnover($userCondition->user_id, date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
        $num     = intval($this->data->get('nums'));


        $count   = min([intval($profit / $num), $max_times]);

        $last_num= $count - $times;

        if ($last_num > 0)
        {
            $times += $last_num;
            $this->send($userCondition, $last_num);
            $userCondition->datas   = ['times' => $times, 'finish_at'=>date("Y-m-d")];
            $userCondition->save();
        }
        //当达到每日上限的时候,返回任务完成
        if ($max_times <= $times)
        {
            return true;
        }

        return false;
    }

    /**
     * 获取已完成次数
     *
     * @param $userCondition
     */
    protected function getTimes($userCondition)
    {


        $times      = isset($userCondition->datas['times']) ? $userCondition->datas['times'] : 0;
        $finish_at  = isset($userCondition->datas['finish_at']) ? $userCondition->datas['finish_at'] : '';

        if ($finish_at && date("Y-m-d", strtotime($finish_at)) != date("Y-m-d"))
        {
            return 0;
        }
        return $times;
    }

    /**
     * 条件内赠送奖品
     *
     * @param $userCondition
     * @param $count
     * @return bool
     */
    protected function send($userCondition, $count)
    {
        $prize_ids  = explode(',', $this->data->get('prize_ids'));

        $status = true;
        foreach ($prize_ids as $prize_id)
        {
            if(!$userCondition->send($prize_id, $count))
            {
                $status = false;
            }
        }
        return $status;
    }
}