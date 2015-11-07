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

/**
 * 集中处理 Bigpipe 中 Pagelet 的数据请求。
 *
 * 首先应将每个 Pagelet 通过 notifyPageComplete 方法
 * 通知 PageletHub，当页面中所有 Pagelet 收集完毕，调用
 * notifyPageComplete 触发数据请求。
 *
 * 当外部数据准备完成时，PageletHub 会调用满足的 Pagelet
 * 并渲染。
 * 
 */
final class BravoView_PageletHub implements BravoView_DataProviderKnocker{
    /**
     * 树形挂载，用于检查哪些pagelet的数据准备好了
     *
     *  array(
     *      'dp1' => array(
     *          'pagelets' => array(),
     *          'data' => array()
     *      )
     *  )
     *
     * @var array
     */
    private $dataProviders = array();

    /**
     * 用于计算每个 pagelet 的依赖的 data provider 数量。
     *
     * array(
     *     'pagelet1' => 5,
     *     'pagelet2' => 3
     * )
     * 
     * @var array
     */
    private $dataProviderCountInPagelet = array();

    private function __construct() {}

    private static $instance;

    public static final function getInstance() {
        return self::$instance ? self::$instance :(self::$instance = new self());
    }

    public function appendPagelet($pagelet) {
        if($pagelet && $pagelet instanceof BravoView_Pagelet && !in_array($pagelet, $this->dataProviderCountInPagelet)) {
            
            // 每个 Pagelet 的 data provider 一定要去重
            $requiredDataProviders = array_unique($pagelet->getDataProviders());

            foreach ($requiredDataProviders as $dpName) {
                if(!isset($this->dataProviders[$dpName])) {
                    $this->dataProviders[$dpName] = array(
                            'pagelets' => array($pagelet),
                            'data' => NULL
                        );
                } else {
                    $this->dataProviders[$dpName]['pagelets'][] = $pagelet;
                }
                
                $pageletId = $pagelet->getUniqueId();

                if(!isset($this->dataProviderCountInPagelet[$pageletId])) {
                    $this->dataProviderCountInPagelet[$pageletId] = 0;
                }

                ++$this->dataProviderCountInPagelet[$pageletId];
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
     * @param  [array] $data 
     */
    public function notifyDataProviderComplete($dpName, $data) {
        if(!isset($this->dataProviders[$dpName])) {
            return;
        }

        $dp = $this->dataProviders[$dpName];

        foreach ($dp['pagelets'] as $idx => $pagelet) {
           if(isset($this->dataProviderCountInPagelet[$pagelet->getUniqueId()])) {
                $pagelet->pushData($data);
                if(--$this->dataProviderCountInPagelet[$pagelet->getUniqueId()] === 0) {
                    $pagelet->triggerRender();
                    unset($dp[$idx]);
                }
           }
        }

    }
}

?>