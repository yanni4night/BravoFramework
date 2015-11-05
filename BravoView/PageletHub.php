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

final class BravoView_PageletHub {
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
    private static $dataProviders = array();

    /**
     * 用于计算每个pagelet的依赖的dp数量。
     *
     * pagelet1=>5,pagelet2=>3...
     * 
     * @var array
     */
    private static $pagelets = array();

    public static function appendPagelet($pagelet) {
        if($pagelet && $pagelet instanceof BravoView_Pagelet && !in_array($pagelet, self::$pagelets)) {
            
            $dataProviders = array_unique($pagelet->getDataProviders());

            foreach ($dataProviders as $dpName) {
                if(!isset(self::$dataProviders)) {
                    self::$dataProviders[$dpName] = array($pagelet);
                } else {
                    self::$dataProviders[$dpName][] = $pagelet;
                }
                
                $pageletId = $pagelet->getUniqueId();

                if(!isset(self::$pagelets[$pageletId])) {
                    self::$pagelets[$pageletId] = 0;
                }

                ++self::$pagelets[$pageletId];
            }
        }
    }

    public static function notifyPageComplete() {
        BravoView_Env::getDataProviderHandler()->pushDataProviders(array_keys(self::$dataProviders));
    }
    /**
     * 通知有一个DataProvider已经运行完成。
     * 
     * @param  [string] $dpName DataProvider 名字
     */
    public static function notifyDataProviderComplete($dpName, $data) {
        if(!isset(self::$dataProviders[$dpName])) {
            return;
        }

        $pagelets = self::$dataProviders[$dpName];

        foreach ($pagelets as $idx => $pagelet) {
           if(isset(self::$pagelets[$pagelet->getUniqueId()])) {
                $pagelet->pushData($data);
                if(--self::$pagelets[$pagelet->getUniqueId()] === 0) {
                    $pagelet->triggerRender();
                    unset($pagelets[$idx]);
                }
           }
        }

    }
}

?>