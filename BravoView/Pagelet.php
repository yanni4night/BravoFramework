<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Pagelet.php
  *
  * changelog
  * 2015-10-30[15:45:46]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/Component.php');
require_once('BravoView/Env.php');
require_once('BravoView/Logger.php');

/**
 * BigPipe 概念
 */
class BravoView_Pagelet extends BravoView_Component {

    public function __construct($namespace, $name, $data) {
        parent::__construct($namespace, $name, array());
    }

    /**
     * 仅允许获取 Component，而不是 Action 和 Pagelet。
     * 
     * @param  [string] $componentPath 目标 Component 路径
     * @return [string] 目标 Component 类名
     */
    public function requires($componentPath) {
        return parent::requireComponent($componentPath, 'components');
    }

    /*public function display() {
        $finalTplData = array_merge(array('__self' => $this), $this->initialData, $this->getTplData());
        return BravoView_Env::getRenderer()->render($this->getAbsTplFilePath(), $finalTplData);
    }*/

}

?>