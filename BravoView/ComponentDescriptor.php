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

class BravoView_ComponentDescriptor {
    private $namespace;
    private $name;
    private $type;

    public function __construct($namespace, $name, $type) {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->type = $type;
    }

    public function getNamespace() {
        return $this->namespace;
    }    

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getComponentClassName() {
        return $this->getNamespace() . '_' . $this->getName() . ('Component' === $this->getType() ? '' : $this->getType());
    }

    public function getComponentClassPath() {

        $dir = strtolower($this->getType() . 's');

        return BravoView_Env::getRootPath() . '/' . $this->getNamespace() . "/$dir/" . $this->getName() . '/' . $this->getName() . '.php';
    }

    public function getComponentTplPath($file = NULL) {

      if(isset($file) && is_string($file) && !empty($file)) {
          $dir = strtolower($this->getType() . 's');

          return BravoView_Env::getRootPath() . '/' . $this->getNamespace() . "/$dir/" . $this->getName() . '/' . $file;
      }

      return preg_replace('/\.php$/', '.tpl', $this->getComponentClassPath());
    }

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