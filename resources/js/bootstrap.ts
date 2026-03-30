import { createLaravelClient } from '@zairakai/js-http-client'

declare global {
  interface Window {
    axios: ReturnType<typeof createLaravelClient>
  }
}

window.axios = createLaravelClient()
