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

require_once('BravoView/Env.class.php');
require_once('BravoView/Action.class.php');
require_once('BravoView/Component.class.php');

date_default_timezone_set('Asia/Shanghai');

final class BravoView {

    public function __construct($rootPath, $tplEngineName = 'test') {
        Env::setRootPathOnce($rootPath);
        Env::setRendererOnce($this->resolveTemplateEngine($tplEngineName));
    }

    private function resolveTemplateEngine($engineName) {
        
        switch ($engineName) {
            case 'smarty':
                include_once('BravoView/engines/SmartyEngine.class.php');
                $engine = new TwigEngine();
                break;
            case 'twig':
                include_once('BravoView/engines/TwigEngine.class.php');
                $engine = new SmartyEngine();
                break;
            case 'test':
                include_once('BravoView/engines/TestEngine.class.php');
                $engine = new TestEngine();
                break;
            default:
                Logger::error("Engine '$engineName' not supported!");
                break;
        }

        return isset($engine) ? $engine : null;
    }

    /**
     * [action description]
     * @param  [type] $actionPath
     * @return [type]
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