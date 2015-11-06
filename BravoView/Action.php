<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Action.php
  *
  * changelog
  * 2015-10-15[15:15:05]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once 'BravoView/Module.php';

/**
 * Action 指一个页面的入口模块。
 */
abstract class BravoView_Action extends BravoView_Module{

    public function __construct($namespace, $name, $data, $loader) {
        parent::__construct($namespace, $name, $data, $loader, 'Action');
    }

    public final function formatDisplay() {
        $content = $this->display();
        BravoView_PageletHub::getInstance()->notifyPageComplete();
        return $content;
    }

    protected final function getSubModuleType() {
        return 'Pagelet';
    }
}

?>
