import { createApp } from 'vue'
import router from './router/router.js'
//import axios from 'axios'
import './style.css'
import App from './App.vue'
createApp(App)
    .use(router)
    // .use({
    //     setup() {
    //         const settings = ref([])
    //         axios.get(`${basicStore.serverUrl}/api/config`)
    //         .then(res => {
    //             settings = res.data
    //         });
    //         return {
    //             settings
    //         }
    //     }
    // })
    .mount('#app')
