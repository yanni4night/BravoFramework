<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * China.php
  *
  * changelog
  * 2015-10-15[17:59:26]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

BravoView_Component::requireComponent('Index:World');

class Index_China extends Index_World {

    public function display() {
        return '<font size="+5" color="red">China</font>';
    }
}

?>
