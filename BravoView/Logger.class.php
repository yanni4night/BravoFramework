<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Logger.class.php
  *
  * changelog
  * 2015-10-15[12:22:38]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

interface Logger {
    public function log($msg);
    public function info($msg);
    public function warn($msg);
    public function error($msg);
}

?>