import { reactive } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    //serverUrl: 'http://127.0.0.1:8000',
    serverUrl: 'http://localhost/laravel/laravel-10-vue-ecom/public',
    //serverUrl: 'https://backend.rajshahibazar.com',
    //serverUrl: 'https://ecom.asiancoder.com',
    //serverUrl: 'http://laravel-10-vue-ecom.test',
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