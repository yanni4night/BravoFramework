<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Module.php
  *
  * changelog
  * 2015-11-05[12:01:47]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once 'BravoView/Loader.php';
require_once 'BravoView/ModuleDescriptor.php';
require_once 'BravoView/Env.php';
require_once 'BravoView/Exception.php';
require_once 'BravoView/Logger.php';

/**
 * Module 代表模块化的实体。它拥有以下功能：
 * 
 * 1. 利用数据和模板输出HTML;
 * 2. 调用其它 Module
 * 
 */
abstract class BravoView_Module extends BravoView_Loader {

    // 数据
    private $initialData;

    // 描述符
    private $moduleDescriptor;

    /**
     * 构造一个 Module。
     * 
     * @param [array] $data 初始数据
     */
    public function __construct($namespace, $name, $data, $loader, $type) {
        $this->initialData = isset($data) && is_array($data) && !empty($data) ? $data : array();
        $this->moduleDescriptor = new BravoView_ModuleDescriptor($namespace, $name, $type);
        parent::__construct($loader);
    }

    /**
     * 返回该 Module 的名字空间。
     * 
     * @return [string] 名字空间
     */
    public function getNamespace() {
        return $this->moduleDescriptor->getNamespace();
    }

    /**
     * 返回该 Module 的名字。
     * 
     * @return [string] 名字
     */
    public function getName() {
        return $this->moduleDescriptor->getName();
    }

    /**
     * 返回该 Module 的类型。
     * 
     * @return [string] 类型
     */
    public function getType() {
        return $this->moduleDescriptor->getType();
    }

    /**
     * 获取模版名，仅支持一个文件。
     *
     * 默认查找与该 Module 同名的文件，后缀"tpl"，
     * 覆写该方法用于使用其它文件。
     * 
     * @return [string] 模板文件名
     */
    protected function getTplFileName() {
        $name = $this->getName();
        return "$name.tpl";
    }

    /**
     * 追加数据
     * 
     * @param  [array] $data 额外数据
     */
    public function pushData($data) {
        if(is_array($data)) {
            $this->initialData = array_merge($this->initialData, $data);
        }
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
     * 获取数据，该数据为初始化 Module 调用构造函数时传入的数组。
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
        return $this->moduleDescriptor->getModuleTplPath($file);
    }

    /**
     * 获取该 Module 的路径。
     * 
     * 路径定义为 空间 + : + 名称。
     * 
     * @return [string] 路径名
     */
    public final function getPath() {
        $name = $this->getName();
        $type = $this->getType();
        $namespace = $this->getNamespace();
        return "$namespace:$type:$name";
    }

    public function getUniqueId() {
        $name = $this->getName();
        $type = $this->getType();
        $namespace = $this->getNamespace();
        return strtolower("$namespace-$type-$name");
    }

    /**
     * 加载一个 Module。
     *
     * 如果目标 Module 不存在，则返回空字符串。
     * 
     * @param  [string] $modulePath 目标 Module 路径
     * @param  [array] $data 目标 Module 初始数据
     * @return [string] 目标 Module 的类名
     */
    public final function load($modulePath, $data = array()) {
        $moduleDescriptor = $this->resolveModuleDescriptor($modulePath);
        
        $moduleClass = $moduleDescriptor->getModuleClassName();

        if($this->getName() === $moduleClass) {
            throw new BravoView_Exception("$moduleClass cannot load self", 1);
        }

        if($moduleDescriptor->exists()) {
            $subModule = new $moduleClass($moduleDescriptor->getNamespace(), $moduleDescriptor->getName(), $data, $this, $moduleDescriptor->getType());
            return $subModule->formatDisplay();
        } else {
            BravoView_Logger::warn('Module "' . $moduleDescriptor->getFullPath() . '" not found!');
            return '';
        }
    }

    /**
     * 加载并获取一个 Module。同 Module:requireModule()。
     * 
     * @param  [string] $modulePath 目标 Module 路径
     * @param  [string] $type
     * @return [string] 目标 Module 类名
     */
    protected abstract function getSubModuleType();

    /**
     * 对Module输出内容格式化。
     * 
     * @return [string] 格式后的内容。
     */
    protected function formatDisplay() {
        return $this->display();
    }

    /**
     * 获取一个 Module 的类名。
     * 
     * @param  [string] $modulePath Module 路径
     * @return [string]            Module 类名
     */
    public final function requires($modulePath) {
        $moduleDescriptor = $this->resolveModuleDescriptor($modulePath);

        return $moduleDescriptor->exists() ? $moduleDescriptor->getModuleClassName() : NULL;
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
     * @override
     */
    public function __toString() {
        return $this->formatDisplay();
    }

    /**
     * 根据 Module 路径名解析出 ModuleDescriptor。
     * 
     * @param  [string] $modulePath Module 路径
     * @return [ModuleDescriptor]            Module 描述
     */
    protected final function resolveModuleDescriptor($modulePath) {
        return self::resolveModuleDescriptorBySubTypes($modulePath, $this->getSubModuleType());
    }

    protected final static function resolveModuleDescriptorBySubTypes($modulePath, $subTypes) {
        list($namespace, $type, $name) = explode(':', $modulePath);
            
        if(!$subTypes || (is_array($subTypes) && !count($subTypes))) {
            throw new BravoView_Exception('No type is allowed.', 1);
        }

        if(isset($name) && $name) {
            $type = ucfirst($type);
            if((is_array($subTypes) && !in_array($type, $subTypes)) || (!is_array($subTypes) && $type !== $subTypes)) {
                throw new BravoView_Exception("'$type' is not allowed for " . (is_array($subTypes) ? join(',', $subTypes) : $subTypes), 1);
            }
        } else {
            $name = $type;
            $type = is_array($subTypes) ? $subTypes[0] : $subTypes;
        }

        return new BravoView_ModuleDescriptor($namespace, $name, $type);
    }

}

?>
