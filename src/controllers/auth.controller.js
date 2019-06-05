const {
    sha256
} = require('js-sha256');
const gpg = require('node-gpg');
const Hal = require('hal');

module.exports = {
    hash: function (req, res) {
        // console.log('app req headers: ', req.headers);
        res.status(200);
        res.send(new Hal.Resource({
            hash: sha256(req.body)
        }, req.url));
    },

    list: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.list().then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                list: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not return a list',
                error: e
            }, req.url));
        });
    },

    info: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.info(req.email).then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                info: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not find info',
                error: e
            }, req.url));
        });
    },

    verify: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.verify(req.body).then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                verify: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not verify',
                error: e
            }, req.url));
        });
    },

    sign: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.sign(req.body.message, req.body.user).then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                sign: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not sign',
                error: e
            }, req.url));
        });
    },

    decrypt: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.decrypt(res.body.message).then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                decrypt: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not decrypt',
                error: e
            }, req.url));
        });
    },

    encrypt: function (req, res) {
        // console.log('app req headers: ', req.headers);
        gpg.encrypt(req.body.message, req.body.user, req.body.recipient).then(r => {
            console.log(r);
            res.status(200);
            res.send(new Hal.Resource({
                decrypt: r
            }, req.url));
        }).catch(e => {
            e => console.error(e);
            res.status(417);
            res.send(new Hal.Resource({
                message: 'can not encrypt',
                error: e
            }, req.url));
        });
    }
};