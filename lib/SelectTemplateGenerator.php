<?php
/**
 * 生成select通用性组件
 */
class SelectTemplateGenerator {
    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;

    const OUTPUT_JSON = 'json';
    const OUTPUT_HTML = 'html';

    // 专门用于彩种-玩法群-玩法三联下拉框数据的生成, 在app/commands/schedules/GenerateSelectorCommand.php中有相应的注释
    public function generateGroupWays()
    {
        $aWidgets  = Config::get('widget.widget');
        $key = 'series-way-groups-way-group-ways';
        $aWidget = $aWidgets[$key];

        $aData = $this->_generate3LevelData($aWidget);
        $sName       = isset($aWidget['name']) ? $aWidget['name'] : 'name';
        $sDataName   = isset($aWidget['dataName']) ? $aWidget['dataName'] : 'selectorData';
        $bResult = $this->_generateJsonFile($aData, $key, $sName, $sDataName);
        return $bResult;
    }

    /**
     * [generate 根据app/config/widget.php的配置，生成相应的下拉框的json数据文件或html页面文件]
     * @return [Array] [结果数组]
     */
    public function generate()
    {
        $aWidgets  = Config::get('widget.widget');
        $aResults  = [];
        foreach ($aWidgets as $key => $aWidget) {
            $iLevel      = $aWidget['level'];
            $sOutput     = $aWidget['output'];
            $sName       = isset($aWidget['name']) ? $aWidget['name'] : 'name';
            $sDataName   = isset($aWidget['dataName']) ? $aWidget['dataName'] : 'selectorData';
            $aExtraParam = isset($aWidget['extraParam']) ? isset($aWidget['extraParam']) : [];
            $sSelectName = isset($aWidget['selectName']) ? $aWidget['selectName'] : $key;
            $aData       = $iLevel == self::LEVEL_3 ? $this->_generate3LevelData($aWidget) : $this->_generateData($aWidget);
            // pr($aData);exit;
            switch ($sOutput) {
                case self::OUTPUT_HTML:
                    $bResult = $this->_generateHtmlFile($aData, $key, $sName, $aExtraParam);
                    break;
                case self::OUTPUT_JSON:
                    $bResult = $this->_generateJsonFile($aData, $key, $sName, $sDataName);
                    break;
                default:
                    $bResult = $this->_generateHtmlFile($aData, $key, $sName, $aExtraParam);
                    break;
            }

            // $bResult = $this->_generateFile($aData, $key, $aWidget['level'], (isset($aWidget['name']) ? $aWidget['name'] : 'name'));
            $aResults[] = $bResult;
        }
        return $aResults;
    }

    /**
     * [_generate3LevelData 专门用于彩种-玩法群-玩法三联下拉框数据的生成]
     * @param  [Array] $aWidget [彩种-玩法群-玩法的配置数组 ]
     * @return [Array]          [数据]
     */
    private function _generate3LevelData($aWidget)
    {
        $aOptionsData   = [];
        $sMainModel     = $aWidget['main'];
        $sChildModel    = $aWidget['children'];
        $sGrandsonModel = $aWidget['grandson'];
        $iLevel         = $aWidget['level'];
        $sName1         = isset($aWidget['name1']) ? $aWidget['name1'] : 'name';
        $sName2         = isset($aWidget['name2']) ? $aWidget['name2'] : 'title';
        $sParentKey1    = isset($aWidget['parent1']) ? $aWidget['parent1'] : 'series_id';
        $sParentKey2    = isset($aWidget['parent2']) ? $aWidget['parent2'] : 'parent_id';
        $sParentKey3    = isset($aWidget['parent3']) ? $aWidget['parent3'] : 'group_id';
        $aColumns1      = ['id', $sName1];
        $aColumns2      = ['id', $sName2];
        $aColumns3      = ['series_way_id', 'group_id', $sName2];

        $aMainData = $sMainModel::all($aColumns1);
        foreach ($aMainData as $oMainData) {
            $key1 = $sParentKey1 . '_' . $oMainData->id;
            $aOptionsData[$key1] = $oMainData->getAttributes();
            if ($sChildModel) {
                $aOptionsData[$key1]['children'] = [];
                $aChildData = $sChildModel::where($sParentKey1, '=', $oMainData->id)->whereNull($sParentKey2)->where('terminal_id','=','1')->orderBy('sequence')->get($aColumns2);
                foreach ($aChildData as $oChildData) {
                    $aAttributes2 = $oChildData->getAttributes($aColumns2);
                    $key2 = $sParentKey2 . '_' . $oChildData->id;
                    $aOptionsData[$key1]['children'][$key2] = ['id' => $aAttributes2['id'], 'name' => $aAttributes2['title']];
                    if ($sGrandsonModel) {
                        $aOptionsData[$key1]['children'][$key2]['children'] = [];
                        $aSubGroup = $sChildModel::where($sParentKey2, '=', $oChildData->id)->orderBy('sequence')->get($aColumns2);
                        $aSubGroupIds = [];
                        $aSubGroupNames = [];
                        foreach ($aSubGroup as $oSubGroup) {
                            $aSubGroupIds[] = $oSubGroup->id;
                            $aSubGroupNames[$oSubGroup->id] = $oSubGroup->title;
                        }
                        if ($aSubGroupIds) {
                            $aGrandsonData = $sGrandsonModel::whereIn($sParentKey3, $aSubGroupIds)->where('for_search','=',1)->orderBy('sequence')->get($aColumns3);
                            foreach ($aGrandsonData as $oGrandsonData) {
                                $aAttributes3 = $oGrandsonData->getAttributes();
                                // 二星玩法需要加直选/组选前缀
                                $aTwoStarIds = [16,17];
                                $sName = (in_array($aAttributes3['group_id'], $aTwoStarIds) ? '[' . $aSubGroupNames[$aAttributes3['group_id']] . ']' : '') . $aAttributes3['title'];
                                $aOptionsData[$key1]['children'][$key2]['children'][] = ['id' => $aAttributes3['series_way_id'], 'name' => $sName];
                            }
                        }
                    }
                }
            }
        }
        return $aOptionsData;
    }
    /**
     * [_generateData 生成下拉框数据的生成]
     * @param  [Array] $aWidget [配置数组]
     * @return [Array]          [数据]
     */
    private function _generateData($aWidget)
    {
        $aOptionsData = [];
        $sMainModel   = $aWidget['main'];
        $sChildModel  = $aWidget['children'];
        $iLevel       = $aWidget['level'];
        $sFriendlyName= isset($aWidget['friendly']) ? $aWidget['friendly'] : '';
        $sName        = isset($aWidget['name']) ? $aWidget['name'] : 'name';
        $aExtraParam  = isset($aWidget['extraParam']) ? $aWidget['extraParam'] : [];
        $sParentKey   = isset($aWidget['parent']) ? $aWidget['parent'] : 'parent_id';
        $aColumns     = ['id', $sName];
        if ($aExtraParam) $aColumns = array_merge($aColumns, $aExtraParam);
        $aMainData    = ($iLevel == self::LEVEL_1 || $sMainModel != $sChildModel) ? $sMainModel::all($aColumns) : $sMainModel::whereNull($sParentKey)->get($aColumns);
        // pr(($iLevel == self::LEVEL_1 ). '-----' . $sMainModel . '-----' . $sParentKey . '--------');
        // pr($aMainData->toArray());exit;
        foreach ($aMainData as $oMainData) {
            $aMainDataRecord = $oMainData->getAttributes();
            if ($sFriendlyName) {
                $aMainDataRecord[$sName] = $oMainData->{$sFriendlyName};
            }
            $aOptionsData[$oMainData->id] = $aMainDataRecord;
            if ($iLevel == self::LEVEL_2 && $sChildModel) {
                $aOptionsData[$oMainData->id]['children'] = [];
                $aChildData = $sChildModel::where($sParentKey, '=', $oMainData->id)->get($aColumns);
                foreach ($aChildData as $oChildData) {
                    $aOptionsData[$oMainData->id]['children'][] = $oChildData->getAttributes();
                }
            }
        }
        unset($aMainData, $aChildData, $aColumns);
        return $aOptionsData;
    }
    /**
     * [_generateJsonFile 生成json数据文件]
     * @param  [Array] $aData      [数据]
     * @param  [String] $sFileName [文件名]
     * @param  [String] $sName     [标题列名]
     * @param  [String] $sDataName [json变量的名称]
     * @return [Array]             [结果数组]
     */
    private function _generateJsonFile($aData, $sFileName, $sName, $sDataName)
    {
        $sDataPath = Config::get('widget.data_path');
        $sPath     = realpath($sDataPath) . '/';
        $sSuffix   = '.blade.php';
        $sFile     = $sPath . $sFileName . $sSuffix;
        if (file_exists($sFile)){
            if (!is_writable($sFile)){
                return ['successful' => false, 'message' => 'File ' . $sFileName . ' not writable'];
            }
        }
        else{
            if (!is_writeable($sPath)){
                return ['successful' => false, 'message' => 'File ' . $sFileName . ' written in Path ' . $sPath . ' not writable'];
            }
        }
        $bSucc    = @file_put_contents($sFile, "var " . $sDataName . "=" . json_encode($aData));
        $sLangKey = ($bSucc ? ' generated' : ' write failed');
        $aReturn  = [
            'successful' => $bSucc,
            'message' => 'File ' . $sFileName . $sLangKey
        ];
        return $aReturn;
        // $sKey = $aReturn['successful'] ? 'success' : 'error';
        // return $this->goBackToIndex($sKey, $aReturn['message']);
    }

    /**
     * [_generateHtmlFile 生成html文件]
     * @param  [Array] $aData      [数据]
     * @param  [String] $sFileName [文件名]
     * @param  [String] $sName     [标题列名]
     * @param  [Array] $aExtraParam [额外的参数名]
     * @return [Array]               [结果数组]
     */
    private function _generateHtmlFile($aData, $sFileName, $sName, $aExtraParams)
    {
        $sRootPath = Config::get('widget.root_path');
        $sPath     = realpath($sRootPath) . '/';
        $sSuffix   = '.blade.php';
        $sFile     = $sPath . $sFileName . $sSuffix;
        if (file_exists($sFile)){
            if (!is_writable($sFile)){
                return ['successful' => false, 'message' => 'File ' . $sFileName . ' not writable'];
            }
        }
        else{
            if (!is_writeable($sPath)){
                return ['successful' => false, 'message' => 'File ' . $sFileName . ' written in Path ' . $sPath . ' not writable'];
            }
        }
        $aHtml = [
            '<select id="J-select-' . $sFileName . '" name="{{ $sSelectName }}">',
                '<option value="" selected="selected">{{ $sEmptyDesc }}</option>',
        ];
        foreach ($aData as $key => $value) {
            $option = '<option value="' . $value['id'] . '" ';
            if ($aExtraParams) {
                $aExtraAttrs = [];
                foreach ($aExtraParams as $sExtraParam) {
                    $sExtraParamStr = ($sExtraParam && $value[$sExtraParam]) ? ($sExtraParam . '=' . $value[$sExtraParam] . ' ') : '';
                    $aExtraAttrs[] = $sExtraParamStr;
                }
                $option .= implode('', $aExtraAttrs);
            }
            $option .= '>' . $value[$sName] . '</option>';
            $aHtml[] = $option;
            // $sExtraParamStr = ($sExtraParam && $value[$sExtraParam]) ? ($sExtraParam . '=' . $value[$sExtraParam]) : '';
            // $option = '<option value="' . $value['id'] . '" ' .$sExtraParamStr . '>' . $value[$sName] . '</option>';
            // $aHtml[] = $option;
        }
        $aHtml[]  = '</select>';
        $html     = implode('', $aHtml);
        $bSucc    = @file_put_contents($sFile, $html);
        $sLangKey = ($bSucc ? ' generated' : ' write failed');
        $aReturn  = [
            'successful' => $bSucc,
            'message' => 'File ' . $sFileName . $sLangKey
        ];
        return $aReturn;
    }
}