import { reactive } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    serverUrl: 'https://backend.ladiumbd.com',
    //serverUrl: 'http://localhost:8000',
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