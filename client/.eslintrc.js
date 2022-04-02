module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es2021: true,
  },
  // prettierを入れないと、eslintで競合してwarningになる。
  extends: [
    "plugin:vue/vue3-recommended",
    "@vue/typescript/recommended",
    "prettier",
  ],
  parserOptions: {
    ecmaVersion: 2021,
  },
  rules: {
    // console.logを許可
    "no-console": "off",
    // 'vue/max-attributes-per-line': 'off',
    // 'vue/singleline-html-element-content-newline': 'off',
    // 'vue/html-self-closing': [
    //   'error',
    //   {
    //     html: {
    //       void: 'always',
    //     },
    //   },
    // ],
    // 'prettier/prettier': ['error', {}],
    // ネーミングルールを追加
    "@typescript-eslint/naming-convention": [
      "error",
      {
        selector: "default",
        format: ["camelCase"],
      },
      {
        selector: ["property"],
        format: ["camelCase", "PascalCase", "chain-case"],
      },
      {
        selector: ["class", "enum", "interface", "typeAlias", "typeParameter"],
        format: ["PascalCase"],
      },
      {
        selector: "variable",
        modifiers: ["const"],
        format: ["camelCase", "UPPER_CASE"],
      },
    ],
  },
};
