<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * Action.class.php
  *
  * changelog
  * 2015-10-15[15:15:05]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

require_once('BravoView/Component.class.php');

/**
 * Action 指一个页面的入口模块。
 */
abstract class Action extends Component {

    public function __construct($data) {
        parent::__construct($data);
        $this->setType('actions');
    }

    /**
     * 输出页面所有HTML。
     * 
     * @return [string] 页面HTML
     */
    public final function run() {
        return $this->display();
    }
}

?>