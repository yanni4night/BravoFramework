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

    private $initialData = null;

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
        return Env::getRenderer()->render($this->getAbsTplFilePath(), 
                $this->getTplData());
    }

}

?>