<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Loader.class.php
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

/**
 * Loader 代表资源 "加载器"。
 */
interface BravoView_Loader {
    /**
     * 加载一个资源。
     * 
     * @param  [string] $target 目标资源
     * @param  [mixin] $extra 额外参数
     * @return [mixin] 加载的资源
     */
    public function load($target, $extra);
}

?>