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

var questions = {
    path: prompt('path', namespace + ':' + type + ':' + name),
    version: prompt('version', '1.0.0'),
    author: prompt('author', author),
    description: prompt('description'),
    dependencies: prompt('dependencies', function (data) {
        var deps = {};
        if (data) {
            var keys = data.split(/[,\s]/);
            keys.forEach(function (key) {
                if (2 === key.split(':').length) {
                    key = key.replace(/:/, ':Component:');
                }
                if (3 === key.split(':').length) {
                    deps[key] = '~1.0.0';
                }
            });
        }
        return deps;
    })
};

if ('Pagelet' === type) {
    questions['data-providers'] = prompt('data-providers', function (data) {
        return data ? data.split(/[,\s]/) : [];
    });
}

module.exports = questions;