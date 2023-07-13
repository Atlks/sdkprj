<?php

/**
 * Description of UserTool
 *
 * @author winter
 */
class UserTool {

    public static function getErrMsg($iErrno, $sErrMsg){
        if (!$sErrMsg){
            switch($iErrno){
                case User::REGISTER_ERROR_NO_PASSWD:
                    $sErrMsg = __('_user.missing-password');
                    break;
                case User::REGISTER_ERROR_PASSWD_WRONG:
                    $sErrMsg = __('_user.password-error');
                    break;
                case User::REGISTER_ERROR_USER_SAVE_ERROR:
//                    $sErrMsg = & $oUser->getValidationErrorString();
                    break;
                case User::REGISTER_ERROR_CREATE_ACCOUNT_FAILED:
                    $sErrMsg = __('_account.create-account-failed');
                    break;
                case User::REGISTER_ERROR_CREATE_PRIZE_GROUP_SET:
                    $sErrMsg = __('_userprizeset.create-failed');
                    break;
                case User::REGISTER_ERROR_CREATE_QUOTA_FAILED:
                    $sErrMsg = __('_user.quota-config-error');
                    break;
                case User::REGISTER_ERROR_QUOTA_NOT_ENOUGH:
                    $sErrMsg = __('_user.quota-not-enough');
                    break;
                case User::REGISTER_ERROR_PRIZE_GROUP_ERROR :
                    $sErrmsg = __('_basic.missing', ['resource' => '奖金组']);
                    break;
                case User::REGISTER_ERROR_CREATE_REBATE:
                    $sErrMsg = __('_user.rebate-set-error');
                    break;
            }
        }
        return $sErrMsg;
    }
    
    public static function createUser(& $aData, $iParentId, $iRegisterLinkId, & $oUser, & $iErrno, & $sErrMsg){
        $oPrizeGroup = PrizeGroup::find($aData['prize_group_id']);
        if (!$oPrizeGroup) {
            $iErrno = User::REGISTER_ERROR_PRIZE_GROUP_ERROR;
            return false;
        }
        $sPrizeGroup = $oPrizeGroup->name;
        if ($iParentId){
            $oAgent = User::find($iParentId);
            $bUseQuota = SysConfig::get('use_quota') && $sPrizeGroup >= SysConfig::get('use_quota_min_group');
//            $bUseGroupQuota = SysConfig::get('use_group_quota');
            if ($bUseQuota){
                if ($iRegisterLinkId){
                    $oRegisterLink = RegisterLink::find($iRegisterLinkId);
                    $aData['agent_prize_set_quota'] = $oRegisterLink->agent_prize_set_quota;
                }
                if (!static::checkQuota($aData, $iParentId, $sPrizeGroup, $aPrizeSetQuota, $iErrno)){
                    $iErrno = User::REGISTER_ERROR_QUOTA_NOT_ENOUGH;
                    return false;
                }
            }
            else{
                $aPrizeSetQuota = null;
            }
        }
        $bSucc = User::createUser($aData, $sPrizeGroup, $iParentId, $iRegisterLinkId, false, $oUser, $iErrno, $sErrMsg);
        if (!$bSucc){
            return false;
        }
        //设置返点
        if(!empty($aData['fb_single']) && !empty($aData['fb_all'])){
                //获取当前用户返点
                $fUserSinglePercentValue = UserPercentSet::getPercentValueByUser($oUser->parent_id,UserPercentSet::$iFootBallLotteryId,PercentWay::$jcWays['single']);
                $fUserMultiPercentValue = UserPercentSet::getPercentValueByUser($oUser->parent_id,UserPercentSet::$iFootBallLotteryId,PercentWay::$jcWays['multi']);
                if($aData['fb_single'] > $fUserSinglePercentValue || $aData['fb_all'] > $fUserMultiPercentValue){
                    $iErrno = User::REGISTER_ERROR_CREATE_REBATE;
                    return false;
                }
                $aPercentSet = [
                    [
                        'percent_identity' => 'single',
                        'percent_value' => $aData['fb_single']
                    ],
                    [
                        'percent_identity' => 'multi',
                        'percent_value' => $aData['fb_all']
                    ]
                ];
                $bSucc = UserPercentSet::initUserPercentSet($oUser,$aPercentSet);
                if(!$bSucc){
                    $iErrno = User::REGISTER_ERROR_CREATE_REBATE;
                    return false;
                }
        }
        if($iRegisterLinkId > 0){
            $oRegisterLink = RegisterLink::find($iRegisterLinkId);
            if(!empty($oRegisterLink->percent_sets)){
                $aPercentSet = json_decode($oRegisterLink->percent_sets,true);
                $bSucc = UserPercentSet::initUserPercentSet($oUser,$aPercentSet);
                if(!$bSucc){
                    $iErrno = User::REGISTER_ERROR_CREATE_REBATE;
                    return false;
                }
            }
        }

        if ($bUseQuota){
            if ($iRegisterLinkId){
                $bSucc = true;
                if (!$oRegisterLink->is_top) {
//                    !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($iParentId, $aPrizeSetQuota);
                    !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($iParentId, [$oUser->prize_group => 1]);
//                    if ($bSucc && SysConfig::get('use_group_quota')){
                    $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
//                    }
//                    !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
                } else {
                    !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
                }
                if (!$bSucc){
                    $iErrno = User::REGISTER_ERROR_CREATE_QUOTA_FAILED;
                    return false;
                }
            }
            else{
                if ($aPrizeSetQuota && !static::updateQuota($aData, $oUser, $aPrizeSetQuota)){
                    $iErrno = User::REGISTER_ERROR_CREATE_QUOTA_FAILED;
                    return false;
                }
            }
        }
        return true;
    }
    
    private static function checkQuota(& $aData, $iAgentId, $sPrizeGroup, & $aPrizeSetQuota, & $iErrno){
//        pr($aData);
//        exit;
        if ($aData['is_agent']) {
            $oAgent = User::find($iAgentId);
            
            //检验当前开户者是否有开户配额
            $aPrizeSetQuota = json_decode($aData['agent_prize_set_quota'],true);
            $bSucc = UserPrizeSetQuota::checkQuota([$sPrizeGroup => 1], $iAgentId);
            if (array_get($aPrizeSetQuota, $sPrizeGroup) !== null) {
                $aPrizeSetQuota[$sPrizeGroup] ++;
            }
            //检验开户配额是否符合要求
            !$bSucc or $bSucc = UserPrizeSetQuota::checkQuota($aPrizeSetQuota, $iAgentId);
            // pr($bSucc);
            if (!$bSucc) {
                $iErrno = User::REGISTER_ERROR_QUOTA_NOT_ENOUGH;
                return false;
            }
            if (array_get($aPrizeSetQuota, $sPrizeGroup) !== null) {
                $aPrizeSetQuota[$sPrizeGroup] --;
            }
            return true;
        }
        return true;
    }

    private static function updateQuota(& $aData, $oUser, $aPrizeSetQuota) {
        $bSucc = true;
        if ($aData['is_agent']) {
//            !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($oUser->parent_id, $aPrizeSetQuota);
            $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($oUser->parent_id, [$oUser->prize_group => 1]);
            !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
        }
        if (!$bSucc){
            $iErrno = User::REGISTER_ERROR_CREATE_QUOTA_FAILED;
        }
        return $bSucc;
    }
    
}
    
    
