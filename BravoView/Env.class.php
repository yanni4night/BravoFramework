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

require_once('BravoView/Renderer.class.php');

/**
 * Env 是一个环境单例类。
 */
final class BravoView_Env {
    
    private static $rootPath;
    private static $renderer;

    private function __construct(){}
    /**
     * 设置App的根路径。
     *
     * 2次及以上的调用视为无效。
     * 
     * @param [string] $rootPath 根路径。
     */
    public static function setRootPathOnce($rootPath) {
        if(!self::$rootPath && isset($rootPath) && is_string($rootPath)){
            self::$rootPath = $rootPath;
        }
    }

    /**
     * 设置全局 Renderer。
     *
     * 2次及以上的调用视为无效。
     * 
     * @param [Renderer] $renderer Renderer
     */
    public static function setRendererOnce($renderer) {
        if(!self::$renderer && isset($renderer) && $renderer instanceof BravoView_Renderer){
            self::$renderer = $renderer;
        }
    }

    /**
     * 获取 App 根路径。
     * 
     * @return [string] 根路径
     */
    public static function getRootPath() {
        return self::$rootPath;
    }

    /**
     * 获取全局 Renderer。
     * 
     * @return [Renderer] 全局Renderer
     */
    public static function getRenderer(){
        return self::$renderer;
    }

}
?>