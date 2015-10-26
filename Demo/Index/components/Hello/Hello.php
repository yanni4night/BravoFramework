<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Hello.php
  *
  * changelog
  * 2015-10-15[17:09:12]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class Index_Hello extends BravoView_Component {

    protected function getTplData() {
        return array('user' => $this->getData());
    }
}

?>