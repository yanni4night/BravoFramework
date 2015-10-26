<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * World.php
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

BravoView_Component::requireComponent('Common:Block');

class Index_World extends Common_Block {

   protected function getTplData() {
        $user = $this->getData('user');
        return array('user' => $user);
   }
}

?>