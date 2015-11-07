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
var whoami = require('whoami-exec');

module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);

    var pkg = grunt.file.readJSON('package.json');

    grunt.file.setBase('..');

    var deploy = grunt.file.readYAML('deploy.yml');

    var outputDir = 'output/' + deploy.name;

    var myName = whoami();

    grunt.initConfig({
        pkg: pkg,
        clean: {
            output: ['output']
        },
        copy: {
            php: {
                expand: true,
                cwd: '.',
                src: ['*/*/*.php'],
                dest: outputDir
            },
            tpl: {
                expand: true,
                cwd: '.',
                src: ['*/*/*.tpl'],
                dest: outputDir
            }
        },
        config: {
            dep: {
                expand: true,
                cwd: '.',
                src: '*/*/module.yml',
                dest: outputDir,
                ext: '.config.php'
            }
        }
    });

    grunt.task.registerMultiTask('config', 'yml to php', function () {
        var options = this.options({});

        function repeat(str, n) {
            var ret = str;
            for (var i = 0; i < n - 1; ++i) {
                ret += str;
            }
            return ret;
        }

        function js2php(obj, indent) {
            indent = +indent || 4;
            if (indent < 0) {
                indent = 0;
            }
            var indentSpace = repeat(' ', indent);
            var nextIndext = indent + 4;
            if (null == obj) {
                return 'NULL';
            } else if (true === obj) {
                return 'True';
            } else if (false === obj) {
                return 'False';
            } else if ('number' === typeof obj || obj.constructor === Number) {
                return Number(obj);
            } else if (obj.constructor === Date) {
                return +obj / 1e3 | 0;
            } else if (obj.constructor === RegExp) {
                return obj.toString();
            } else if (obj.constructor === String) {
                return '\'' + obj + '\'';
            } else if (Array.isArray(obj)) {
                var ret = [];
                for (var i = 0; i < obj.length; ++i) {
                    if (js2php(obj[i])) {
                        ret.push(js2php(obj[i], nextIndext));
                    }
                }
                return 'array(\n' + indentSpace + ret.join(',\n' + indentSpace) + '\n' + ')';
            } else if ('function' === typeof obj) {
                return '';
            } else {
                ret = [];
                for (var e in obj) {
                    if (js2php(obj[e])) {
                        ret.push('\'' + e + '\' => ' + js2php(obj[e], nextIndext));
                    }
                }

                return 'array(\n' + indentSpace + ret.join(',\n' + indentSpace) + '\n' + ')';
            }
        }

        this.files.forEach(function (f) {
            var src = f.src[0];
            var yaml = grunt.file.readYAML(src);
            var content = '<?php\n/**\n * GENERATED AUTOMATICALLY BY ' + pkg.name + ' v' + pkg.version +
                '\n *\n * DO NOT MODIFY IT!\n *\n * @author ' + myName + '\n * @file\n */ \nreturn ' +
                js2php(
                    yaml) + ';\n ?>';
            grunt.file.write(f.dest, content);
        });
    });

    grunt.registerTask('default', ['clean', 'copy', 'config']);
};