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

final class BravoView {

    public function __construct($rootPath) {
        Env::setRootPathOnce($rootPath);
    }

    /**
     * [action description]
     * @param  [type] $actionPath [description]
     * @return [type]             [description]
     */
    public function action($actionPath) {
        $action = explode(':', $actionPath);

        $actionScope = $action[0];
        $actionName = $action[1];

        $actionFile = Env::getRootPath() . "/$actionScope/actions/${actionName}/${actionName}.php";
        include($actionFile);
        $actionClassName = ucfirst("${actionName}");
        $action = new $actionClassName($actionScope, $actionName, null);
        echo $action->run();
    }
}

?>