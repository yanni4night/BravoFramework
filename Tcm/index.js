/**
 * Copyright (C) 2014 yanni4night.com
 * index.js
 *
 * changelog
 * 2015-10-21[00:22:06]:revised
 *
 * @author yanni4night@gmail.com
 * @version 0.1.0
 * @since 0.1.0
 */
var read = require('read');
var PZ = require('promzard').PromZard
var path = require('path');
var async = require('async');

var params = 'name,namespace,author'.split(',');

async.parallel(params.map(function (key) {
    return require('./lib/' + key + '.js');
}), function (err, results) {
    if (err) {
        return process.exit(0);
    }
    var ctx = {};

    results.forEach(function (v, idx) {
        ctx[params[idx]] = v;
    })

    ask(ctx);
});

function ask(ctx) {
    var pz = new PZ(path.join(__dirname, 'input.js'), ctx, function () {
        console.log(arguments);
    });

    pz.on('data', function (data) {
        read({
            prompt: JSON.stringify(data, null, 4) + '\n\nIs this ok?',
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
    require('fs').writeFileSync('component.json', JSON.stringify(config, null, 4));
}