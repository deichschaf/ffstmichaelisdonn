// preview.config.js

/** @type {import("@previewjs/config").PreviewConfig} */
module.exports = {
  /**
   * Configure custom aliases (auto-detected if you use TypeScript).
   */
  alias: {
    foo: "src/foo"
  },

  /**
   * Configure a public assets directory.
   */
  publicDir: "public",

  /**
   * Set up a custom component to wrap around previewed components.
   *
   * Useful to set up context providers and global CSS.
   */
  wrapper: {
    path: "__previewjs__/Wrapper.tsx",
    componentName: "Wrapper"
  },

  /**
   * Specify a custom Vite configuration.
   *
   * See https://vitejs.dev/config.
   */
  vite: {
  }
};
