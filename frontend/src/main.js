import { createApp } from 'vue'
import router from './router/router.js'
import $ from 'jquery';
window.$ = window.jQuery = $;
import 'slick-carousel'; // This makes the .slick() method available on jQuery objects
import 'jquery.easing'; // This imports the easing functions
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';
import './style.css'
import App from './App.vue'
createApp(App)
    .use(router)
    .use(Vue3Toasity)
    .mount('#app')
