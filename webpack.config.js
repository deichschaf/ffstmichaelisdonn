const path = require('path');
const ForkTsCheckerWebpackPlugin = require('fork-ts-checker-webpack-plugin');
require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const webpack = require('webpack');
const dotenv = require('dotenv').config({ path: __dirname + '/.env' });
const Dotenv = require('dotenv-webpack');

module.exports = {
  module: {
    rules: [
      {
        test: /\.(png|jpg|gif)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: '../images/',
              publicPath: '../images/',
              useRelativePaths: true,
              esModule: false,
            },
          },
        ],
      },
      {
        test: /\.(ts|js)x?$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader?cacheDirectory',
          options: {
            presets: ['@babel/preset-env', '@babel/preset-react', '@babel/preset-typescript'],
            sourceMap: false,
          },
        },
      },
      {
        test: /\.svg$/,
        use: {
          loader: 'svg-url-loader',
          options: {
            encoding: 'base64',
            name: '[name].[ext]',
            outputPath: '/../svgs/',
            limit: 10240,
            // make all svg images to work in IE
            iesafe: true,
          },
        },
      },
      {
        test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: '/../fonts/',
              esModule: false,
            },
          },
        ],
      },
      {
        test: /.scss$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].css',
              chunkFilename: '[name].[contenthash].css',
              outputPath: 'css/',
              esModule: false,
              sourceMap: false,
            },
          },
          {
            loader: 'extract-loader',
            options: {
              esModule: false,
              sourceMap: false,
            },
          },
          {
            loader: 'css-loader',
            options: {
              esModule: false,
              sourceMap: false,
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: false,
              sassOptions: {
                outputStyle: 'compressed',
              },
            },
          },
        ],
      },
    ],
  },
  optimization: {
    minimize: true,
    minimizer: [
      `...`,
      new CssMinimizerPlugin({
        test: /\.foo\.css$/i,
        parallel: true,
        minimizerOptions: {
          level: {
            1: {
              roundingPrecision: 'all=3,px=5',
            },
          },
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        },
        minify: CssMinimizerPlugin.cleanCssMinify,
      }),
    ],
    // runtimeChunk: 'single',
    // splitChunks: {
    //   cacheGroups: {
    //     vendor: {
    //       test: /[\\/]node_modules[\\/]/,
    //       name: 'vendors',
    //       chunks: 'all',
    //     },
    //   },
    // },
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js', '.jsx'],
    fallback: {
      // assert: require.resolve('assert'),
      assert: false,
      buffer: require.resolve('buffer'),
      console: require.resolve('console-browserify'),
      constants: require.resolve('constants-browserify'),
      crypto: require.resolve('crypto-browserify'),
      domain: require.resolve('domain-browser'),
      events: require.resolve('events'),
      http: require.resolve('stream-http'),
      https: require.resolve('https-browserify'),
      // os: require.resolve('os-browserify/browser'),
      os: false,
      path: require.resolve('path-browserify'),
      punycode: require.resolve('punycode'),
      // process: require.resolve('process/browser'),
      querystring: require.resolve('querystring-es3'),
      stream: require.resolve('stream-browserify'),
      string_decoder: require.resolve('string_decoder'),
      sys: require.resolve('util'),
      timers: require.resolve('timers-browserify'),
      tty: require.resolve('tty-browserify'),
      url: require.resolve('url'),
      util: require.resolve('util'),
      vm: require.resolve('vm-browserify'),
      zlib: require.resolve('browserify-zlib'),
      'crypto-browserify': require.resolve('crypto-browserify'), // if you want to use this module also don't forget npm i crypto-browserify
    },
  },
  entry: ['./resources/js/index.js', './resources/sass/app.scss'],
  output: {
    path: path.resolve(__dirname, 'public/'),
    filename: 'js/bundle.js',
  },
  // output: {
  //   filename: '[name].[contenthash].js',
  //   path: path.resolve(__dirname, 'dist'),
  //   clean: true,
  // },
  devServer: {
    // contentBase: path.join(__dirname, 'public/js'),
    compress: true,
    port: 4000,
    // inline: false,
    // allowedHosts: 'all',
    // client: {
    //   logging: 'info',
    //   overlay: true,
    //   errors: true,
    //   warnings: false,
    //   progress: true,
    // },
  },
  plugins: [
    new Dotenv(),
    new ForkTsCheckerWebpackPlugin({
      async: true,
    }),
    new webpack.ProvidePlugin({
      process: 'process/browser',
    }),
  ],
  watchOptions: {
    ignored: '**/node_modules',
    aggregateTimeout: 200,
    poll: 1000,
    followSymlinks: true,
    stdin: true,
  },
  // watch: true,
};
