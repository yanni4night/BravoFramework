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

const CONPONENT_ROOT = '/components/';

class ComponentLoader implements Loader {

    /**
     * [find description]
     * @param  [string] $componentName
     * @return [Component]
     */
    public final function find($componentName) {
        $componentFilePath = Env::getRootPath() . CONPONENT_ROOT . "${componentName}/${componentName}.php";
        if(file_exists($componentFilePath)){
            include_once($componentFilePath);
            return $componentName;
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
    public final function load($componentName, $data) {
        $componentClass = $this->find($componentName);
        if($componentClass) {
            $component = new $componentClass($data);
            return $component->display();
        }else {
            $this->logger->warn("Component '$componentName' not found!");
            return '';
        }
    }
}

?>