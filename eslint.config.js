import { defineConfig } from 'eslint-define-config';
import eslintPluginSecurity from 'eslint-plugin-security';
import vuePlugin from 'eslint-plugin-vue';
import vueParser from 'vue-eslint-parser';

export default defineConfig([
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
      'vue/require-default-prop': 'off', // Desativa a regra para exigir prop default em Vue
      'security/detect-object-injection': 'warn', // Prevenir injeção de objetos
      'security/detect-non-literal-require': 'warn', // Detecta require com argumentos não literais
      'security/detect-child-process': 'warn', // Detecta vulnerabilidades com child_process
    },
  },
]);
