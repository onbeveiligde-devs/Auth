const express = require('express');
const bodyParser = require('body-parser');

const defaultRoutes = require('./routes/default.routes');
const authRoutes = require('./routes/auth.routes');

// takes incoming requests and handles them
const app = express();

// tell app to use json body parser
// has to be called before routes!
app.use(bodyParser.json({
    extended: true
}));

authRoutes(app);
defaultRoutes(app); // needs to be last. Otherwise it replaces the existing endpoinds

module.exports = {
    app: app
};