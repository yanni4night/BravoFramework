<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * TwigEngine.class.php
  *
  * changelog
  * 2015-10-15[13:54:03]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

require_once('BravoView/TemplateEngine.class.php');

class TwigEngine implements TemplateEngine {

    /**
     * [__construct description]
     */
    public function __construct(){

    }
    /**
     * [render description]
     * @param  [type] $tplFile [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     * @override_function(render)
     */
    public function render($tplFile, $data){

    }
}

?>