/**
 * Knip configuration — Laravel project
 * @see https://knip.dev/reference/configuration
 */
export default {
  entry: ['resources/js/app.{js,ts}', 'resources/js/**/*.{js,ts,vue}', 'vite.config.{js,ts}', 'vite.modules.{js,ts}'],
  project: ['resources/js/**/*.{js,ts,vue}'],
  ignoreDependencies: [
    // Used via Laravel/Blade templates, not imported directly
    '@zairakai/mithril-scss',
    // Registered globally via app.js
    '@vueuse/core',
    // ORM layer — instantiated at runtime, not always statically imported
    'pinia-orm',
    // Utility library — re-exported or used via side effects
    '@zairakai/js-utils',
    // Vitest environment — referenced as string in vitest.config.js
    'jsdom',
    // Dev tooling — invoked via scripts/make, not imported
    'vue-tsc',
    '@vitest/coverage-v8',
    'vitest',
  ],
}
