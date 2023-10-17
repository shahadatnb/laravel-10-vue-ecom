import { ref, reactive, onBeforeMount } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    serverUrl: 'http://127.0.0.1:8000',
    baseUrl: 'http://127.0.0.1:5173',
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