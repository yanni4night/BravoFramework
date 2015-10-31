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
require_once('BravoView/Exception.php');

/**
 * BravoView代表一个 application,是框架的入口。
 */
final class BravoView extends BravoView_Component {

    // 默认 acion
    private $defaultAction = 'Index:Index';

    /**
     * 初始化 Bravo application。
     * 
     * @param [type] $rootPath
     * @param string $tplEngineName
     */
    public function __construct($rootPath, $tplEngineName = 'test') {
        parent::__construct('BravoView', 'BravoView', NULL, NULL, 'BravoView');
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
     * 执行一个 action。
     *
     * 如果不存在，则执行默认 Action。默认 Action 也不存在，
     * 则抛出异常。
     * 
     * @param  [string] $actionPath action路径
     * @return [string] 页面HTML
     * @throws [Bravo_Exception] Action 不存在
     */
    public function action($actionPath, $data = array()) {
        $componentDescriptor = $this->resolveComponentDescriptor($actionPath, $this->getAllowedSubComponentType());
        
        if($componentDescriptor->exists()) {
            echo $this->load($actionPath, $data);
            return;
        }

        // Lookup default action
        $componentDescriptor = $this->resolveComponentDescriptor($this->defaultAction);

        if($componentDescriptor->exists()) {
            echo $this->load($this->defaultAction, $data);
            return;
        }

        // Even default action does not exist
        throw new BravoView_Exception("Neither $actionPath nor " . $this->defaultAction . ' does exist', 1);
    }

    /**
     * @override
     */
    protected function getAllowedSubComponentType() {
        return 'Action';
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
