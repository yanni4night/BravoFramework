<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Loader.class.php
  *
  * changelog
  * 2015-10-15[12:02:50]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

interface Loader {
    public function load($target, $extra);
    public function find($target);
}

?>