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

require('TemplateEngine.class.php');
require('Loader.class.php');
require('Logger.class.php');

if(!defined('__DEPS__')) {
    define('__DEPS__', array());
}

abstract class Component implements Loader{

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
    public function __construct($data){
        $this->initialData = isset($data) && !empty($data) ? $data : array();
    }

    /**
     * [getTemplateEngine description]
     * @return [type] [description]
     */
    protected abstract function getTemplateEngine();

    /**
     * [getTplFileName description]
     * @return [type] [description]
     */
    protected function getTplFileName() {
        return 'tpl.tpl';
    }

    /**
     * [getAbsTplFilePath description]
     * @return [string]
     */
    protected final function getAbsTplFilePath() {
        return dirname(__FILE__) . '/' . $this->getTplFileName();
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
     * [render description]
     * 
     * @return [string] HTML
     */
    public final function render(){
        return $this->templateEngine->render($this->getAbsTplFile(), 
                $this->getTplData());
    }

    /**
     * [find description]
     * @param  [string] $componentName
     * @return [Component]
     */
    public final function find($componentName) {

    }
    /**
     * [load description]
     * @param  [string] $componentName
     * @param  [array] $componentName
     * @return [string]
     * @override_function(load, target)
     */
    public final function load($componentName, $data) {
        $componentClass = $this->find($componentName);
        if($componentClass) {
            $component = new $componentClass($data);
            return $component->render();
        }else {
            $this->logger->warn('Component "$componentName" not found!');
            return '';
        }
    }

}

?>