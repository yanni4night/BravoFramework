<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Top.php
  *
  * changelog
  * 2015-10-30[16:14:29]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class Index_TopPagelet extends BravoView_Pagelet {

    public function display() {
        return $this->load('Index:Hello');
    }

    public function getDataProviders() {
        return array('A', 'B', 'C', 'D');
    }
}

?>