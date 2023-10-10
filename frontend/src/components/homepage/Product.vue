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
            <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Order Now</a>
        </div>
    </div>
</template>

<script setup>
const props  = defineProps(['product']);
//console.log(product)
</script>

<style scoped>

</style>
