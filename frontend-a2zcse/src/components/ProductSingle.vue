<template>
  <!-- Breadcrumb -->
  <section class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-6 py-6">
      <ul class="flex items-center flex-wrap gap-2 text-sm text-gray-300">
        <li><router-link to="/" class="hover:text-white">Home</router-link></li>
        <li>/</li>
        <li><router-link to="/products" class="hover:text-white">Books</router-link></li>
        <li>/</li>
        <li class="text-white font-medium truncate max-w-[220px]">{{ product.title }}</li>
      </ul>
    </div>
  </section>

  <!-- Product Detail -->
  <section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid lg:grid-cols-2 gap-10 items-start">

      <!-- Gallery -->
      <div>
        <div class="bg-gray-50 rounded-2xl shadow-sm p-6 flex items-center justify-center">
          <img :src="activeImage" :alt="product.title" class="max-h-[420px] w-full rounded-xl object-contain" />
        </div>

        <div v-if="product.galleries && product.galleries.length > 0" class="mt-4 grid grid-cols-5 gap-3">
          <button
            type="button"
            class="rounded-lg overflow-hidden border-2 transition"
            :class="activeImage === product.photo ? 'border-indigo-600' : 'border-transparent hover:border-indigo-300'"
            @click="activeImage = product.photo"
          >
            <img :src="product.photo" alt="Cover" class="w-full h-20 object-cover" />
          </button>
          <button
            v-for="gallery in product.galleries"
            :key="gallery.id"
            type="button"
            class="rounded-lg overflow-hidden border-2 transition"
            :class="activeImage === gallery.photo ? 'border-indigo-600' : 'border-transparent hover:border-indigo-300'"
            @click="activeImage = gallery.photo"
          >
            <img :src="gallery.photo" alt="Gallery image" class="w-full h-20 object-cover" />
          </button>
        </div>
      </div>

      <!-- Info -->
      <div>
        <span
          class="inline-flex text-sm font-semibold px-3 py-1 rounded-full"
          :class="product.quantity > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-red-50 text-red-600'"
        >
          {{ product.quantity > 0 ? 'In Stock' : 'Out of Stock' }}
        </span>

        <h1 class="mt-4 text-3xl md:text-4xl font-bold leading-tight">{{ product.title }}</h1>
        <p v-if="product.author" class="text-gray-500 mt-2">Author: {{ product.author }}</p>

        <div class="mt-5 flex flex-wrap items-center gap-3">
          <span class="text-2xl md:text-3xl font-bold text-indigo-600">
            Tk {{ product.reduced_price || product.price }}
          </span>
          <span
            v-if="product.reduced_price && Number(product.reduced_price) < Number(product.price)"
            class="text-gray-400 line-through text-lg"
          >
            Tk {{ product.price }}
          </span>
          <span
            v-if="discountAmount > 0"
            class="bg-red-50 text-red-600 text-sm font-semibold px-3 py-1 rounded-full"
          >
            Save Tk {{ discountAmount }}
          </span>
        </div>

        <p v-if="product.short_description" class="mt-4 text-gray-600 leading-relaxed">
          {{ product.short_description }}
        </p>

        <!-- Color -->
        <div v-if="product.colors && product.colors != ''" class="mt-6">
          <h4 class="text-sm font-semibold mb-2">Color</h4>
          <div class="flex gap-2">
            <button
              v-for="(color, index) in product.colors"
              :key="index"
              type="button"
              class="w-9 h-9 rounded-full border-2 transition"
              :class="product.selectedColor === color ? 'border-indigo-600' : 'border-gray-200'"
              :style="{ backgroundColor: color }"
              @click="selectColor(index)"
            ></button>
          </div>
        </div>

        <!-- Weight / Size -->
        <div v-if="product.sizes && product.sizes != ''" class="mt-6">
          <h4 class="text-sm font-semibold mb-2">Weight</h4>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="(size, index) in product.sizes"
              :key="index"
              type="button"
              class="px-4 py-2 rounded-lg border text-sm font-medium transition"
              :class="product.selectedSize === size
                ? 'border-indigo-600 bg-indigo-50 text-indigo-700'
                : 'border-gray-300 text-gray-600 hover:border-indigo-400'"
              @click="selectSize(index)"
            >
              {{ size }}
            </button>
          </div>
        </div>

        <!-- Quantity -->
        <div class="mt-6">
          <h4 class="text-sm font-semibold mb-2">Quantity</h4>
          <div class="inline-flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <button
              type="button"
              class="px-4 py-3 hover:bg-gray-100 text-lg font-bold"
              aria-label="Decrease quantity"
              @click="decreaseQuantity()"
            >−</button>
            <input
              type="text"
              v-model="quantity"
              class="w-16 text-center border-x border-gray-300 py-3 focus:outline-none"
            />
            <button
              type="button"
              class="px-4 py-3 hover:bg-gray-100 text-lg font-bold"
              aria-label="Increase quantity"
              @click="increaseQuantity()"
            >+</button>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 space-y-3">
          <button
            type="button"
            class="w-full bg-indigo-600 text-white py-3.5 rounded-lg font-semibold hover:bg-indigo-700 flex items-center justify-center gap-2"
            @click="cart.addItem(product, quantity)"
          >
            🛍️ Add to Cart
          </button>

          <button
            type="button"
            class="w-full bg-amber-500 text-white py-3.5 rounded-lg font-semibold hover:bg-amber-600 shadow-lg shadow-amber-100"
            @click="cart.addItem(product, quantity, 1)"
          >
            ক্যাশ অন ডেলিভারি তে অর্ডার করুন
          </button>

          <div class="grid grid-cols-2 gap-3">
            <a
              :href="basic.settings.messenger"
              target="_blank"
              class="border border-gray-300 text-gray-700 py-3 rounded-lg font-medium text-center hover:border-indigo-400 hover:text-indigo-600"
            >
              💬 Messenger
            </a>
            <a
              :href="whatapp"
              target="_blank"
              class="border border-gray-300 text-gray-700 py-3 rounded-lg font-medium text-center hover:border-green-400 hover:text-green-600"
            >
              📱 WhatsApp
            </a>
          </div>
        </div>

        <!-- Trust badges -->
        <div class="mt-8 bg-gray-50 rounded-xl p-4 space-y-3 text-sm text-gray-600">
          <div class="flex gap-2">
            <span>🚚</span>
            <p>Delivery time: Inside Dhaka 1–2 days, outside Dhaka 2–4 days.</p>
          </div>
          <div class="flex gap-2">
            <span>📞</span>
            <p>Our team will call you before dispatching the order.</p>
          </div>
          <div class="flex gap-2">
            <span>🔒</span>
            <p>Your information is used only for order confirmation and delivery.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Description -->
    <div class="mt-14">
      <div class="border-b border-gray-200">
        <nav class="flex gap-8">
          <button type="button" class="pb-4 border-b-2 border-indigo-600 text-indigo-600 font-semibold">
            Description
          </button>
        </nav>
      </div>
      <div class="py-8 prose max-w-none text-gray-600" v-html="product.description"></div>
    </div>
  </section>

  <!-- Related Products -->
  <section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold">Related Books</h2>
        <router-link to="/products" class="text-indigo-600 font-medium hover:underline">See More</router-link>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <Product v-for="p in products" :key="p.id" :product="p"></Product>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, watch, computed, ref } from 'vue'
import Product from "./homepage/Product.vue";
import { cart } from "../store/cart";
import axios from 'axios'
import { basicStore } from "../store/basic.js";
const basic = basicStore;
import { useRoute } from 'vue-router';

const route = useRoute()
const products = ref([])
const slug = route.params.slug
const quantity = ref(1);
const product_title_original = ref("");
const activeImage = ref('');
const whatapp = "https://wa.me/" + basic.settings.sitePhone
const product = reactive({})

const discountAmount = computed(() => {
  if (!product.price || !product.reduced_price) return 0;
  const diff = Number(product.price) - Number(product.reduced_price);
  return diff > 0 ? diff : 0;
});

watch(() => route.params.slug, fetchData, { immediate: true });

async function fetchData(data) {
  basic.loading = true
  axios.get(`${basic.serverUrl}/api/single-product/${data}`)
    .then(res => {
      product_title_original.value = res.data.data.title;
      product.id = res.data.data.id
      product.title = res.data.data.title
      product.author = res.data.data.author
      product.price = res.data.data.price
      product.reduced_price = res.data.data.reduced_price
      product.quantity = res.data.data.quantity
      product.short_description = res.data.data.short_description
      product.description = res.data.data.description
      product.photo = res.data.data.photo
      product.galleries = res.data.data.galleries
      product.categories = res.data.data.categories
      product.product_type = res.data.data.product_type;
      product.colors = res.data.data.colors;
      product.sizes = res.data.data.sizes;
      product.variants = res.data.data.variants;

      activeImage.value = product.photo;

      if (product.product_type == "variant") {
        product.selectedColor = product.variants[0].color_id;
        product.selectedSize = product.variants[0].size_id;
        let selectedVariant = product.variants.find(
          (variant) =>
            variant.color_id == product.selectedColor &&
            variant.size_id == product.selectedSize
        );
        if (selectedVariant) {
          product.quantity = selectedVariant.quantity;
          product.variant_id = selectedVariant.id;
        }
      } else {
        product.quantity = product.variants[0].quantity;
        product.variant_id = product.variants[0].id;
      }

      document.title = product.title;
      document
        .querySelector("meta[property='og:image']")
        .setAttribute("content", product.photo);
      document
        .querySelector("meta[property='og:title']")
        .setAttribute("content", product.title);
      basic.loading = false;
    });

  axios.get(`${basic.serverUrl}/api/latest-products?take=8&orderBy=id&orderType=random`)
    .then(res => {
      products.value = res.data.data
    });
}

function selectColor(color) {
  product.selectedColor = color;
  let selectedVariant = product.variants.find(
    (variant) =>
      variant.color_id == color && variant.size_id == product.selectedSize
  );
  if (selectedVariant) {
    product.title =
      product_title_original.value +
      " - " +
      selectedVariant.color +
      " - " +
      selectedVariant.size;
    product.price = selectedVariant.price;
    product.reduced_price = selectedVariant.reduced_price;
    product.quantity = selectedVariant.quantity;
    product.variant_id = selectedVariant.id;
  }
}

function selectSize(size) {
  product.selectedSize = size;
  let selectedVariant = product.variants.find(
    (variant) =>
      variant.color_id == product.selectedColor && variant.size_id == size
  );
  if (selectedVariant) {
    product.title =
      product_title_original.value +
      " - " +
      selectedVariant.color +
      " - " +
      selectedVariant.size;
    product.price = selectedVariant.price;
    product.reduced_price = selectedVariant.reduced_price;
    product.quantity = selectedVariant.quantity;
    product.variant_id = selectedVariant.id;
  }
}

function increaseQuantity() {
  quantity.value++;
}
function decreaseQuantity() {
  if (quantity.value > 1) {
    quantity.value--;
  }
}
</script>

<style scoped>
</style>