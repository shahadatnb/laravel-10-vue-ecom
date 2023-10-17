<template>
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>All Products</h1>
            </div>
            <div class="row align-items-center">
                <div v-for="product in products" :key="product.id" class="col-lg-3">
                    <Product :product="product"></Product>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onBeforeMount,ref} from "vue";
import { basicStore } from "../store/basic";
const basic = basicStore;
import Product from "./homepage/Product.vue";
import axios from "axios";
import { useRoute } from 'vue-router';
const route = useRoute()
const slug = route.params.slug
const products = ref([])
onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/latest-products?cat=${slug}`)
        .then(res => {
            products.value = res.data.data
        });
    //console.log(products)
})
</script>