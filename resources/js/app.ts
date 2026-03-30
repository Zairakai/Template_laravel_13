import VueComponents from '@zairakai/vue-components'
import { createPinia } from 'pinia'
import { createApp } from 'vue'
import App from './App.vue'
import './bootstrap'
import router from './router'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(VueComponents)

app.mount('#app')
