<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Component.php
  *
  * changelog
  * 2015-10-15[15:42:58]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php

require_once 'BravoView/Module.php';
require_once 'BravoView/Env.php';
require_once 'BravoView/Exception.php';
require_once 'BravoView/Logger.php';

/**
 * Component 代表模块化的实体。它拥有以下功能：
 * 
 * 1. 利用数据和模板输出HTML;
 * 2. 调用其它 Component;
 * 
 */
class BravoView_Component extends BravoView_Module {

    /**
     * 构造一个 Component。
     * 
     * @param [array] $data 初始数据
     */
    public function __construct($namespace, $name, $data, $loader) {
        parent::__construct($namespace, $name, $data, $loader, 'Component');
    }

    protected final function getSubModuleType() {
        return 'Component';
    }

    /**
     * 导入一个 Component。
     *
     * 导入成功后，可直接使用 Component 类。
     * 
     * @param  [string] $componentPath Component 路径
     * @return [bool]            是否导入成功
     */
    public static final function requireComponent($componentPath) {
        $componentDescriptor = self::resolveModuleDescriptorBySubTypes($componentPath, 'Component');
        return $componentDescriptor->exists();
    }

}

?>
