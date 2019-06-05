const AuthController = require('../controllers/auth.controller.js');

module.exports = function (app) {
    app.get('/list', AuthController.list);
    app.post('/hash', AuthController.hash);
    app.post('/info', AuthController.info);
    app.post('/verify', AuthController.verify);
    app.post('/sign', AuthController.sign);
    app.post('/decrypt', AuthController.decrypt);
    app.post('/encrypt', AuthController.encrypt);
};