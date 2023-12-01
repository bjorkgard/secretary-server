import antfu from '@antfu/eslint-config'

export default antfu({
  stylistic: true,
  rules: {
    'style/key-spacing': ['error', {
        multiLine: {
          beforeColon: false,
          afterColon: true,
        },
        align: {
          beforeColon: false,
          afterColon: true,
          on: 'value',
        },
      }],
  },
  ignores: [
    '.github/**',
    'public/vendor/**',
  ],
})
