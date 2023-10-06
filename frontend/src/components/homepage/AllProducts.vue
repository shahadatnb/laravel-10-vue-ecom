<template>
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>All Products</h1>
            </div>
            <div class="row align-items-center">
                <div v-for="product in products" :key="product.id" class="col-lg-3">
                    <div class="product-item">
                        <div class="product-image">
                            <router-link :to="{ name: 'product-single', params: { slug: product.slug }}">
                                <img :src="product.photo" alt="Product Image">
                            </router-link>

                        </div>
                        <div class="product-title-here">
                            <h3>{{ product.title }}</h3>
                        </div>
                        <div class="product-price">
                            <h3><span>৳</span>{{ product.price }}</h3>
                            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {onBeforeMount,ref} from "vue";
import axios from "axios";
const products = ref([])
onBeforeMount(()=>{
    axios.get('http://127.0.0.1:8000/api/latest-products?take=8')
        .then(res => {
            products.value = res.data.data
        });
    console.log(products)
})
</script>

<style scoped>

</style>
