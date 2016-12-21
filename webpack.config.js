const webpack = require('webpack');
const path = require('path');

const BUILD_DIR = path.resolve(__dirname + '/public');
const APP_DIR = path.resolve(__dirname + '/src');

var config = {
    entry: APP_DIR + '/index.jsx',

    output: {
        path: BUILD_DIR,
        filename: 'index.js'
    },

    devServer: {
        inline: true,
        port: 8000
    },
    module: {
        loaders: [
            {
                test: /\.jsx?/,
                include: APP_DIR,
                loader: 'babel-loader'
            }
        ]
    }
}

module.exports = config;