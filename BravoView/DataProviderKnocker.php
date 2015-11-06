<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * DataProviderKnocker.php
  *
  * changelog
  * 2015-11-06[13:08:48]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>

<?php

interface BravoView_DataProviderKnocker {
    public function notifyDataProviderComplete($dpName, $data);
}

?>