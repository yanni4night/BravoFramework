<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Pagelet.php
  *
  * changelog
  * 2015-10-30[15:45:46]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once 'BravoView/Module.php';
require_once 'BravoView/Env.php';
require_once 'BravoView/Logger.php';

/**
 * BigPipe 概念
 */
class BravoView_Pagelet extends BravoView_Module {

    private $subTypes = array('Component', 'Pagelet');

    public function __construct($namespace, $name, $data, $loader) {
        parent::__construct($namespace, $name, $data, $loader, 'Pagelet');
    }

    protected final function getSubModuleType() {
        return $this->subTypes;
    }
}

?>