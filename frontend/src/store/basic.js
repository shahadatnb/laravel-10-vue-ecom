import { ref, reactive, onBeforeMount } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    //serverUrl: 'https://ecom.asiancoder.com',
    serverUrl: 'https://backend.rajshahibazar.com',
    //serverUrl: 'http://localhost/laravel/laravel-10-vue-ecom/public',
    baseUrl: 'https://rajshahibazar.com',
    settings: [],
    init() {
        axios.get(`${basicStore.serverUrl}/api/config`)
        .then(res => {
            basicStore.settings = res.data
        });
    }
})

basicStore.init()

export {
    basicStore
}