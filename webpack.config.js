"use strict";

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: {
        frontend: './Resources/Private/Scss/frontend/frontend.scss',
        pagelayout: './Resources/Private/Scss/backend/pagelayout.scss',
        backend: './Resources/Private/Scss/backend/backend.scss',
        Datatables: './Resources/Private/JavaScript/backend/Datatables.js',
        MassUpdate: './Resources/Private/JavaScript/backend/MassUpdate.js',
        SetupWizard: './Resources/Private/JavaScript/backend/SetupWizard.js',
    },
    externals: {
        "jquery": "jquery",
        "bootstrap": "bootstrap",
        "TYPO3/CMS/Backend/Modal": "TYPO3/CMS/Backend/Modal",
        "TYPO3/CMS/Backend/Severity": "TYPO3/CMS/Backend/Severity"
    },
    output: {
        libraryTarget: 'amd',
        path: __dirname + '/Resources/Public/JavaScript',
    },
    optimization: {
        minimizer: [
            new TerserPlugin({}),
            new OptimizeCSSAssetsPlugin({})
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
                        options: {
                            plugins: () => [
                                require('autoprefixer')
                            ]
                        }
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
        new FixStyleOnlyEntriesPlugin(),
        new MiniCssExtractPlugin({
            filename: '../Css/[name].min.css',
        })
    ]
};
