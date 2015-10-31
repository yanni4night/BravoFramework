<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Component.php
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

require_once('BravoView/Loader.php');
require_once('BravoView/ComponentDescriptor.php');
require_once('BravoView/Env.php');
require_once('BravoView/Exception.php');
require_once('BravoView/Logger.php');

/**
 * Component 代表模块化的实体。它拥有以下功能：
 * 
 * 1. 利用数据和模板输出HTML;
 * 2. 调用其它 Component;
 * 
 */
class BravoView_Component extends BravoView_Loader {

    // 数据
    private $initialData;

    // 描述符
    private $componentDescriptor;

    /**
     * 构造一个 Component。
     * 
     * @param [array] $data 初始数据
     */
    public function __construct($namespace, $name, $data, $loader, $type = 'Component') {
        $this->initialData = isset($data) && is_array($data) && !empty($data) ? $data : array();
        $this->componentDescriptor = new BravoView_ComponentDescriptor($namespace, $name, $type);
        parent::__construct($loader);
    }

    /**
     * 获取模版名，仅支持一个文件。
     *
     * 默认查找与该 Component 同名的文件，后缀"tpl"，
     * 覆写该方法用于使用其它文件。
     * 
     * @return [string] 模板文件名
     */
    protected function getTplFileName() {
        $name = $this->componentDescriptor->getName();
        return "$name.tpl";
    }

    /**
     * 获取渲染模板的数据。
     *
     * 默认使用初始数据，覆写该方法以使用其它数据。
     * 
     * @return [array] 模板数据
     */
    protected function getTplData() {
        return $this->initialData;
    }

    /**
     * 获取数据，该数据为初始化 Component 调用构造函数时传入的数组。
     *
     * 如果$key为NULL或不传，则返回所有数据。
     * 
     * @param  [string] $key 数据的索引
     * @return [mixin]      获取到的数据
     */
    public final function getData($key = NULL) {
        if(isset($key) && is_string($key) && !is_null($key)) {
            return isset($this->initialData[$key]) ? $this->initialData[$key] : NULL;
        } else {
            return $this->initialData;
        }
    }

    /**
     * 获取模板文件的绝对路径。
     *
     * @param [string] $file 模板文件名
     * @return [string] 绝对路径名
     */
    public final function getAbsTplFilePath($file = NULL) {
        return $this->componentDescriptor->getComponentTplPath($file);
    }

    /**
     * 获取该 Component 的路径。
     * 
     * 路径定义为 空间 + : + 名称。
     * 
     * @return [string] 路径名
     */
    public final function getPath() {
        $name = $this->componentDescriptor->getName();
        $namespace = $this->componentDescriptor->getNamespace();
        return "$namespace:$name";
    }

    protected function getUniquePath() {
        $name = $this->componentDescriptor->getName();
        $type = $this->componentDescriptor->getType();
        $namespace = $this->componentDescriptor->getNamespace();
        return strtolower("$namespace/$type/$name");
    }

    /**
     * 加载一个 Component。
     *
     * 如果目标 Component 不存在，则反馈空字符串。
     * 
     * @param  [string] $componentPath 目标 Component 路径
     * @param  [array] $data 目标 Component 初始数据
     * @return [string] 目标 Component 的类名
     */
    public final function load($componentPath, $data = array()) {
        $componentDescriptor = self::resolveComponentDescriptor($componentPath, $this->getAllowedSubComponentType());
        
        $componentClass = $componentDescriptor->getComponentClassName();

        if($this->componentDescriptor->getName() === $componentClass) {
            throw new BravoView_Exception("$componentClass cannot load self", 1);
        }

        if($componentDescriptor->exists()) {
            $subComponent = new $componentClass($componentDescriptor->getNamespace(), $componentDescriptor->getName(), $data, $this, $this->getAllowedSubComponentType());
            return $subComponent->display();
        } else {
            BravoView_Logger::warn("Component '$componentPath' not found!");
            return '';
        }
    }

    /**
     * 加载并获取一个 Component。同 Component:requireComponent()。
     * 
     * @param  [string] $componentPath 目标 Component 路径
     * @param  [string] $type
     * @return [string] 目标 Component 类名
     */
    protected function getAllowedSubComponentType() {
        return 'Component';
    }

    /**
     * 获取一个 Component 的类名。
     * 
     * @param  [string] $componentPath Component 路径
     * @return [string]            Component 类名
     */
    public final function requires($componentPath) {
        $componentDescriptor = self::resolveComponentDescriptor($componentPath, $this->getAllowedSubComponentType());

        return $componentDescriptor->exists() ? $componentDescriptor->getComponentClassName() : NULL;
    }

    /**
     * 使用模板和数据输出构造好的 HTML。
     *
     * 覆写该方法以支持自定义内容。
     * 
     * @return [string] HTML 输出的HTML
     */
    public function display() {
        $finalTplData = array_merge(array('__self' => $this), $this->initialData, $this->getTplData());
        return BravoView_Env::getRenderer()->render($this->getAbsTplFilePath(), $finalTplData);
    }

    private static final function resolveComponentDescriptor($component, $type) {

        list($namespace, $name) = explode(':', $component);

        return new BravoView_ComponentDescriptor(ucfirst($namespace), ucfirst($name), $type);
    }

    /**
     * 引入一个 Component。
     * 
     * @param  [string] $componentPath Component 路径
     * @return [bool]            是否引入成功
     */
    public static final function requireComponent($componentPath) {
        $componentDescriptor = self::resolveComponentDescriptor($componentPath, 'Component');
        return $componentDescriptor->exists();
    }

}

?>
