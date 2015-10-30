<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * BravoView.php
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

require_once('BravoView/Env.php');
require_once('BravoView/Action.php');
require_once('BravoView/Component.php');
require_once('BravoView/Pagelet.php');

/**
 * BravoView代表一个 application,是框架的入口。
 */
final class BravoView {

    // 默认 acion
    private $defaultAction = 'Index:Index';

    /**
     * 初始化 Bravo application。
     * 
     * @param [type] $rootPath      [description]
     * @param string $tplEngineName [description]
     */
    public function __construct($rootPath, $tplEngineName = 'test') {
        BravoView_Env::setRootPathOnce($rootPath);
        BravoView_Env::setRendererOnce($this->resolveTemplateEngine($tplEngineName));
    }

    /**
     * 初始化模板引擎。
     * 
     * @param  [string] $engineName 引擎名
     * @return [TemplateEngine] 引擎实例
     */
    private function resolveTemplateEngine($engineName) {
        
        switch ($engineName) {
            case 'twig':
                include_once('BravoView/engines/TwigEngine.php');
                $engine = new BravoView_TwigEngine(dirname(__FILE__) . '/cache');
                break;
            case 'smarty':
                include_once('BravoView/engines/SmartyEngine.php');
                $engine = new BravoView_SmartyEngine();
                break;
            case 'test':
                include_once('BravoView/engines/TestEngine.php');
                $engine = new BravoView_TestEngine();
                break;
            default:
                BravoView_Logger::error("Engine '$engineName' not supported!");
                break;
        }

        return isset($engine) ? $engine : null;
    }

    /**
     * 运行一个 action。
     * 
     * @param  [string] $actionPath action路径
     * @return [string] 页面HTML
     */
    public function action($actionPath, $data = array()) {
        $action = explode(':', $actionPath);

        $actionScope = ucfirst($action[0]);
        $actionName = ucfirst($action[1]);

        $actionFile = BravoView_Env::getRootPath() . "/$actionScope/actions/${actionName}/${actionName}.php";

        if(file_exists($actionFile)) {
            include_once($actionFile);
            $actionClassPath = "${actionScope}_${actionName}Action";

            if(class_exists($actionClassPath, False)) {
                $action = new $actionClassPath($actionScope, $actionName, $data);
                echo $action->run();
            } else {
                return $this->action($this->defaultAction, $data);
            }
        }else {
            return $this->action($this->defaultAction, $data);
        }
    }

    /**
     * 设置默认的action。
     * 
     * @param [string] $defaultAction 默认 action 的路径
     */
    public function setDefaultAction($defaultAction){
      $this->defaultAction = $defaultAction;
    }
}

?>
