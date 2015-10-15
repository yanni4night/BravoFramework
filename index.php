<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * index.php
  *
  * changelog
  * 2015-10-15[15:12:02]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require('BravoView/BravoView.class.php');

$action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'index';

$rootPath = dirname(__FILE__);

$bravoView = new BravoView($rootPath);

$bravoView->action($action);

?>