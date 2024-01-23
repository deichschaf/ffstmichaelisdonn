module.exports = {
  displayName: 'shop-feature-core',
  preset: './jest.preset.js',
  transform: {
    '.+\\.(webp|png|jpg)$': 'jest-transform-stub',
    '^.+\\.svg$': '<rootDir>/src/__mocks__/fileTransform.js',
    '^.+\\.[tj]sx?$': 'babel-jest',
  },
  moduleNameMapper: {
    '.+\\.(scss|css)$': 'identity-obj-proxy',
  },
  moduleFileExtensions: ['ts', 'tsx', 'js', 'jsx'],
  reporters: [
    'default',
    [
      'jest-junit',
      {
        suiteName: 'shop-feature-core',
        outputDirectory: 'coverage/libs/shop/feature-core',
        ancestorSeparator: ' > ',
        addFileAttribute: 'true',
        outputName: 'junit.xml',
      },
    ],
  ],
  coverageDirectory: '../../../coverage/libs/shop/feature-core',
};
