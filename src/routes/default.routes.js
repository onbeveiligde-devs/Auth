const DefaultController = require('../controllers/default.controller');

module.exports = (app) => {
    app.all('/', DefaultController.index);
    app.all('*', DefaultController.notfound);
};