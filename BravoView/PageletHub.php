<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * PageletHub.php
  *
  * changelog
  * 2015-11-05[15:13:40]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?

include_once 'BravoView/Env.php';
include_once 'BravoView/Pagelet.php';
include_once 'BravoView/DataProviderKnocker.php';

final class BravoView_PageletHub implements BravoView_DataProviderKnocker{
    /**
     * 树形挂载，用于检查哪些pagelet的数据准备好了
     *
     *  - dp1 - pagelet1
     *        - pagelet2
     *        - pagelet3
     *  - dp2 - pagelet2
     *        - pagelet3
     *        - pagelet4
     *  ...
     *
     * @var array
     */
    private $dataProviders = array();

    /**
     * 用于计算每个pagelet的依赖的dp数量。
     *
     * pagelet1=>5,pagelet2=>3...
     * 
     * @var array
     */
    private $pagelets = array();

    private function __construct() {}

    private static $instance;

    public static final function getInstance() {
        return self::$instance ? self::$instance :(self::$instance = new self());
    }

    public function appendPagelet($pagelet) {
        if($pagelet && $pagelet instanceof BravoView_Pagelet && !in_array($pagelet, $this->pagelets)) {
            
            $dataProviders = array_unique($pagelet->getDataProviders());

            foreach ($dataProviders as $dpName) {
                if(!isset($this->dataProviders)) {
                    $this->dataProviders[$dpName] = array($pagelet);
                } else {
                    $this->dataProviders[$dpName][] = $pagelet;
                }
                
                $pageletId = $pagelet->getUniqueId();

                if(!isset($this->pagelets[$pageletId])) {
                    $this->pagelets[$pageletId] = 0;
                }

                ++$this->pagelets[$pageletId];
            }
        }
    }

    public function notifyPageComplete() {
        BravoView_Env::getDataProviderHandler()->pushDataProviders(array_keys($this->dataProviders));
    }
    /**
     * 通知有一个DataProvider已经运行完成。
     * 
     * @param  [string] $dpName DataProvider 名字
     */
    public function notifyDataProviderComplete($dpName, $data) {
        if(!isset($this->dataProviders[$dpName])) {
            return;
        }

        $pagelets = $this->dataProviders[$dpName];

        foreach ($pagelets as $idx => $pagelet) {
           if(isset($this->pagelets[$pagelet->getUniqueId()])) {
                $pagelet->pushData($data);
                if(--$this->pagelets[$pagelet->getUniqueId()] === 0) {
                    $pagelet->triggerRender();
                    unset($pagelets[$idx]);
                }
           }
        }

    }
}

?>