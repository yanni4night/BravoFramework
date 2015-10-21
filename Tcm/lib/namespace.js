/**
  * Copyright (C) 2015 tieba.baidu.com
  * namespace.js
  *
  * changelog
  * 2015-10-21[11:45:11]:revised
  *
  * @author yinyong02@baidu.com
  * @version 0.1.0
  * @since 0.1.0
  */
module.exports = function (cb) {
    var namespace = require('path').resolve('../..').match(/\/([\w\-]+)$/)[1];
    cb(null, namespace);
};