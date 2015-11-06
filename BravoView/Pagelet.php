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
require_once 'BravoView/PageletHub.php';
require_once 'BravoView/Logger.php';

/**
 * BigPipe 概念
 */
class BravoView_Pagelet extends BravoView_Module {

    private $subTypes = array('Component', 'Pagelet');

    public function __construct($namespace, $name, $data, $loader) {
        parent::__construct($namespace, $name, $data, $loader, 'Pagelet');
        BravoView_PageletHub::getInstance()->appendPagelet($this);
    }

    protected final function getSubModuleType() {
        return $this->subTypes;
    }

    public final function triggerRender() {
        $content = $this->display();
        echo '<script>TBP(' . json_encode(array(
            'id' => $this->getUniqueId(),
            'js' => array(),
            'css' => array(),
            'content' => $content
            )) . ');</script>'; 
        ob_flush();
        flush();
    }

    protected final function formatDisplay() {
        // 先占位，过后输出 script 再行渲染
        return '<div id="' . $this->getUniqueId() . '"></div>';
    }

    public function getDataProviders() {
        return array();
    }
}

?>