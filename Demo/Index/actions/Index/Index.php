<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * index.php
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
namespace Index;

class IndexAction extends \BravoView\Action {

    public function display(){
        //Just test
        return parent::display() . $this->load('Index:Hello', null) . $this->load('Index:China', null) . $this->load('Common:Footer', null);
    }
}

?>