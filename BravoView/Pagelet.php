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

require_once('BravoView/Component.php');
require_once('BravoView/Env.php');
require_once('BravoView/Logger.php');

/**
 * BigPipe 概念
 */
class BravoView_Pagelet extends BravoView_Component {

    public function __construct($namespace, $name, $data, $loader) {
        parent::__construct($namespace, $name, $data, $loader, 'Pagelet');
    }
    
    /*public function display() {
        $finalTplData = array_merge(array('__self' => $this), $this->initialData, $this->getTplData());
        return BravoView_Env::getRenderer()->render($this->getAbsTplFilePath(), $finalTplData);
    }*/

}

?>