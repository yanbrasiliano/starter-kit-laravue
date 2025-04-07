import eslintPluginSecurity from 'eslint-plugin-security';
import vuePlugin from 'eslint-plugin-vue';
import vueParser from 'vue-eslint-parser';

export default [
  {
    languageOptions: {
      parser: vueParser,
      parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
        ecmaFeatures: {
          jsx: false,
        },
      },
      globals: {
        node: true,
      },
    },
    plugins: {
      vue: vuePlugin,
      security: eslintPluginSecurity,
    },
    rules: {
      'vue/require-default-prop': 'off',
      'security/detect-object-injection': 'warn',
      'security/detect-non-literal-require': 'warn',
      'security/detect-child-process': 'warn',
    },
  },
];
