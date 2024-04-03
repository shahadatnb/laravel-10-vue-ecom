<script setup>
import { ref, onBeforeMount } from 'vue'
import { basicStore } from "../store/basic.js";
const basic = basicStore;
import { useRoute } from 'vue-router';
import axios from 'axios'
const route = useRoute()
const slug = route.params.slug
const page = ref()
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/page/${slug}`)
        .then(res => {
            page.value = res.data
        });
        //console.log(page.value)
})
</script>
<template>
    <!-- login -->
    <div class="contain py-16">
        <div class="mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">{{ page.title }}</h2>
            <div class="content" v-html="page.body"></div>
        </div>
    </div>
    <!-- ./login -->
</template>