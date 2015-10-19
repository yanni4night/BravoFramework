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
require_once('BravoView/thirty/twig/lib/Twig/Autoloader.php');

\Twig_Autoloader::register();


class TwigEngine implements TemplateEngine {
    private $twig;
    /**
     * [__construct description]
     */
    public function __construct($cacheDir){
        $loader = new \Twig_Loader_Filesystem('/');
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => False //$cacheDir
        ));
    }
    /**
     * [render description]
     * @param  [type] $tplFile [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     * @override_function(render)
     */
    public function render($tplFile, $data = array()){
        return $this->twig->render($tplFile, $data);
    }
}

?>