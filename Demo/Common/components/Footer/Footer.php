<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Footer.php
  *
  * changelog
  * 2015-10-15[18:38:08]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

class Common_Footer extends BravoView_Component {

    protected function getTplData() {
        $utilsClass = $this->requires('Common:Utils');
        
        if($utilsClass) {
            $utils = new $utilsClass();
        } else {
            var_dump($utilsClass);
        }

        return array('year' => $utils->now(), 'author' => 'yanni4night.com');
    }
}

?>