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
class Hello extends Component {
    protected function getTplFileName() {
        return dirname(__FILE__) . '/tpl.tpl';
    }
}
?>