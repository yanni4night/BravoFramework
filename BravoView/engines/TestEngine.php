<?php
/**
  * Copyright (C) 2015 tieba.baidu.com
  * TestEngine.php
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

require_once('BravoView/TemplateEngine.php');

/**
 * 测试用模板引擎，仅支持一级"{{variable}}" 语法输出变量。
 */
class BravoView_TestEngine implements BravoView_TemplateEngine {

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
