import { ref, reactive, onBeforeMount } from 'vue'
import axios from 'axios'
const basicStore = reactive({
    serverUrl: 'http://127.0.0.1:8000',
    settings: [],
    getSettings () {
        axios.get(`${this.serverUrl}/api/posts?post_type=slide`)
        .then(res => {
            console.log(res.data)
            this.settings = res.data
        });
    }
})

onBeforeMount(() => {
    basicStore.getSettings();
  });

export {
    basicStore
}