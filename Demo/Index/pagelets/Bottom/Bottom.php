<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Bottom.php
  *
  * changelog
  * 2015-10-30[16:33:48]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class Index_BottomPagelet extends BravoView_Pagelet {
    
    public function getDataProviders() {
        return array('C', 'D', 'E', 'F', 'G');
    }
}
?>