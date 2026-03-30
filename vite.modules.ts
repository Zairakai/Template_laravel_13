import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import path from 'node:path'
import { loadEnv, type UserConfig } from 'vite'

// MODULE: Paths
// ================
export const paths = {
  js: 'resources/js',
  scss: 'resources/scss',
} as const

// MODULE: Entries
// ================
export const entries = {
  app: `${paths.js}/app.ts`,
  styles: `${paths.scss}/app.scss`,
} as const

export const entryPoints: string[] = Object.values(entries)

// MODULE: Aliases
// ================
export const aliases: Record<string, string> = {
  '@': path.resolve(process.cwd(), paths.js),
  '@scss': path.resolve(process.cwd(), paths.scss),
}

// MODULE: Environment
// ================
interface EnvVars {
  env: Record<string, string>
  isLocal: boolean
  sourcemap: boolean
}

export function getEnvironmentVars(mode: string): EnvVars {
  const env = loadEnv(mode, process.cwd(), '')
  const isLocal = 'local' === env['APP_ENV']
  const sourcemap = isLocal && 'true' === env['VITE_SOURCEMAP']

  return { env, isLocal, sourcemap }
}

// MODULE: Plugins
// ================
export function createPlugins() {
  return [
    laravel({
      input: entryPoints,
      refresh: ['resources/js/**', 'resources/scss/**', 'resources/views/**', 'routes/**'],
    }),
    vue(),
  ]
}

// MODULE: Build
// ================
export function createBuildConfig({ isLocal, sourcemap }: Pick<EnvVars, 'isLocal' | 'sourcemap'>) {
  return {
    cssSourcemap: sourcemap,
    minify: isLocal ? (false as const) : ('esbuild' as const),
    rollupOptions: {
      output: {
        assetFileNames: 'assets/[ext]/[name]-[hash][extname]',
        chunkFileNames: 'assets/js/[name]-[hash].js',
        entryFileNames: 'assets/js/[name]-[hash].js',
        manualChunks: {
          'vue-vendor': ['pinia', 'vue', 'vue-router'],
        },
      },
    },
    sourcemap,
  }
}

// MODULE: Server
// ================
export function createServerConfig({ env }: Pick<EnvVars, 'env'>) {
  return {
    cors: true,
    hmr: { host: 'localhost' },
    host: '0.0.0.0',
    port: parseInt(env['VITE_PORT'] ?? '5173'),
    strictPort: true,
    watch: {
      interval: 300,
      usePolling: true,
    },
  }
}

// MODULE: CSS
// ================
export function createCssConfig({ sourcemap }: Pick<EnvVars, 'sourcemap'>) {
  return {
    devSourcemap: sourcemap,
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler' as const,
        quietDeps: true,
      },
    },
  }
}

// Factory
// ================
export function createViteConfig({ command, mode }: { command: string; mode: string }): UserConfig {
  const { env, isLocal, sourcemap } = getEnvironmentVars(mode)

  return {
    build: createBuildConfig({ isLocal, sourcemap }),
    css: createCssConfig({ sourcemap }),
    plugins: createPlugins(),
    resolve: { alias: aliases },
    server: createServerConfig({ env }),
  }
}
