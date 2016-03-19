___deprecated___, see [excellent-web-framework](https://github.com/yanni4night/excellent-web-framework)

# BravoFramework

一种基于 PHP 的前端工程框架，包含：

 - View: PHP 框架
 - Build: 构建脚本
 - bigpipe.js: BigPipe 前端基础库
 - Tcm: 脚手架

# Development

使用 `git subtree` 维护了几个子 repo。

```
$ git clone -b master https://github.com/yanni4night/BravoFramework.git
$ git remote add -f Tcm https://github.com/yanni4night/BravoBuild.git
$ git remote add -f Tcm https://github.com/yanni4night/tcm.git
$ git remote add -f bigpipe.js https://github.com/yanni4night/bigpipe.js.git
$ git subtree add --prefix BravoBuild BravoBuild master
$ git subtree add --prefix Tcm Tcm master
$ git subtree add --prefix bigpipe.js bigpipe.js master
```

# Test

依赖：
 - Grunt

运行脚本：
    sh build.sh

<http://localhost/BravoFramework/index.php>

# Roadmap

[ROADMAP](ROADMAP.md)

# 联系

 - <yanni4night@gmail.com>
