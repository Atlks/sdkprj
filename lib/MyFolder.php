<?php

class MyFolder {

    public static function createDir($sPath, $iMode) {
        return @mkdir($sPath,$iMode,TRUE) && @chmod($sPath, $iMode);
    }

}

