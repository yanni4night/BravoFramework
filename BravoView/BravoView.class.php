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
namespace BravoView;

require_once('BravoView/Env.class.php');
require_once('BravoView/Action.class.php');
require_once('BravoView/Component.class.php');

/**
 * BravoView代表一个 application,是框架的入口。
 */
final class BravoView {

    // 默认 acion
    private $defaultAction = 'Index:index';

    /**
     * 初始化 Bravo application。
     * 
     * @param [type] $rootPath      [description]
     * @param string $tplEngineName [description]
     */
    public function __construct($rootPath, $tplEngineName = 'test') {
        Env::setRootPathOnce($rootPath);
        Env::setRendererOnce($this->resolveTemplateEngine($tplEngineName));
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
                include_once('BravoView/engines/TwigEngine.class.php');
                $engine = new TwigEngine(dirname(__FILE__) . '/cache');
                break;
            case 'smarty':
                include_once('BravoView/engines/SmartyEngine.class.php');
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
     * 运行一个 action。
     * 
     * @param  [string] $actionPath action路径
     * @return [string] 页面HTML
     */
    public function action($actionPath, $data = array()) {
        $action = explode(':', $actionPath);

        $actionScope = $action[0];
        $actionName = $action[1];

        $actionFile = Env::getRootPath() . "/$actionScope/actions/${actionName}Action/${actionName}Action.php";
        
        if(file_exists($actionFile)) {
            include($actionFile);
            $actionClassPath = "\\$actionScope\\${actionName}Action";
            if(class_exists($actionClassPath)) {
                $action = new $actionClassPath($data);
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