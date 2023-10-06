import { createApp } from 'vue'
import router from './router/router.js'
import { createPinia } from 'pinia'
import '../public/lib/slick/slick.css'
import '../public/lib/slick/slick-theme.css'
import '../public/css/style.css'
import './style.css'
import '../public/lib/easing/easing.min.js'
import '../public/lib/slick/slick.min.js'
import App from './App.vue'
const pinia = createPinia()
createApp(App)
    .use(router)
    .use(pinia)
    .mount('#app')
