<template>
    <div class="bg-gray-50 rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
        <router-link :to="{ name: 'product-single', params: { slug: product.slug }}">
            <img :src="product.photo" :alt="product.title" class="rounded-base pt-5 mb-6">
        </router-link>
        <div class="p-5">        
        <h3 class="font-bold text-lg">{{ product.title }}</h3>        
        <p class="text-sm text-gray-500 mt-1">Zahidul Islam</p>
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
            <!-- Discount Price -->
            <template v-if="product.reduced_price != null">
                <span class="text-lg font-bold text-indigo-600">
                    Tk {{ product.reduced_price }}
                </span>

                <!-- Original Price -->
                <span class="text-sm text-gray-400 line-through">
                    Tk {{ product.price }}
                </span>
            </template>
            <template v-else>
                <span class="text-lg font-bold text-indigo-600">
                    Tk {{ product.price }}
                </span>
            </template>
            </div>
            <button @click="cart.addItem(product, 1, 1)" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 inline-flex">
            Order Now
            </button>
        </div>
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
