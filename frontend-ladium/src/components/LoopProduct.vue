<script setup>
import { wishlist } from '../store/wishlist';
const props  = defineProps(['product']);
import {cart} from '../store/cart'
</script>

<template>

<figure class="">
    
    <div class="relative group">
        <router-link :to="{ name: 'product-single', params: { slug: product.slug }}">
            <img class="w-full h-full rounded-lg" :src="product.photo" :alt="product.title" />
        </router-link>
        <div class="group-hover:block hidden absolute left-0 top-[75%] w-full "        >
            <div class="flex flex-wrap justify-center gap-2">
                <span @click="wishlist.toggleWishlist(product)"
                class="px-[.625rem] py-[.3125rem] bg-black text-white rounded-[.3125rem] text-2xl cursor-pointer"
                >
                    <font-awesome-icon v-if="wishlist.isWishListed(product)" :icon="['fas', 'heart']" />
                    <font-awesome-icon v-else :icon="['far', 'heart']" />
                </span>
                <!-- <span
                class="px-[.625rem] py-[.3125rem] bg-black text-white rounded-[.3125rem] text-2xl"
                ><i class="fa-solid fa-eye"></i
                ></span>
                <span
                class="px-[.625rem] py-[.3125rem] bg-black text-white rounded-[.3125rem] text-2xl"
                ><i class="fa-solid fa-magnifying-glass-plus"></i
                ></span> -->
            </div>
        </div>
    </div>
    <div class="pt-4">
        <router-link :to="{ name: 'product-single', params: { slug: product.slug }}" class="py-[.625rem] mb-4">
        <h2 class="text-sm md:text-md uppercase font-semibold text-center">{{ product.title }}</h2>
        </router-link>
        <div class="flex pt-3 justify-evenly">
            <div class="text-md font-semibold">
                <template v-if="product.reduced_price != null">
                    <span>৳{{ product.reduced_price }}</span>
                    <span class="text-gray-400 line-through mx-2 text-sm">৳{{ product.price }}</span>
                </template>
                <template v-else>
                    <span class="text-md">৳{{ product.price }}</span>
                </template>
            </div>
            <div class="text-md font-semibold">
            <a v-if="product.product_type === 'simple'" href="#" @click="cart.addItem(product)"
            class="block text-black">Buy Now</a>
            <router-link v-if="product.product_type === 'variant'" :to="{ name: 'product-single', params: { slug: product.slug }}"
            class="uppercase text-black">Details</router-link>
        </div>
        </div>
    </div>
</figure>
</template>