<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * BravoView.class.php
  *
  * changelog
  * 2015-10-15[15:13:06]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/Action.class.php');
require_once('BravoView/Component.class.php');
require_once('BravoView/Env.class.php');

const CONTROLLER_ROOT = '/actions/';

final class BravoView {

    public function __construct($rootPath) {
        Env::setRootPathOnce($rootPath);
    }

    /**
     * [action description]
     * @param  [type] $actionName [description]
     * @return [type]             [description]
     */
    public function action($actionName) {
        $actionFile = Env::getRootPath() . CONTROLLER_ROOT ."/${actionName}Action.php";
        include($actionFile);
        $actionClassName = ucfirst("${actionName}Action");
        $action = new $actionClassName(null);
        echo $action->run();
    }
}

?>