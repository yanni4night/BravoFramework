<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Utils.php
  *
  * changelog
  * 2015-10-16[15:17:23]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace Common;

class Utils extends \BravoView\Component {
    
    public function now() {
        return date('Y-m-d H:i:s');
    }
}
?>