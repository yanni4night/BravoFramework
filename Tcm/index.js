/**
 * Copyright (C) 2014 yanni4night.com
 * index.js
 *
 * changelog
 * 2015-10-21[00:22:06]:revised
 * 2015-11-06[16:40:24]:whole component name;yaml format instead of json
 * 2015-11-06[16:59:23]:override confirm
 *
 * @author yanni4night@gmail.com
 * @version 0.1.0
 * @since 0.1.0
 */
var read = require('read');
var PZ = require('promzard').PromZard
var path = require('path');
var async = require('async');
var jsYaml = require('js-yaml');
var fs = require('fs');
var targetFile = require('./target');

var params = 'name,type,namespace,author'.split(',');


function prepare() {

    if (fs.existsSync(targetFile)) {
        read({
            prompt: targetFile + ' already exists,override?',
            default: 'no'
        }, function (err, ret) {
            if (ret && ret.toLowerCase().charAt(0) === 'y') {
                work();
            } else {
                console.log('Aborted');
            }
        });
    } else {
        work();
    }
};

function work() {
    async.parallel(params.map(function (key) {
        return require('./lib/' + key + '.js');
    }), function (err, results) {
        if (err) {
            console.error(err);
            return process.exit(0);
        }
        var ctx = {};

        results.forEach(function (v, idx) {
            ctx[params[idx]] = v;
        })

        ask(ctx);
    });

}

function ask(ctx) {
    var pz = new PZ(path.join(__dirname, 'input.js'), ctx);

    pz.on('data', function (data) {
        read({
            prompt: '\n\n' + jsYaml.safeDump(data) + '\n\nIs this ok?',
            default: 'yes'
        }, function (err, ret) {
            if (!ret || ret.toLowerCase().charAt(0) === 'y') {
                write(data);
            } else {
                console.log('Aborted.');
            }
        });

    });

    pz.on('error', function (err) {
        console.error(err);
    });
}

function write(config) {
    require('fs').writeFileSync(targetFile, jsYaml.safeDump(config));
}

prepare();