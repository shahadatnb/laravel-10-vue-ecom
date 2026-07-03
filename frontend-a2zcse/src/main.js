import { createApp } from 'vue'
import router from './router/router.js'
import 'vue3-toastify/dist/index.css';
import './style.css'
import App from './App.vue'
createApp(App)
    .use(router)
    //.use(Vue3Toasity)
    .mount('#app')
