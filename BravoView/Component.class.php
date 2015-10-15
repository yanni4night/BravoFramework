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

require_once('BravoView/Renderer.class.php');
require_once('BravoView/ComponentLoader.class.php');
require_once('BravoView/Logger.class.php');

if(!defined('__DEPS__')) {
    define('__DEPS__', 1);
}

abstract class Component extends ComponentLoader {

    protected $renderer;

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
     * @return [type]
     */
    private function resolveTemplateEngine() {
        $engineName = $this->getTemplateEngineName();
        
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

        if(isset($engine)){
            $this->renderer = $engine;
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
        return $this->renderer->render($this->getAbsTplFilePath(), 
                $this->getTplData());
    }

}

?>