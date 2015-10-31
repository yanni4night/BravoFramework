<?php
/**
  * Copyright (C) 2014 yanni4night.com
  * LoaderStack.php
  *
  * changelog
  * 2015-10-31[10:32:08]:revised
  *
  * @author yanni4night@gmail.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once 'BravoView/Exception.php';

class BravoView_LoaderStack {

    private $stack = array();

    public function __construct($initialStack = NULL) {
        if(isset($initialStack) && $initialStack) {
            if(is_string($initialStack) && trim($initialStack)) {
                array_push($this->stack, $initialStack);
            } else if (is_array($initialStack) && !empty($initialStack)) {
                array_merge($this->stack, array_filter($initialStack, function($val) {
                    return is_string($var) && trim($var);
                }));
            }
        }
    }

    public final function forward($loader) {
      $loaderStack = new self($this->stack);
      $loaderStack->push($loader);
      return $loaderStack;
    }

    private function push($loader) {
        if (in_array($loader, $this->stack)) {
          throw new BravoView_Exception("Circle loaders:$this", 1);
          
            return False;
        } else {
            array_push($this->stack, $loader);
            return True;
        }
    }

    public function __toString() {
        return join('->', $this->stack);
    }
}

?>