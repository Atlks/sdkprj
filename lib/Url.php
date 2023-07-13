<?php
class Url {
    static function build_url($aParts){
        $sUrl = '';
        !isset($aParts['scheme']) or $sUrl .= $aParts['scheme'] . '://';
        !isset($aParts['host']) or $sUrl .= $aParts['host'];
        if (isset($aParts['port']) && $aParts['port'] != 80){
            $sUrl .= ':' . $aParts['port'];
        }
        !isset($aParts['path']) or $sUrl .= $aParts['path'];
        return $sUrl;
    }
    
    static function reload($sName = ''){
        echo "<script language='javascript'>\n";
        $sName or $sName = 'window';
        echo "$sName.location.reload();\n</script>\n";
        ob_flush();
        flush();
    }

}
