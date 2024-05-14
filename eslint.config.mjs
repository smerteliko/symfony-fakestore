import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";


export default [
  {languageOptions: { globals: {...globals.browser, ...globals.node} }},
  pluginJs.configs.recommended,
  ...pluginVue.configs["flat/essential"],
  ...pluginVue.configs["flat/recommended"],
  {
    rules: {
      "vue/this-in-template": "off",
    }
  }
];