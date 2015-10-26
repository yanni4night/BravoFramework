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

class Index_IndexAction extends BravoView_Action {

    public function getTplData(){
        return array('user' => array('name' => 'yanni4night', 'gender' => 'male'));
    }
}

?>