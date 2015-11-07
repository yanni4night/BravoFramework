<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Content.php
  *
  * changelog
  * 2015-10-30[16:30:00]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class Index_ContentPagelet extends BravoView_Pagelet {
    
    public function display() {
        return $this->load('Index:China');
    }

}

?>