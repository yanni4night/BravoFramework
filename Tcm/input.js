/**
 * Copyright (C) 2015 tieba.baidu.com
 * input.js
 *
 * changelog
 * 2015-10-21[10:53:55]:revised
 *
 * @author yinyong02@baidu.com
 * @version 0.1.0
 * @since 0.1.0
 */

module.exports = {
    path: prompt('path', namespace + ':' + name),
    author: prompt('author', author),
    description: prompt('description'),
    dependencies: prompt('dependencies', function (data) {
        var deps = {};
        if (data) {
            var keys = data.split(',');
            keys.forEach(function (key) {
                deps[key] = '~1.0.0';
            });
        }
        return deps;
    })
};