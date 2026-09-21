import { fileURLToPath, URL } from 'node:url'

import vue from '@vitejs/plugin-vue'
import prefixSelector from 'postcss-prefix-selector'
import { defineConfig } from 'vite'

const outDir = '../'
const assetFileNames = 'assets/components/managerbuttons/css/mgr/vue-dist/[name].min[extname]'
const chunkFileNames = 'assets/components/managerbuttons/js/mgr/vue-dist/[name]-[hash].min.js'
const entryFileNames = 'assets/components/managerbuttons/js/mgr/vue-dist/[name].min.js'

const ENTRIES = {
  home: 'src/entries/home.js',
  widget: 'src/entries/widget.js',
}

const postcssPlugins = [
  prefixSelector({
    prefix: '.vueApp',
    exclude: [
      /^:root/,
      /^html/,
      /^body/,
      /^@keyframes/,
      /^@-webkit-keyframes/,
      /^@font-face/,
      /^@media/,
      /^\.vueApp/,
      /^\.pi/,
      /^\.p-/,
      /^\.icon/,
      /^\[data-p-/,
      /^\[data-pc-/,
    ],
    transform: (prefix, selector) => {
      if (selector === ':root') return '.vueApp'
      if (/^#managerbuttons-/.test(selector)) return selector
      if (/^\.managerbuttons-/.test(selector)) return selector
      if (selector.startsWith('.vueApp')) return selector
      return prefix + ' ' + selector
    },
  }),
]

const EXTERNAL = [/^vue$/, /^vue\//, /^pinia$/, /^pinia\//, /^primevue$/, /^primevue\//, /^@vuetools\//]

export default defineConfig(({ command }) => {
  if (command === 'serve') {
    return {
      plugins: [vue()],
      resolve: {
        alias: { '@': fileURLToPath(new URL('./src', import.meta.url)) },
      },
      css: { postcss: { plugins: postcssPlugins } },
    }
  }

  const buildEntry = process.env.BUILD_ENTRY
  const input = buildEntry ? { [buildEntry]: ENTRIES[buildEntry] } : ENTRIES

  return {
    build: {
      outDir,
      emptyOutDir: false,
      rollupOptions: {
        external: EXTERNAL,
        input,
        output: buildEntry
          ? {
              assetFileNames,
              chunkFileNames,
              entryFileNames,
              inlineDynamicImports: true,
            }
          : { assetFileNames, chunkFileNames, entryFileNames },
      },
      cssMinify: false,
      minify: 'esbuild',
    },
    plugins: [vue()],
    resolve: {
      alias: { '@': fileURLToPath(new URL('./src', import.meta.url)) },
    },
    css: { postcss: { plugins: postcssPlugins } },
  }
})
