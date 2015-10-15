<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Env.class.php
  *
  * changelog
  * 2015-10-15[15:48:52]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>

<?php

final class Env {
    
    private static $rootPath;

    /**
     * [setRootPathOnce description]
     * @param [string] $rootPath
     */
    public static function setRootPathOnce($rootPath) {
        if(!self::$rootPath && is_string($rootPath)){
            self::$rootPath = $rootPath;
        }
    }

    /**
     * [getRootPath description]
     * @return [string]
     */
    public static function getRootPath() {
        return self::$rootPath;
    }
}
?>