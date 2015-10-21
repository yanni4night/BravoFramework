/**
 * Copyright (C) 2015 tieba.baidu.com
 * author.js
 *
 * changelog
 * 2015-10-21[11:40:50]:revised
 *
 * @author yinyong02@baidu.com
 * @version 0.1.0
 * @since 0.1.0
 */

var exec = require('child_process').exec;

module.exports = function (cb) {
    exec('whoami', function (err, data) {
        return cb(null, err ? null : data.replace(/\s/m, '').match(/\/?([\w\-]+)$/)[1]);
    });
};