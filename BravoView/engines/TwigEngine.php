<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * TwigEngine.php
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

require_once 'BravoView/TemplateEngine.php';
require_once 'BravoView/thirty/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

/**
 * Twig 模板引擎。
 */
class BravoView_TwigEngine implements BravoView_TemplateEngine {
    private $twig;

    public function __construct($cacheDir){
        $loader = new Twig_Loader_Filesystem('/');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => False //$cacheDir
        ));
    }

    public function render($tplFile, $data = array()){
        return $this->twig->render($tplFile, $data);
    }
}

?>
