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
namespace BravoView;

final class Env {
    
    private static $rootPath;
    private static $renderer;

    /**
     * [setRootPathOnce description]
     * @param [string] $rootPath
     */
    public static function setRootPathOnce($rootPath) {
        if(!self::$rootPath && isset($rootPath) && is_string($rootPath)){
            self::$rootPath = $rootPath;
        }
    }

    /**
     * [setRendererOnce description]
     * @param [Renderer] $renderer
     */
    public static function setRendererOnce($renderer) {
        if(!self::$renderer && isset($renderer)){
            self::$renderer = $renderer;
        }
    }

    /**
     * [getRootPath description]
     * @return [string]
     */
    public static function getRootPath() {
        return self::$rootPath;
    }

    /**
     * [getRenderer description]
     * @return [Renderer]
     */
    public static function getRenderer(){
        return self::$renderer;
    }
}
?>