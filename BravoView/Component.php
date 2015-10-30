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
require_once('BravoView/Env.php');
require_once('BravoView/Logger.php');

if(!defined('__DEP' . 'S__')) {
    define('__DEP' . 'S__', 1);
}

/**
 * Component 代表模块化的实体。它拥有以下功能：
 * 
 * 1. 利用数据和模板输出HTML;
 * 2. 调用其它 Component;
 * 
 */
class BravoView_Component implements BravoView_Loader {

    // 数据
    private $initialData = array();

    // 编译脚本应该将此编译为该Component依赖的所有依赖模块的数组
    private $dependencies = __DEPS__;

    // 类型，用以路径查找
    private $type = 'components';

    // 空间
    private $namespace = null;

    // 名称
    private $name = null;

    // 父加载器
    private $loader = null;

    /**
     * 构造一个 Component。
     * 
     * @param [array] $data 初始数据
     */
    public function __construct($namespace, $name, $data) {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->initialData = isset($data) && is_array($data) && !empty($data) ? $data : array();
    }

    private function setLoader($loader) {
        if($loader instanceof Loader) {
            $this->loader = $loader;
        }
    }

    /**
     * 获取本 Component 的父加载器。
     *
     * 只有使用 load 方法加载的Component才有父加载器。
     * 
     * @return [Loader] 父加载器
     */
    public final function getLoader() {
        return $this->loader;
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
        $name = $this->getName();
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
        $name = $this->getName();
        $namespace = $this->getNamespace();
        return BravoView_Env::getRootPath() . "/$namespace/{$this->type}/$name/" . (isset($file) ? $file : $this->getTplFileName());
    }

    /**
     * 设置类型。
     * 
     * @param [string] $type 类型
     */
    protected final function setType($type) {
        $this->type = $type;
    }

    /**
     * 获取该 Component 的名称。
     * 
     * @return [string] 名称
     */
    public final function getName() {
        return $this->name;
    }

    /**
     * 获取该 Component 的空间。
     * 
     * @return [string] 空间名
     */
    public final function getNamespace() {
        return $this->namespace;
    }

    /**
     * 获取该 Component 的路径。
     * 
     * 路径定义为 空间 + : + 名称。
     * 
     * @return [string] 路径名
     */
    public final function getPath() {
        $name = $this->getName();
        $namespace = $this->getNamespace();
        return "$namespace:$name";
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
        $componentScopeName = $this->requires($componentPath);
        $componentClass = "${componentScopeName[0]}_${componentScopeName[1]}";
        
        if($componentScopeName) {
            $component = new $componentClass($componentScopeName[0], $componentScopeName[1], $data);
            $component->setLoader($this);
            return $component->display();
        }else {
            BravoView_Logger::warn("Component '$componentPath' not found!");
            return '';
        }
    }

    /**
     * 加载并获取一个 Component。同 Component:requireComponent()。
     * 
     * @param  [string] $componentPath 目标 Component 路径
     * @return [string] 目标 Component 类名
     */
    public final function requires($componentPath) {
        return self::requireComponent($componentPath);
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

    /**
     * 加载并获取一个 Component 的类名。
     *
     * 如果目标 Component 不存在，则返回NULL。
     * 
     * @param  [string] $component 目标 Component 路径
     * @return [array] 
     */
    public static final function requireComponent($component) {
        $componentScopeName = explode(':', $component);

        if(2 !== count($componentScopeName)) {
            return NULL;
        }

        $componentPhpPath = BravoView_Env::getRootPath() . "/${componentScopeName[0]}/components/${componentScopeName[1]}/${componentScopeName[1]}.php";

        if(file_exists($componentPhpPath)){
            include_once($componentPhpPath);
            $componentClass = "${componentScopeName[0]}_${componentScopeName[1]}";
            return class_exists($componentClass, False) ? $componentScopeName : NULL;
        }else {
            return NULL;
        }
        
    }
}

?>
