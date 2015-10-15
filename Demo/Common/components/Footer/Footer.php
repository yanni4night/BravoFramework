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

class Footer extends Component {

    protected function getTplData() {
        return array('year' => date('Y'), 'author' => 'yanni4night.com');
    }
}

?>