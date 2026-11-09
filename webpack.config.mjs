"use strict";

import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import RemoveEmptyScriptsPlugin from 'webpack-remove-empty-scripts';
import TerserPlugin from 'terser-webpack-plugin';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default {
    mode: 'production',
    entry: {
        'frontend': './Resources/Private/Scss/frontend/frontend.scss',
        'backend': './Resources/Private/Scss/backend/backend.scss',
        'pagelayout': './Resources/Private/Scss/backend/pagelayout.scss',
        'datatables': './Resources/Private/JavaScript/backend/datatables.js',
        'mass-update': './Resources/Private/JavaScript/backend/mass-update.js',
        'setup-wizard': './Resources/Private/JavaScript/backend/setup-wizard.js',
    },
    target: 'es2020',
    externals: {
        "jquery": "jquery",
        "bootstrap": "bootstrap",
        "@typo3/backend/modal": "@typo3/backend/modal.js",
        "@typo3/backend/severity": "@typo3/backend/severity.js"
    },
    experiments: {
        outputModule: true
    },
    output: {
        module: true,
        filename: '[name].js',
        path: path.resolve(__dirname, 'Resources/Public/JavaScript'),
    },
    optimization: {
        minimizer: [
            new TerserPlugin({}),
        ]
    },
    module: {
        rules: [
            {
                test: /\.(css|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {}
                    },
                    {
                        loader: "postcss-loader",
                        options: {}
                    },
                    {
                        loader: "sass-loader",
                        options: {}
                    }
                ]
            }
        ]
    },
    plugins: [
        new RemoveEmptyScriptsPlugin(),
        new MiniCssExtractPlugin({
            filename: '../Css/[name].min.css',
        })
    ]
};
