const Hal = require('hal');

module.exports = {
    index: function (req, res) {
        let resource = new Hal.Resource({
            'message': 'Hello world!'
        }, req.url);

        let array = [
            'list',
            'hash',
            'verify',
            'sign',
            'decrypt',
            'encrypt'
        ];
        array.forEach(element => {
            resource.link(element, '/' + element);
        });

        res.send(resource);
    },

    notfound: function (req, res) {
        res.status(404);
        res.send(new Hal.Resource({
            'message': 'Not found',
            'status': 404
        }, req.url));
    }
};