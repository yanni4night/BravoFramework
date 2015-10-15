<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Component.class.php
  *
  * changelog
  * 2015-10-15[11:46:48]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/TemplateEngine.class.php');
require_once('BravoView/engines/SmartyEngine.class.php');
require_once('BravoView/engines/TwigEngine.class.php');
require_once('BravoView/engines/TestEngine.class.php');
require_once('BravoView/TemplateEngine.class.php');
require_once('BravoView/ComponentLoader.class.php');
require_once('BravoView/Logger.class.php');

if(!defined('__DEPS__')) {
    define('__DEPS__', 1);
}

abstract class Component extends ComponentLoader {

    // We use a template engine like 'Twig','Smarty' to render HTML.
    protected $templateEngine;

    private $initialData = null;

    private $logger = null; //TODO:init

    // Compile '__DEPS__' to real dependencies array which contains
    // all the components' names.
    private $dependencies = __DEPS__;

    /**
     * [__construct description]
     * @param [array] $data
     */
    public function __construct($scope, $name, $data){
        parent::__construct($scope, $name);
        $this->initialData = isset($data) && !empty($data) ? $data : array();
        // init engine
        $this->resolveTemplateEngine();
    }

    /**
     * TODO:
     * @return [type] [description]
     */
    private function resolveTemplateEngine() {
        $engineName = $this->getTemplateEngineName();
        
        switch ($engineName) {
            case 'twig':
                $engine = new TwigEngine();
                break;
            case 'smarty':
                $engine = new SmartyEngine();
                break;
            case 'test':
                $engine = new TestEngine();
                break;
            default:
                Logger::error("Engine '$engineName' not supported!");
                break;
        }

        if(isset($engine)){
            $this->templateEngine = $engine;
        }
    }

    /**
     * [getTemplateEngine description]
     * @return [string] [description]
     */
    protected function getTemplateEngineName() {
        return 'test';// or 'twig'
    }

    /**
     * You should override it to define the data 
     * your template use.
     * 
     * TODO:merge data
     * 
     * @return [array]
     */
    protected function getTplData(){
        return $this->initialData;
    }

    /**
     * [display description]
     * 
     * @return [string] HTML
     */
    public function display(){
        return $this->templateEngine->render($this->getAbsTplFilePath(), 
                $this->getTplData());
    }

}

?>