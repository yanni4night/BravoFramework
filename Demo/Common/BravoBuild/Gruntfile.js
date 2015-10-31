/**
 * Copyright (C) 2014 yanni4night.com
 * Gruntfile.js
 *
 * changelog
 * 2015-10-20[23:56:09]:revised
 *
 * @author yanni4night@gmail.com
 * @version 0.1.0
 * @since 0.1.0
 */
module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);
  require('time-grunt')(grunt);
  
  grunt.file.setBase('..');

  var deploy = grunt.file.readYAML('deploy.yml');

  var outputDir = 'output/' + deploy.name;

  grunt.initConfig({
    clean: {
      output: ['output']
    },
    copy: {
      php: {
        expand: true,
        cwd: '.',
        src: ['{actions,components,pagelets}/**/*.php'],
        dest: outputDir
      },
      tpl: {
        expand: true,
        cwd: '.',
        src: ['{actions,components,pagelets}/**/*.tpl'],
        dest: outputDir
      }
    },
    dependencies: {
      dep: {
        expand: true,
        cwd: '.',
        src: '{actions,components,pagelets}/**/*/component.json',
        dest: outputDir,
        ext: '.config.php'
      }
    }
  });

  grunt.task.registerMultiTask('dependencies', 'dep json to php', function() {
    var options = this.options({});

    this.files.forEach(function(f) {
      var src = f.src[0];
      var json = grunt.file.readJSON(src);
      var components = Object.keys(json.dependencies || {});
      var deps = components.map(function(item) {
        return "'" + item + "' => '" + json.dependencies[item] + "'";
      });
      var content = '<?php return array(' + deps + '); ?>';
      grunt.file.write(f.dest, content);
    });
  });

  grunt.registerTask('default', ['clean', 'copy', 'dependencies']);
};