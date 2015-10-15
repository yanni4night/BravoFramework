<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Action.class.php
  *
  * changelog
  * 2015-10-15[15:15:05]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once('BravoView/Component.class.php');

abstract class Action extends Component {

    public final function run() {
        return $this->display();
    }
}

?>