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
namespace Index;

\BravoView\Component::requireComponent('Common:Block');

class World extends \Common\Block {
   
   protected function getTplData() {
        $user = $this->getData('user');
        return array('user' => $user);
   }
}

?>