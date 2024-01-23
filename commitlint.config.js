module.exports = {
    rules: {
        'type-case': [2, 'always', ['lower-case']],
        'scope-case': [2, 'always', ['upper-case']]
    },
    extends: [
        '@commitlint/config-conventional'
    ]
};