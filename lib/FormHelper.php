<?php

class FormHelper
{
    public $classes = [];
    public $errors;
//    public $columnSettings;
//    public $attributes;
    public $modelName;
    protected $model;
    public $dateObjects;
    public $langPrev;

    public function setClass($aClasses) {
        $this->classes = $aClasses;
    }

    public function setLangPrev($sLangPrev) {
        $this->langPrev = $sLangPrev;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function setErrorObject($oErrors) {
        $this->errors = $oErrors;
    }

    public function input($name, $value = null, $options = [], $inputClass = '') {
        $sModelName = get_class($this->model);
        if (is_null($value) && is_object($this->model)){
            $value = $this->model->$name;
        }
        $type = isset($options['type']) ? $options['type'] : $this->model->columnSettings[$name]['form_type'];
        // label
        $bLabel = (isset($options['label']) && !$options['label']) ? false : true;
        // empty for select object
        $sEmpty = isset($options['empty']) ? $options['empty'] : false;
        // todo: get require
        $bDiv = (isset($options['div']) && !$options['div']) ? false : true;
        $bMessage = (isset($options['message']) && !$options['message']) ? false : true;
        $sHtml = '';
        !$bDiv or $sHtml .= $this->openDiv($this->classes['div']);
        if ($bLabel) {
            $sLabel = isset($options['label']) ? $options['label'] : $name;
            $sLabel = __($this->langPrev . $sLabel, null, 2);
            $bRequired = isset($this->model->columnSettings[$name]['required']) ? $this->model->columnSettings[$name]['required'] : false;
            $sHtml .= $this->makeLabel($name, $sLabel, $bRequired);
        }
        !$bDiv or $sHtml .= $this->openDiv($this->classes['input_div']);
        switch ($type) {
            case 'text':
                isset($options['class']) or $options['class'] = $this->classes['input'] . $inputClass;
                $sHtml .= Form::input($type, $name, $value, $options);
                break;
            case 'textarea':
                $sHtml .= Form::textarea($name, $value, $options);
                break;
            case 'select':
                isset($options['class']) or $options['class'] = $this->classes['select'];
                if (isset($options['empty'])) {

                    $sEmptyValue = $options['empty'] === true ? null : $options['empty'];
                    $aSelectOptions[null] = $sEmptyValue;
                    foreach ($options['options'] as $sTmpkey => $sTmpValue) {
                        $aSelectOptions[$sTmpkey] = $sTmpValue;
                    }
                    unset($sTmpkey, $sTmpValue);
                } else {
                    $aSelectOptions = & $options['options'];
                }

                $aOptions = ['id' => $name, 'class' => 'form-control ' . $inputClass];
                if (isset($options['style'])){
                    $aOptions['style'] = $options['style'];
                }

                if (isset($options['readonly'])) {
                    $aOptions['disabled'] = $options['readonly'];
                }

                if (isset($options['multiple']) && $options['multiple']) {

                    !is_null($value) or $value = $this->model->$name;
                    $aValues = $value ? explode(',', $value) : [];

                    $old_model = $this->model;
                    unset($this->model);
                    foreach ($aSelectOptions as $v => $text) {
                        if ($v == ''){
                            continue;
                        }
                        $oTmpOptions = in_array($v, $aValues) ? ['checked' => 'checked'] : [];
                        $sHtml .= '<li>' . Form::input('checkbox', $name . '[]', $v, $oTmpOptions) . ' ' . $text . '</li>';
                    }
                    $this->model = $old_model;
                }
                else {
                    $sHtml .= Form::select($name, $aSelectOptions, $value, $aOptions);
                }
                break;
            case 'bool':
                isset($options['class']) or $options['class'] = $this->classes['radio'];
                $sHtml .= $this->makeRadio($name, $value, $options);
                break;
            case 'date':
//                die($value);
                $sHtml .= $this->makeDate($name, $value, $options, $inputClass);
                break;
            case 'datetime':
//                die($value);
                $sHtml .= $this->makeDatetime($name, $value, $options, $inputClass);
                break;
//                die($sHtml);
        }
        !$bDiv or $sHtml .= $this->closeDiv();
        !$bMessage or $sHtml .= $this->makeMessage($name);
        !$bDiv or $sHtml .= $this->closeDiv();
//                die($sHtml);
        return $sHtml;
    }

    function makeRadio($name, $value, $options = []) {
        //$sHtml = '<div class="' . $this->classes['radio_div'] . '" >';
        // $on = ($value ) ? true : false;
        $sHtml = Form::checkbox($name, 1, $value, $options);
        // $sHtml = '<input type="checkbox" data-checkbox name="'.$name.'" id="'.$name.'" value="'.$value.' 1"  '.$on.' checked="'.$on.'"/>';
        // pr($name);
        // exit;
        //$sHtml .='</div>';
        return $sHtml;
    }

    function makeDate($name, $value, $options, $inputClass) {

        $sHtml = '<input type="text"  class="form-control boot-day ' . $this->classes['date'] . $inputClass . '"  name="' . $name . '" value="' . $value . '" >';

        return $sHtml;
    }

    function makeDatetime($name, $value, $options, $inputClass) {
        $sHtml = '<input type="text"  class="form-control boot-time ' . $this->classes['date'] . $inputClass . '"  name="' . $name . '" value="' . $value . '" >';
        // $sHtml = '<div class="' . $this->classes['date'] . '" data-date="' . $value . '" data-date-format="yyyy-mm-dd hh:ii" data-link-format="yyyy-mm-dd hh:ii" data-link-field="' . $name . '" style="width:215px">';
        // $sHtml .= '<input class="form-control" size="16" type="text" value="' . $value . '">
        // <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        // $sHtml .= '<input type="hidden" id="' . $name . '" name="' . $name . '" value="' . $value . '" />';
        return $sHtml;
    }

    function makeLabel($sFor, $sLable, $bRequired = false, $sClass = null, $bDiv = false, $sDivClass = null) {
//        $sHtml = '<label for="' . $sFor . '"';
        $sHtml = $bDiv ? $this->openDiv($sDivClass) : '';
        !is_null($sClass) or $sClass = $this->classes['label'];
        $sRequired = $bRequired ? '*' : '';
        $sHtml .= Form::label($sFor, $sRequired . __(String::humenlize($sLable)), ['class' => $sClass]);
        !$bDiv or $sHtml .= $this->closeDiv();
//        pr($sHtml);
//        exit;
        return $sHtml;
    }

    function makeInput() {

    }

    function makeMessage($sObjName) {
// <div class="col-sm-4">
//        {{ $errors->first('parent_id', '<label class="text-danger control-label">:message</label>') }}
//    </div>
        $sHtml = $this->openDiv($this->classes['msg_div']);
        $sLabelHtml = $this->makeLabel($sObjName, ':message', false, $this->classes['msg_label'], false);
//        pr($this->errors);
        $sHtml .= $this->errors->first($sObjName, $sLabelHtml);
        $sHtml .= $this->closeDiv();
        return "\n" . $sHtml . "\n";
    }

    function openDiv($sClass = null) {
        $sHtml = "\n" . '<div';
        empty($sClass) or $sHtml .= ' class="' . $sClass . '"';
        $sHtml .= '>';
        return $sHtml . "\n";
    }

    function closeDiv() {
        return '</div>' . "\n";
    }

}
