/**
 * Copyright (C) 2015 tieba.baidu.com
 * name.js
 *
 * changelog
 * 2015-10-21[11:42:31]:revised
 *
 * @author yinyong02@baidu.com
 * @version 0.1.0
 * @since 0.1.0
 */

module.exports = function (cb) {
    var name = require('path').resolve('.').match(/\/([\w\-]+)$/)[1];
    cb(null, name);
};