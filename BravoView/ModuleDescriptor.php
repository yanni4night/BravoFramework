<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * ModuleDescriptor.php
  *
  * changelog
  * 2015-10-30[17:11:01]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/Env.php');
require_once('BravoView/Exception.php');
require_once('BravoView/Logger.php');

/**
 * Module 描述，包含命名空间、名称和类型信息。
 */
class BravoView_ModuleDescriptor {
    private $namespace;
    private $name;
    private $type;

    /**
     * 构造一个 Module 描述。
     * @param [string] $namespace 命名空间
     * @param [string] $name      名称
     * @param [string] $type      类型
     */
    public function __construct($namespace, $name, $type) {
        $this->namespace = ucfirst($namespace);
        $this->name = ucfirst($name);
        $this->type = ucfirst($type);
    }

    public function getFullPath() {
        return join(':', array($this->namespace, $this->type, $this->name));
    }

    /**
     * 获取命名空间。
     * 
     * @return [string] 命名空间
     */
    public function getNamespace() {
        return $this->namespace;
    }    

    /**
     * 获取名称。
     * 
     * @return [string] 名称
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 获取类型。
     * 
     * @return [string] 类型
     */
    public function getType() {
        return $this->type;
    }

    /**
     * 获取所描述的 Module 的类名。
     * 
     * @return [string] 类名
     */
    public function getModuleClassName() {
        return $this->getNamespace() . '_' . $this->getName() . ('Component' === $this->getType() ? '' : $this->getType());
    }

    /**
     * 获取所描述的 Module 的类文件路径。
     * 
     * @return [string] 类文件路径
     */
    public function getModuleClassPath() {
        return $this->resolveLocalFilePath($this->getName() . '.php');
    }

    /**
     * 解析该 Module 目录下一个文件的绝对路径。
     * 
     * @param  [string] $file 文件名
     * @return [string]       绝对路径
     */
    public function resolveLocalFilePath($file) {
        $dir = strtolower($this->getType() . 's');

        if(0 === strpos($file, '/')) {
            $file = substr($file, 1);
        }

        return BravoView_Env::getRootPath() . '/' . $this->getNamespace() . "/$dir/" . $this->getName() . "/$file";
    }

    /**
     * 读取模块配置文件。
     * 
     * @return [array] 模块配置
     */
    public function readModuleConfig() {
        $configFile = $this->resolveLocalFilePath('module.config.php');
        
        try {
            // TODO: deep clone
            $config = include $configFile;
            if(!is_array($config)) {
                throw new BravoView_Exception('"$configFile" not avaliable', 1);
            }
        } catch(Exception $e) {
            BravoView_Logger::warn($e->getMessage());
            $config = array();
        }

        return $config;;
    }

    /**
     * 获取所描述的 Module 的模板文件路径。
     *
     * 如无文件名指定，则默认采用与 Module 同名的 tpl 文件。
     * 
     * @param  [string] $file 模版名
     * @return [string]       模板文件路径
     */
    public function getModuleTplPath($file = NULL) {

      if(!isset($file) || !is_string($file) || empty($file)) {
          $file = $this->getName() . '.tpl';
      }

      return $this->resolveLocalFilePath($file);
    }

    /**
     * 检查所描述的 Module 是否存在。
     *
     * 该操作会将 Module 类文件引入。
     * 
     * @return [bool] 是否存在
     */
    public function exists() {
        if(!$this->getNamespace() || !$this->getName()) {
            return False;
        }

        $classPath = $this->getModuleClassPath();

        if(file_exists($classPath)) {
            include_once $classPath;
        } else {
            return False;
        }

        return class_exists($this->getModuleClassName(), False);
    }

}

?>