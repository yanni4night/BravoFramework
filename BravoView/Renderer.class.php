<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Renderer.class.php
  *
  * changelog
  * 2015-10-15[14:29:23]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

interface Renderer {
    public function render($tplFileName, $data);
}

?>