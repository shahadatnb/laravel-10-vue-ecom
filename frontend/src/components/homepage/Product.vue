<template>
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
            <button type="button" @click="cart.addItem(product)" class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</button>
        </div>
    </div>
</template>

<script setup>
const props  = defineProps(['product']);
import {cart} from '../../store/cart'
//console.log(product)
</script>

<style scoped>

</style>
