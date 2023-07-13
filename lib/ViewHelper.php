
<?php

/**
 * 视图工具类
 *
 * @author winter
 */
class ViewHelper {

    /**
     * 根据给定的列数组，显示给定的模型数据
     *
     * @param model     $oModel         模型
     * @param array     $aColumns       要显示的列名
     * @param array     $aViewSettings  二维数组，包括所需要的各个列配置数组
     * @param array     $aArrayVars     二维数组，包括与模型列相关联的可选值数组
     * @param integer   $sLabelWidth
     */
    public static function displayForView($oModel, & $aColumns, & $aViewSettings, & $aArrayVars, $sLabelWidth = 2){
        for($i = 0;$i < count($aColumns);$i++){
            $sColumn = $aColumns[$i];
//        foreach ($aColumns as $i => $sColumn) {
            $sDisplayValue = self::compileDisplayValue($oModel, $sColumn, $aViewSettings, $aArrayVars, $sClass);
            if ($sDisplayValue === false){
                continue;
            }
            $sLabel = __($aViewSettings['sLangPrev'] . $sColumn, null, 2);
            $sClassForLabel = 'text-right col-xs-' . $sLabelWidth;
            echo "<tr>
                <th class=\"$sClassForLabel\">$sLabel</th>
                <td class=\"$sClass\">$sDisplayValue</td>
            </tr>\n";
        }
    }

    /**
     * 根据配置，返回给定的列的显示值
     *
     * @param model     $oModel         模型
     * @param array     $aColumns       要显示的列名
     * @param array     $aViewSettings  二维数组，包括所需要的各个列配置数组
     * @param array     $aArrayVars     二维数组，包括与模型列相关联的可选值数组
     * @param string    $sClass         显示类名
     * @return type
     */
    public static function compileDisplayValue($oModel, $sColumn, & $aViewSettings, & $aArrayVars, & $sClass){
        $sClass = '';
        $sOriginalValue = $oModel->$sColumn;
        $aSetting = $aViewSettings['aColumnSettings'][ $sColumn ];
        if (in_array($sColumn, $aViewSettings['aWeightFields'])) {
            $sClass .= ' text-weight';
        }
        if (in_array($sColumn, $aViewSettings['aClassGradeFields'])) {
            $sClass .= ' ' . ($sOriginalValue >= 0 ?  : 'text-red');
        }
        if (isset($aViewSettings['aViewColumnMaps'][$sColumn])) {
            $sDisplayValue = $oModel->{$aViewSettings['aViewColumnMaps'][$sColumn]};
        } else {
            $sDisplayValue = self::compileDisplayValueBySetting($sColumn, $sOriginalValue, $aSetting, $aViewSettings, $aArrayVars, $sSpecialClass);
        }

        $sDisplayMenu = mb_strlen($sDisplayValue) > 200;
        if ($sDisplayMenu === true && $sColumn == 'display_bet_number') {
            $id = str_replace('.', '_',$aViewSettings['sLangPrev'].$sColumn);

            $sDisplayValue = "
                <div class='long_content'>
                    <input type='text' id='$id' value='$sDisplayValue' style='position: absolute; opacity: 0; pointer-events: none;'>
                    <div class='handy_menus'><input class='_function_copy_menu_' type='button' value='复制' data-clipboard-target='#$id'><input class='_function_display_menu_' type='button' value='展开'></div>
                    <p class='content roll_back'>$sDisplayValue</p>
                </div>
            ";
        }
//        if ($sDisplayValue > 0 && !in_array($sColumn, $aViewSettings['aOriginalNumberColumns']) && array_key_exists($sColumn,$aViewSettings['aNumberColumns'])){
//            $sDisplayValue = number_format($sDisplayValue,$aViewSettings['aNumberColumns'][ $sColumn ]);
//        }
//        if ($sDisplayValue > 0 && !in_array($sColumn, $aViewSettings['aOriginalNumberColumns']) && array_key_exists($sColumn,$aViewSettings['aNumberColumns'])){
//            $sDisplayValue = number_format($sDisplayValue,$aViewSettings['aNumberColumns'][ $sColumn ]);
//        }
//        if (array_key_exists($sColumn, $aViewSettings['aNumberColumns']) && !array_key_exists($sColumn, $aViewColumnMaps)) {
//            $sDisplayValue = number_format($sDisplayValue, $aViewSettings['aNumberColumns'][$sColumn]);
//        }
        return $sDisplayValue;
    }

    /**
     * 根据列设置，返回指定值的显示值
     *
     * @param string    $sColumn        列名
     * @param string    $sOriginalValue 原始值
     * @param array     $aSetting       字段的设置
     * @param array     $aViewSettings  二维数组，包括所需要的各个列配置数组
     * @param array     $aArrayVars     二维数组，包括与模型列相关联的可选值数组
     * @return string
     */
    public static function compileDisplayValueBySetting($sColumn, $sOriginalValue,& $aSetting, & $aViewSettings, & $aArrayVars, & $sSpecialClass){
        $sDisplayValue = $sOriginalValue;
        if (isset($aSetting['type'])) {
            switch ($aSetting['type']) {
                case 'ignore':
                    return false;
                    break;
                case 'bool':
                    $sDisplayValue = $sOriginalValue ? __('Yes') : __('No');
                    break;
                case 'text':
                    $sDisplayValue = nl2br($sOriginalValue);
                    break;
                case 'select':
    //                $sDisplayValue = !is_null($sOriginalValue) ? ${$aSetting['options']}[$sOriginalValue] : null;
                    if (!is_null($sOriginalValue)){
                        if (isset($aArrayVars[$aSetting['options']][$sOriginalValue])){
                            $sDisplayValue = $aArrayVars[$aSetting['options']][$sOriginalValue];
                        }
                        else{
                            $sDisplayValue = null;
                        }
                    }
                    else{
                        $sDisplayValue = null;
                    }
//                    $sDisplayValue = !is_null($sOriginalValue) ? $aArrayVars[$aSetting['options']][$sOriginalValue] : null;
                    break;
                case 'numeric':
                case 'integer':
                    $sClass = 'text-right';
//                    $sDisplayValue = doubleval($sOriginalValue);
//                    pr($sColumn);
//                    pr($sDisplayValue);
                    if (!isset($aViewSettings['aNumberColumns'][$sColumn])){
                        $aViewSettings['aNumberColumns'][$sColumn] = $aViewSettings['iDefaultAccuracy'];
                    }
                    if (!in_array($sColumn, $aViewSettings['aOriginalNumberColumns']) && array_key_exists($sColumn,$aViewSettings['aNumberColumns'])){
//                        pr($sColumn);
                        $sDisplayValue = number_format($sOriginalValue,$aViewSettings['aNumberColumns'][ $sColumn ]);
                    }
//                    pr($sDisplayValue);
//                    if ($sColumn == 'registered_top_agent_count'){
//                        pr($aViewSettings['aNumberColumns']);
//                    }
                    break;
                case 'date':
                case 'datetime':
                default:
                    $sDisplayValue = is_array($sOriginalValue) ? implode(',',$sOriginalValue) : $sOriginalValue;
//                    $sDisplayValue = $sOriginalValue;
            }
        }
        else {
            $sDisplayValue = $sOriginalValue;
        }
        return $sDisplayValue;
    }

    /**
     * 根据给定的列数组，显示给定的模型数据，用于列表
     *
     * @param model     $oModel         模型
     * @param array     $aColumns       要显示的列名
     * @param array     $aViewSettings  二维数组，包括所需要的各个列配置数组
     * @param array     $aArrayVars     二维数组，包括与模型列相关联的可选值数组
     * @param integer   $sLabelWidth
     */
    public static function displayForIndex($oModel, & $aColumns, & $aViewSettings, & $aArrayVars, $aTotalColumns, $aTotalColumnMaps, & $aTotals){
        foreach ($aColumns as $i => $sColumn) {
//        for($i = 0;$i < count($aColumns);$i++){
            $sOriginalValue = $oModel->$sColumn;
            if ($aTotalColumns) {
                if (!is_null($aTotalColumnMaps[$sColumn])) {
                    $fResult = $oModel->is_income == '0' ? -$sOriginalValue : $sOriginalValue;
                    $aTotals[$aTotalColumnMaps[$sColumn]] += $fResult;
                }
            }
            $sColumn = $aColumns[$i];
            $sClass = '';

            if (isset($aViewSettings['aListColumnMaps'][ $sColumn ])){
                $sDisplayValue = $oModel->{$aViewSettings['aListColumnMaps'][ $sColumn ]};
            }
            else{
                if ($sColumn == 'sequence'){
                    $sDisplayValue = Form::text('sequence[' . $oModel->id . ']',$oModel->sequence,['class' => 'form-control input-xs','style' => 'width:50px;text-align:right']);
                }
                else{
                    if (isset($aViewSettings['aColumnSettings'][ $sColumn ])){
                        $aSetting = $aViewSettings['aColumnSettings'][ $sColumn ];
                        $sDisplayValue = self::compileDisplayValueBySetting($sColumn, $sOriginalValue, $aSetting, $aViewSettings, $aArrayVars, $sSpecialClass);
                    }
                    else{
                        $sDisplayValue = $sOriginalValue;
                    }
//                    if (isset($aColumnSettings[ $sColumn ][ 'type' ])){
//                        $sDisplayValue = $sColumn . $aColumnSettings[ $sColumn ][ 'type' ];
//                        switch ($aColumnSettings[ $sColumn ][ 'type' ]){
//                            case 'bool':
//                                $sDisplayValue = !is_null($sOriginalValue) ? ($sOriginalValue ? __('Yes') : __('No')) : null;
//                                break;
//                            case 'select':
//                                $sDisplayValue = !is_null($sOriginalValue) ? ${$aColumnSettings[ $sColumn ][ 'options' ]}[ $sOriginalValue ] : null;
//                                break;
//                            case 'numeric':
//                            case 'integer':
//                                $sClass = 'text-right';
//                                if (!isset($aViewSettings['aNumberColumns'][$sColumn])){
//                                    $aViewSettings['aNumberColumns'][$sColumn] = $iDefaultAccuracy;
//                                }
//                            default:
////                                            !is_numeric($sOriginalValue)) or $sClass = 'text-right'
//                                $sDisplayValue = is_array($sOriginalValue) ? implode(',',$sOriginalValue) : $sOriginalValue;
//                        }
//                    }
//                    else{
//                        $sDisplayValue = $sOriginalValue;
//                    }
    //                    if ($sDisplayValue > 0 && !in_array($sColumn, $aViewSettings['aOriginalNumberColumns']) && array_key_exists($sColumn,$aViewSettings['aNumberColumns'])){
    //                        $sDisplayValue = number_format($sDisplayValue,$aViewSettings['aNumberColumns'][ $sColumn ]);
    //                    }
                }
            }

            if (isset($aColumnSettings[ $sColumn ][ 'type' ]) && $aColumnSettings[ $sColumn ][ 'type' ] == 'numeric'){
                $sClass = 'text-right';
            }
            else{
                $sClass = 'text-center';
            }

            if (in_array($sColumn,$aViewSettings['aWeightFields'])){
                $sClass .= ' text-weight';
            }
            if (in_array($sColumn,$aViewSettings['aClassGradeFields'])){
                $sClass .= ' ' .  ($sOriginalValue >= 0 ? '' : 'text-red');
            }
            $aClassForColumns[$sColumn] = $sClass;
            echo "<td class='$sClass'";
            if (in_array($sColumn,$aViewSettings['aFloatDisplayFields'])){
                echo " title='{$sOriginalValue}'";
            }
            echo ">$sDisplayValue</td>";
        }
        ////        foreach ($aColumns as $i => $sColumn) {
//            $sDisplayValue = self::compileDisplayValue($oModel, $sColumn, $aViewSettings, $aArrayVars, $sClass);
//            if ($sDisplayValue === false){
//                continue;
//            }
//            $sLabel = __($aViewSettings['sLangPrev'] . $sColumn, null, 2);
//            $sClassForLabel = 'text-right col-xs-' . $sLabelWidth;
//            echo "<tr>
//                <th class=\"$sClassForLabel\">$sLabel</th>
//                <td class=\"$sClass\">$sDisplayValue</td>
//            </tr>\n";
//        }
    }

    /**
     * 用于资源列表的排序标签
     * @param  string $columnName 列名
     * @param  string $default    是否默认排序列，up 默认升序 down 默认降序
     * @return string             a 标签排序图标
     */
    static function orderBy($columnName = '', $default = null)
    {
        $sortColumnName = Input::get('sort_up', Input::get('sort_down', false));
        if (Input::get('sort_up')) {
            $except = 'sort_up'; $orderType = 'sort_down';
        } else {
            $except = 'sort_down' ; $orderType = 'sort_up';
        }
        if ($sortColumnName == $columnName) {
            $parameters = array_merge(Input::except($except), array($orderType => $columnName));
            $icon       = Input::get('sort_up') ? 'triangle-top' : 'triangle-bottom' ;
        } elseif ($sortColumnName === false && $default == 'asc') {
            $parameters = array_merge(Input::all(), array('sort_down' => $columnName));
            $icon       = 'triangle-top';
        } elseif ($sortColumnName === false && $default == 'desc') {
            $parameters = array_merge(Input::all(), array('sort_up' => $columnName));
            $icon       = 'triangle-bottom';
        } else {
            $parameters = array_merge(Input::except($except), array('sort_up' => $columnName));
            $icon       = 'resize-vertical';
        }
        // dd(Route::current()->getActionName());
        $a  = '<a href="';
        $a .= action(Route::current()->getActionName(), $parameters);
        // $a .= route(Route::currentRouteName(), $parameters);
        $a .= '" class="glyphicon glyphicon-'.$icon.'"></a>';
    //    pr($a);
    //    exit;
        return $a;
    }

    public static function compilePopupData($sJsOnClick, $aLangVars, $aConfig){
        $aMethods = Popup::getValidMethods();
        $aTypes = PopupItem::getValidTypes();
        $data = [
            'id' => $sJsOnClick,
            'title' => __($aConfig['title']),
            'action' => $aConfig['action'],
            'method' => $aMethods[$aConfig['method']],
        ];
        if ($aConfig['items']){
            $a = [];
            foreach($aConfig['items'] as $aItem){
                $sField = $aItem['field'];
//                pr($aItem['label']);
//                pr(__($aItem['label'],$aLangVars));
//                exit;
                $sLabel = __($aItem['label'], $aLangVars);
                switch(strtolower($aTypes[$aItem['type']])){
                    case 'none':
                        $sLabel = '';
                        $sHtml = __($aItem['label'], $aLangVars);
                        break;
                    case 'textarea':
                        $sHtml = '<textarea name="' . $sField . '" cols="50" rows="5"></textarea>';
                        break;
                    case 'text':
                        $sHtml = '<input type="text" name="' . $sField . '" />';
                }
                $a[] = join([
                    '<div class="form-group">',
                    '<label for="comment" class="col-sm-2 control-label"></label>',
                    '<div id="' . $sJsOnClick. '-data-id">a</div>',
                    '<label for="comment" class="col-sm-2 control-label">',
                    $sLabel,
                    '</label>',
                    '<div class="">',
                    $sHtml,
                    '</div>',
                    '</div>'
                ]);
            }
            $data['message'] = join($a);
        }
        else{
            $data['message'] = __($aConfig['title'],$aLangVars);
        }
        $data['footer'] =
            '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.cancel') . '</button>' .
            '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.confirm') . '</button>';
        return $data;
    }
}
