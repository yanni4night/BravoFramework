<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Component.class.php
  *
  * changelog
  * 2015-10-15[15:42:58]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

require_once('BravoView/Loader.class.php');
require_once('BravoView/Env.class.php');
require_once('BravoView/Logger.class.php');

if(!defined('__DEPS__')) {
    define('__DEPS__', 1);
}

class Component implements Loader {

    private $initialData = null;

    // Compile '__DEPS__' to real dependencies array which contains
    // all the components' names.
    private $dependencies = __DEPS__;

    private $type = 'components';

    private $scope = null;
    private $name = null;

    public function __construct($data){
        $this->initialData = isset($data) && !empty($data) ? $data : array();
    }

    /**
     * [getTplFileName description]
     * @return [type] [description]
     */
    protected function getTplFileName() {
        $name = $this->getName();
        return "$name.tpl";
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
     * [getAbsTplFilePath description]
     * @return [string]
     */
    protected final function getAbsTplFilePath() {
        $name = $this->getName();
        $scope = $this->getScope();
        return Env::getRootPath() . "/$scope/{$this->type}/$name/" . $this->getTplFileName();
    }

    /**
     * [setType description]
     * @param [string] $type
     */
    protected final function setType($type) {
        $this->type = $type;
    }

    /**
     * [getName description]
     * @return [string]
     */
    public final function getName() {
        if(!$this->name) {
            $nameSections = explode("\\", get_class($this));
            $this->name = $nameSections[count($nameSections) - 1];
        }

        return $this->name;
    }

    /**
     * [getScope description]
     * @return [string]
     */
    public final function getScope() {
        if(!$this->scope) {
            $this->scope = preg_replace(array("/\\\\\w+$/", "/\\\\/"), array('', '/'), get_class($this));
        }

        return $this->scope;
    }

    /**
     * [load description]
     * @param  [string] $componentName
     * @param  [array] $componentName
     * @return [string]
     * @override_function(load, Loader)
     */
    public final function load($componentPath, $data) {
        $componentClass = $this->find($componentPath);
        if($componentClass) {
            $component = new $componentClass($data);
            return $component->display();
        }else {
            Logger::warn("Component '$componentPath' not found!");
            return '';
        }
    }

    /**
     * 
     * @param  [string] $componentPath component path
     * @return [string] component class name with namespace
     * @override_function(find, Loader)
     */
    public final function find($componentPath) {
        return Env::requireComponent($componentPath);
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