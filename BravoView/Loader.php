<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Loader.php
  *
  * changelog
  * 2015-10-15[12:02:50]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/LoaderStack.php');

/**
 * Loader 代表资源 "加载器"。
 */
abstract class BravoView_Loader {

    // 父加载器
    private $loader;

    private $loaderStack;

    public function __construct($loader = NULL) {
      if(isset($loader) && is_object($loader) && $loader instanceof BravoView_Loader) {
            $this->loaderStack = $loader->getLoaderStack()->forward($this->getUniquePath());
      } else {
            $this->loaderStack = new BravoView_LoaderStack($this->getUniquePath());
      }

    }

    private function setLoader($loader) {
            $this->loader = $loader;
    }

    /**
     * 获取本 Component 的父加载器。
     *
     * 只有使用 load 方法加载的Component才有父加载器。
     * 
     * @return [Loader] 父加载器
     */
    public final function getLoader() {
        return $this->loader;
    }

    public final function getLoaderStack() {
        return $this->loaderStack;
    }

    /**
     * 加载一个资源。
     * 
     * @param  [string] $target 目标资源
     * @param  [mixin] $extra 额外参数
     * @return [mixin] 加载的资源
     */
    public abstract function load($target, $extra);

    /**
     * 返回一个标记该 Loader 的唯一字符串。
     * 
     * @return [string] 唯一串
     */
    protected abstract function getUniquePath();
}

?>
