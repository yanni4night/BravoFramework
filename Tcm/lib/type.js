/**
 * Copyright (C) 2015 tieba.baidu.com
 * type.js
 *
 * changelog
 * 2015-11-06[16:26:57]:revised
 *
 * @author yinyong02@baidu.com
 * @version 0.1.0
 * @since 0.1.0
 */
module.exports = function (cb) {
    var namespace = require('path').resolve('..').match(/\/([\w\-]+)$/)[1];
    cb(null, namespace.replace(/s$/, '').replace(/^\w/, function (n) {
        return n.toUpperCase();
    }));
};