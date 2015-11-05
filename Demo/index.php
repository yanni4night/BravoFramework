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

class SimpleDataProviderHandler implements BravoView_DataProviderHandler {

    private $dataProviders;
    /**
     * @param  [array] $dataProviders
     * @override
     */
    public function pushDataProviders($dataProviders) {
        $this->dataProviders = $dataProviders;
    }

    public function out() {
        if(count($this->dataProviders)) {
            return array_shift($this->dataProviders);
        } else {
            return False;
        }
    }
}

$actionPath = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'Index:Index';

$rootPath = dirname(__FILE__);

$bravoView = new BravoView($rootPath, $dph = new SimpleDataProviderHandler(), 'twig');

$bravoView->action($actionPath);

while(False !== ($ret = $dph->out())) {
    sleep(2);
    $bravoView->notifyDataProviderComplete($ret, array('app' => 'demo'));
}

?>