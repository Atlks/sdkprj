<?php

/*
  |--------------------------------------------------------------------------
  | 复写官方函数
  |--------------------------------------------------------------------------
  |
  | 官方函数库路径
  | Illuminate/Support/helpers.php
  |
 */

/**
 * Generate a URL to a named route.
 *
 * @param  string  $route
 * @param  string  $parameters
 * @return string
 */
// function route($route, $parameters = array())
// {
//     if (Route::getRoutes()->hasNamedRoute($route))
//         return app('url')->route($route, $parameters);
//     else
//         return 'javascript:void(0)';
// }

/**
 * Generate a HTML link to a named route.
 *
 * @param  string  $name
 * @param  string  $title
 * @param  array   $parameters
 * @param  array   $attributes
 * @return string
 */
// function link_to_route($name, $title = null, $parameters = array(), $attributes = array())
// {
//     if (Route::getRoutes()->hasNamedRoute($name))
//         return app('html')->linkRoute($name, $title, $parameters, $attributes);
//     else
//         return '<a href="javascript:void(0)"'.HTML::attributes($attributes).'>'.$name.'</a>';
// }


/*
  |--------------------------------------------------------------------------
  | 延伸自拓展配置文件
  |--------------------------------------------------------------------------
  |
 */

/**
 * 样式别名加载（支持批量加载）
 * @param  string|array $aliases    配置文件中的别名
 * @param  array        $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function style($aliases, $attributes = array(), $interim = '') {
    if (is_array($aliases)) {
        foreach ($aliases as $key => $value) {
            $interim .= (is_int($key)) ? style($value, $attributes, $interim) : style($key, $value, $interim);
        }
        return $interim;
    }
    $cssAliases = Config::get('extend.webAssets.cssAliases');
    $url        = isset($cssAliases[$aliases]) ? $cssAliases[$aliases] : $aliases;
    return HTML::style($url, $attributes);
}

/**
 * 脚本别名加载（支持批量加载）
 * @param  string|array $aliases    配置文件中的别名
 * @param  array        $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function script($aliases, $attributes = array(), $interim = '') {
    if (is_array($aliases)) {
        foreach ($aliases as $key => $value) {
            $interim .= (is_int($key)) ? script($value, $attributes, $interim) : script($key, $value, $interim);
        }
        return $interim;
    }
    $jsAliases = Config::get('extend.webAssets.jsAliases');
    $url       = isset($jsAliases[$aliases]) ? $jsAliases[$aliases] : $aliases;
    return HTML::script($url, $attributes);
}

/**
 * 脚本别名加载（补充）用于 js 的 document.write(）中
 * @param  string $aliases    配置文件中的别名
 * @param  array  $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function or_script($aliases, $attributes = array()) {
    $jsAliases         = Config::get('extend.webAssets.jsAliases');
    $url               = isset($jsAliases[$aliases]) ? $jsAliases[$aliases] : $aliases;
    $attributes['src'] = URL::asset($url);
    return "'<script" . HTML::attributes($attributes) . ">'+'<'+'/script>'";
}

/*
  |--------------------------------------------------------------------------
  | 自定义核心函数
  |--------------------------------------------------------------------------
  |
 */

/**
 * 批量定义常量
 * @param  array  $define 常量和值的数组
 * @return void
 */
function define_array($define = array()) {
    foreach ($define as $key => $value)
        defined($key) OR define($key, $value);
}

/**
 * 友好的日期输出
 * @param  string|\Carbon\Carbon $theDate 待处理的时间字符串 | \Carbon\Carbon 实例
 * @return string                         友好的时间字符串
 */
function friendly_date($theDate) {
    // 获取待处理的日期对象
    if (!$theDate instanceof \Carbon\Carbon)
        $theDate            = \Carbon\Carbon::createFromTimestamp(strtotime($theDate));
    // 取得英文日期描述
    $friendlyDateString = $theDate->diffForHumans(\Carbon\Carbon::now());
    // 本地化
    $friendlyDateArray  = explode(' ', $friendlyDateString);
    $friendlyDateString = $friendlyDateArray[0]
        . Lang::get('friendlyDate.' . $friendlyDateArray[1])
        . Lang::get('friendlyDate.' . $friendlyDateArray[2]);
    // 数据返回
    return $friendlyDateString;
}

/**
 * 拓展分页输出，支持临时指定分页模板
 * @param  Illuminate\Pagination\Paginator $paginator 分页查询结果的最终实例
 * @param  string                          $viewName  分页视图名称
 * @return \Illuminate\View\View
 */
function pagination(Illuminate\Pagination\Paginator $paginator, $viewName = null) {
    $viewName = $viewName ?: Config::get('view.pagination');
    $paginator->getEnvironment()->setViewName($viewName);
    return $paginator->links();
}

/**
 * 反引用一个经过 e（htmlentities）和 addslashes 处理的字符串
 * @param  string $string 待处理的字符串
 * @return 转义后的字符串
 */
function strip($string) {
    return stripslashes(HTML::decode($string));
}

/*
  |--------------------------------------------------------------------------
  | 公共函数库
  |--------------------------------------------------------------------------
  |
 */

/**
 * 闭合 HTML 标签 （此函数仍存在缺陷，无法处理不完整的标签，暂无更优方案，慎用）
 * @param  string $html HTML 字符串
 * @return string
 */
function close_tags($html) {
    // 不需要补全的标签
    $arr_single_tags = array('meta', 'img', 'br', 'link', 'area');
    // 匹配开始标签
    preg_match_all('#<([a-z1-6]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags      = $result[1];
    // 匹配关闭标签
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags      = $result[1];
    // 计算关闭开启标签数量，如果相同就返回html数据
    if (count($closedtags) === count($openedtags))
        return $html;
    // 反向排序数组，将最后一个开启的标签放在最前面
    $openedtags      = array_reverse($openedtags);
    // 遍历开启标签数组
    foreach ($openedtags as $key => $value) {
        // 跳过无需闭合的标签
        if (in_array($value, $arr_single_tags))
            continue;
        // 开始补全
        if (in_array($value, $closedtags)) {
            unset($closedtags[array_search($value, $closedtags)]);
        } else {
            $html .= '</' . $value . '>';
        }
    }
    return $html;
}

// TODO 如果前台列表需要排序，可以启用该函数
// function custom_order_by($columnName = '', $default = null) {
//     $sortColumnName = Input::get('sort_up', Input::get('sort_down', false));
//     if (Input::get('sort_up')) {
//         $except = 'sort_up'; $orderType = 'sort_down';
//     } else {
//         $except = 'sort_down' ; $orderType = 'sort_up';
//     }
//     if ($sortColumnName == $columnName) {
//         $parameters = array_merge(Input::except($except), array($orderType => $columnName));
//         $icon       = Input::get('sort_up') ? 'ico-up-current' : 'ico-down-current';
//     } elseif ($sortColumnName === false && $default == 'asc') {
//         $parameters = array_merge(Input::all(), array('sort_down' => $columnName));
//         $icon       = 'ico-down-current';
//     } elseif ($sortColumnName === false && $default == 'desc') {
//         $parameters = array_merge(Input::all(), array('sort_up' => $columnName));
//         $icon       = 'ico-up-current';
//     } else {
//         $parameters = array_merge(Input::except($except), array('sort_up' => $columnName));
//         $icon       = 'ico-up-down';
//     }
//     $a  = '<a href="';
//     $a .= action(Route::current()->getActionName(), $parameters);
//     $a .= '"><i class="' . $icon . '"></i></a>';
//     return $a;
// }

/**
 * 创建父节点树形数组
 * 参数 $ar 数组，邻接列表方式组织的数据 $id 数组中作为主键的下标或关联键名 $pid 数组中作为父键的下标或关联键名
 * 返回 多维数组
 * */
function find_parent($ar, $id = 'id', $pid = 'pid') {
    foreach ($ar as $v)
        $t [$v [$id]] = $v;
    foreach ($t as $k => $item) {
        if ($item [$pid]) {
            if (!isset($t [$item [$pid]] ['parent'] [$item [$pid]]))
                $t [$item [$id]] ['parent'] [$item [$pid]] = & $t [$item [$pid]];
        }
    }

    return $t;
}

/**
 * * 创建子节点树形数组 * 参数 * $ar 数组，邻接列表方式组织的数据 * $id 数组中作为主键的下标或关联键名 * $pid
 * 数组中作为父键的下标或关联键名 * 返回 多维数组 *
 */
function find_child($ar, $id = 'id', $pid = 'pid') {
    foreach ($ar as $v)
        $t [$v [$id]] = $v;
    foreach ($t as $k => $item) {
        if ($item [$pid]) {
            $t [$item [$pid]] ['child'] [$item [$id]] = & $t [$k];
        }
    }

    return $t;
}

/**
 * 翻译
 * @param string $key
 * @param array $replace
 * @param int $uc_type      1: 首字母大写； 2：全部单词首字母大写；3：先将slug格式转换为自然语言格式，再全部单词首字母大写
 * @param string $locale    语言代码
 * @return string
 */
function __($key, $replace = array(), $uc_type = 1, $locale = 'zh-CN') {
//    $pre = 'transfer.';
    !empty($replace) or $replace   = [];
    $aKeyParts = explode('.', $key);
    if (count($aKeyParts) > 1) {
        list($sFile, $sKey) = $aKeyParts;
    } else {
        $sFile = '_basic';
        $sKey  = $aKeyParts[0];
        $key   = $sFile . '.' . $sKey;
    }
    $key = strtolower($key);
    $str = Lang::get($key, $replace, $locale);

    $str != $key or $str = String::humenlize($sKey);
    if ($uc_type > 0) {
        switch ($uc_type) {
            case 1:
                $str = ucfirst($str);
                break;
            case 2:
                $str = ucwords($str);
                break;
            case 3:
                $str = String::humenlize($str);
                $str = ucwords($str);
        }
//        $function = $uc_type == 1 ? 'ucfirst' : 'ucwords';
//        $str = $function($str);
    }
//    $str = Str::slug($str);
    return $str;
}

function yes_no($val) {
    return __((boolean) $val ? 'Yes' : 'No');
}

function pr($val) {
    $bCli   = php_sapi_name() == 'cli';
    $prefix = $bCli ? "\n" : '<pre>';
    $suffix = $bCli ? "\n" : '</pre>';
    if (Config::get('app.debug')) {
        echo $prefix;
        print_r($val);
        echo $suffix;
    }
}

function useclass() {
    $args = func_get_args();
    foreach ($args as $file) {
        require_once(app_path() . '/lib/' . $file . '.php');
    }
}

function trimArray($array) {
    $data = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $data[$key] = trimArray($value);
        } else {
            $data[$key] = trim($value);
        }
    }
    return $data;
}

function objectToArray($d) {
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

function arrayToObject($array) {
    if (!is_array($array)) {
        return $array;
    }

    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name => $value) {
            $name = strtolower(trim($name));
            // pr(!empty($name));exit;
            if (isset($name)) {
                $object->$name = arrayToObject($value);
            }
        }
        return $object;
    } else {
        return FALSE;
    }
}

function formatNumber($number, $decimal = 4) {
    $number = str_replace(',', '', $number);
    return number_format($number, $decimal, '.', '');
}

function mapToArray($aObject, $sValueName = 'name') {
    $aArr = [];
    // if ($aObject[0]->username == 'Agent') {
    //     pr($aObject);exit;
    // }
    foreach ($aObject as $key => $oObject) {
        $aArr[$oObject->id] = $oObject->{$sValueName};
    }
    return $aArr;
}

function outputMessage($sMsg) {
    echo "$sMsg<br />\n";
    ob_flush();
    flush();
}
