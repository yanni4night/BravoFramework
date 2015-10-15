<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * TemplateEngine.class.php
  *
  * changelog
  * 2015-10-15[11:49:26]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

interface TemplateEngine {
    public function render($tplFileName, $data);
}

?>