<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * index.php
  *
  * changelog
  * 2015-10-15[18:21:14]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>

<?php

$actionPath = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'Index:index';

$rootPath = dirname(__FILE__);

$bravoView = new \BravoView\BravoView($rootPath);

$bravoView->action($actionPath, array('app' => 'demo'));

?>