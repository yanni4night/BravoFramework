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

require_once('BravoView/Component.php');

/**
 * Action 指一个页面的入口模块。
 */
abstract class BravoView_Action extends BravoView_Component {

    public function __construct($namespace, $name, $data) {
        parent::__construct($namespace, $name, $data, 'Action');
    }

    /**
     * 输出页面所有HTML。
     * 
     * @return [string] 页面HTML
     */
    public final function run() {
        return $this->display();
    }

    protected final function getAllowedSubComponentType() {
        return 'Pagelet';
    }
}

?>
