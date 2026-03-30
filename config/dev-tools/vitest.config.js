import vue from '@vitejs/plugin-vue'
import baseConfig from '@zairakai/js-dev-tools/config/vitest.config.js'
import { defineConfig, mergeConfig } from 'vitest/config'

export default mergeConfig(
  baseConfig,
  defineConfig({
    plugins: [vue()],
    test: {
      environment: 'jsdom',
      coverage: {
        exclude: [
          'node_modules/**',
          'dist/**',
          'build/**',
          'vendor/**',
          'public/**',
          'storage/**',
          '**/*.config.*',
          '**/*.d.ts',
        ],
      },
    },
  })
)
