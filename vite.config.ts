import { defineConfig } from 'vite'
import { createViteConfig } from './vite.modules'

export default defineConfig(({ command, mode }) => createViteConfig({ command, mode }))
