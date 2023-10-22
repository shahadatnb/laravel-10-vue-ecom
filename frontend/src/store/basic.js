import { ref, reactive, onBeforeMount } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    serverUrl: 'https://ecom.asiancoder.com',
    baseUrl: 'https://vueshop.asiancoder.com',
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