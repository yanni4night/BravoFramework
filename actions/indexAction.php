<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * indexAction.php
  *
  * changelog
  * 2015-10-15[15:19:21]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class IndexAction extends Action {

    protected function getTplFileName() {
        return dirname(__FILE__) . '/tpl.tpl';
    }

    public function display(){
        return parent::display() . $this->load('Hello', null);
    }
}

?>