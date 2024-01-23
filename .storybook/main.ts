import type { StorybookConfig } from '@storybook/nextjs';
const config: StorybookConfig = {
  staticDirs: ['../public'],
  stories: ['./../resources/**/*.mdx', './../resources/**/*.stories.@(js|jsx|ts|tsx)'],
  addons: [
    '@storybook/addon-links',
    '@storybook/addon-essentials',
    '@storybook/addon-interactions',
  ],
  framework: {
    name: '@storybook/nextjs',
    options: {},
  },
  features: {
    storyStoreV7: false, // 👈 Opt out of on-demand story loading
  },
  docs: {
    autodocs: 'tag',
  },
  core: {
    builder: '@storybook/builder-webpack5',
  },
  webpackFinal: async config => {
    const imageRule = config.module?.rules?.find(rule => {
      const test = (rule as { test: RegExp }).test

      if (!test) {
        return false
      }

      return test.test('.svg')
    }) as { [key: string]: any }

    imageRule.exclude = /\.svg$/

    config.module?.rules?.push({
      test: /\.svg$/,
      //use: ['@svgr/webpack']
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
    })

    return config
  }
};
export default config;
