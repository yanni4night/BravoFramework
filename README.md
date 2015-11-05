# BravoFramework
Just a thinking of front-end framework.It contanins:

 - View: PHP layer implements module/static
 - Build: Build script
 - bigpipe.js: Script implements bigpipe mode
 - Tcm: Component Manager Tool

# Development

```
$ git clone -b master https://github.com/yanni4night/BravoFramework.git
$ git remote add -f Tcm https://github.com/yanni4night/BravoBuild.git
$ git remote add -f Tcm https://github.com/yanni4night/tcm.git
$ git remote add -f bigpipe.js https://github.com/yanni4night/bigpipe.js.git
$ git subtree add --prefix BravoBuild BravoBuild master
$ git subtree add --prefix Tcm Tcm master
$ git subtree add --prefix bigpipe.js bigpipe.js master
```

# test
run script:
    sh build.sh

open browser: <http://localhost/BravoFramework/index.php>

# Contact

 - <yanni4night@gmail.com>