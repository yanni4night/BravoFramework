<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * TestEngine.class.php
  *
  * changelog
  * 2015-10-15[16:21:03]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
?>
<?php
namespace BravoView;

require_once('BravoView/TemplateEngine.class.php');

class TestEngine implements TemplateEngine {
    /**
     * [render description]
     * @param  [string] $tplFile
     * @param  [array] $data
     * @return [string]
     * @override_function(render)
     */
    public function render($tplFile, $data){
        $content = file_get_contents($tplFile);

        if(!isset($data) || !is_array($data) || !count($data)){
          return $content;
        }

        return preg_replace_callback('/\{\{(\w+)\}\}/m', function($matches) use($data){
            return isset($data[$matches[1]]) ? $data[$matches[1]] : '';
        }, $content);
    }
}

?>