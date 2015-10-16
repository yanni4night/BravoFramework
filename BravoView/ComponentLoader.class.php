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
namespace BravoView;

require_once('BravoView/Loader.class.php');
require_once('BravoView/Env.class.php');
require_once('BravoView/Logger.class.php');

class ComponentLoader implements Loader {

    private $type = 'components';

    private $scope = null;
    private $name = null;

    public function __construct(){}

    /**
     * [getTplFileName description]
     * @return [type] [description]
     */
    protected function getTplFileName() {
        $name = $this->getName();
        return "$name.tpl";
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
     * @override_function(load, target)
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

    public final function find($componentPath) {
        return Env::requireComponent($componentPath);
    }
}

?>