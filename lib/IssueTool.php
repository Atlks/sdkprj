<?php

/**
 * 奖期工具
 *
 * @author winter
 */
class IssueTool {

    public static function addExtraTask($oIssue){
        $iLotteryId = $oIssue->lottery_id;
        $aConfigs = Config::get('correlative');
        if (!isset($aConfigs[$iLotteryId])){
            return true;
        }
        $data = [
            'source_lottery_id' => $iLotteryId,
            'lottery_id' => $aConfigs[$iLotteryId],
            'issue' => $oIssue->issue
        ];
//        pr($data);
        $bSucc = BaseTask::addTask('GenerateWnNumberForCorrelative', $data, 'issue', 0, $sRealQueue);
        file_put_contents('/tmp/relative-queue', $sRealQueue);
        return $bSucc;
    }

}
