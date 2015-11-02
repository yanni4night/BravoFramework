<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * ComponentDescriptor.php
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

/**
 * Component 描述，包含命名空间、名称和类型信息。
 */
class BravoView_ComponentDescriptor {
    private $namespace;
    private $name;
    private $type;

    /**
     * 构造一个 Component 描述。
     * @param [string] $namespace 命名空间
     * @param [string] $name      名称
     * @param [string] $type      类型
     */
    public function __construct($namespace, $name, $type) {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->type = ucfirst($type);
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
     * 获取所描述的 Component 的类名。
     * 
     * @return [string] 类名
     */
    public function getComponentClassName() {
        return $this->getNamespace() . '_' . $this->getName() . ('Component' === $this->getType() ? '' : $this->getType());
    }

    /**
     * 获取所描述的 Component 的类文件路径。
     * 
     * @return [string] 类文件路径
     */
    public function getComponentClassPath() {

        $dir = strtolower($this->getType() . 's');

        return BravoView_Env::getRootPath() . '/' . $this->getNamespace() . "/$dir/" . $this->getName() . '/' . $this->getName() . '.php';
    }

    /**
     * 获取所描述的 Component 的模板文件路径。
     *
     * 如无文件名指定，则默认采用与 Component 同名的 tpl 文件。
     * 
     * @param  [string] $file 模版名
     * @return [string]       模板文件路径
     */
    public function getComponentTplPath($file = NULL) {

      if(isset($file) && is_string($file) && !empty($file)) {
          $dir = strtolower($this->getType() . 's');

          return BravoView_Env::getRootPath() . '/' . $this->getNamespace() . "/$dir/" . $this->getName() . '/' . $file;
      }

      return preg_replace('/\.php$/', '.tpl', $this->getComponentClassPath());
    }

    /**
     * 检查所描述的 Component 是否存在。
     *
     * 该操作会将 Component 类文件引入。
     * 
     * @return [bool] 是否存在
     */
    public function exists() {
        if(!$this->getNamespace() || !$this->getName()) {
            return False;
        }

        $classPath = $this->getComponentClassPath();

        if(file_exists($classPath)) {
            include_once $classPath;
        } else {
            return False;
        }

        return class_exists($this->getComponentClassName(), False);
    }

}

?>