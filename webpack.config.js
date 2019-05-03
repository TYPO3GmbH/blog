"use strict";

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: {
        frontend: './Resources/Private/Scss/frontend.scss',
    },
    output: {
        path: __dirname + '/Resources/Public'
    },
    optimization: {
        minimizer: [
            new OptimizeCSSAssetsPlugin({})
        ]
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
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
                                require('autoprefixer')(
                                    {
                                        'browsers': ['> 1%', 'last 2 versions']
                                    }
                                )
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
            filename: 'Css/[name].min.css',
        })
    ]
};
