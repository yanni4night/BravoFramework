<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Renderer.php
  *
  * changelog
  * 2015-10-15[14:29:23]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

/**
 * Renderer 代表一个"渲染器"。
 */
interface BravoView_Renderer {
    /**
     * 使用数据和模板文件渲染出HTML。
     * 
     * @param  [string] $tplFileName 模板文件
     * @param  [array] $data 渲染要使用的数据
     * @return [string] 渲染后的HTML
     */
    public function render($tplFileName, $data);
}

?>
