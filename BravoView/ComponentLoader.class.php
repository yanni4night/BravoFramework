<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * ComponentLoader.class.php
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

require_once('BravoView/Loader.class.php');
require_once('BravoView/Env.class.php');
require_once('BravoView/Logger.class.php');

class ComponentLoader implements Loader {

    private $type = 'components';

    protected $scope = null;
    protected $name = null;

    protected function __construct($scope, $name) {
        $this->scope = $scope;
        $this->name = $name;
    }

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
    protected function getAbsTplFilePath() {
        $selfClassName = get_class($this);
        return Env::getRootPath() . "/{$this->scope}/{$this->type}/{$this->name}/" . $this->getTplFileName();
    }

    /**
     * [setType description]
     * @param [type] $type [description]
     */
    protected final function setType($type) {
        $this->type = $type;
    }

    /**
     * [find description]
     * @param  [string] $componentName
     * @return [Component]
     */
    public final function find($componentPath) {
        $componentScopeName = explode(':', $componentPath);

        $componentScope = $componentScopeName[0];
        $componentName = $componentScopeName[1];

        $componentFilePath = Env::getRootPath() . "/$componentScope/components/${componentName}/${componentName}.php";
        
        if(file_exists($componentFilePath)){
            include_once($componentFilePath);
            return array($componentScope, $componentName);
        }else {
            return null;
        }
    }
    /**
     * [load description]
     * @param  [string] $componentName
     * @param  [array] $componentName
     * @return [string]
     * @override_function(load, target)
     */
    public final function load($componentPath, $data) {
        $componentClass = $this->find($componentPath);
        if($componentClass) {
            $component = new $componentClass[1]($componentClass[0], $componentClass[1], $data);
            return $component->display();
        }else {
            Logger::warn("Component '$componentPath' not found!");
            return '';
        }
    }
}

?>