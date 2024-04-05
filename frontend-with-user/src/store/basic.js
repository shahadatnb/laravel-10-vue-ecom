import { reactive } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    serverUrl: 'http://127.0.0.1:8000',//'https://ecom.asiancoder.com',//////'http://laravel-10-vue-ecom.test' //
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