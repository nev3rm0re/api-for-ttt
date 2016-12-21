const webpack = require('webpack');
const path = require('path');

const BUILD_DIR = path.resolve(__dirname + '/public');
const APP_DIR = path.resolve(__dirname + '/src/js');

var config = {
    entry: APP_DIR + '/index.js',

    output: {
        path: BUILD_DIR,
        filename: 'tictactoe.js'
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
    },
    externals: {
        'react': 'React',
        'react-dom': 'ReactDOM'
    }

}

module.exports = config;