<script setup>
import { reactive, onBeforeMount, ref, watch } from "vue";
import "vue-inner-image-zoom/lib/vue-inner-image-zoom.css";
import InnerImageZoom from "vue-inner-image-zoom";
//import { VueImageZoomer } from 'vue-image-zoomer'
//import 'vue-image-zoomer/dist/style.css';
import axios from "axios";
import LoopProduct from "./LoopProduct.vue";
import { basicStore } from "../store/basic.js";
import { wishlist } from "../store/wishlist";
import { cart } from "../store/cart";
const basic = basicStore;
import { useRoute } from "vue-router";
const route = useRoute();
const slug = ref(route.params.slug);
const product = reactive({});
const product_title_original = ref("");
const relatedProducts = ref([]);
const quantity = ref(1);
const currentPhoto = ref(0);
const galleries = ref("");
const currentUrl = window.location.origin + window.location.pathname;
const tabItem = ref("description");
const loading = ref(false);
const selectedColor = ref('');
const selectedSize = ref('');

watch(() => route.params.slug, fetchData, { immediate: true });

async function fetchData(data) {
  loading.value = true;
  axios.get(`${basic.serverUrl}/api/single-product/${data}`).then((res) => {
    //console.log(res.data)
    product_title_original.value = res.data.data.title;
    product.id = res.data.data.id;
    product.title = res.data.data.title;
    product.sku = res.data.data.sku;
    product.slug = res.data.data.slug;
    product.price = res.data.data.price;
    product.reduced_price = res.data.data.reduced_price;
    product.short_description = res.data.data.short_description;
    product.description = res.data.data.description;
    product.product_type = res.data.data.product_type;
    product.colors = res.data.data.colors;
    product.sizes = res.data.data.sizes;
    product.variants = res.data.data.variants;
    product.photo = res.data.data.photo;
    product.galleries = res.data.data.galleries;
    product.categories = res.data.data.categories;
    currentPhoto.value = product.galleries[0].id;
    if (product.product_type == "variant") {
      product.selectedColor = product.variants[0].color_id;
      product.selectedSize = product.variants[0].size_id;
      let selectedVariant = product.variants.find(
        (variant) =>
          variant.color_id == product.selectedColor &&
          variant.size_id == product.selectedSize
      );
      if (selectedVariant) {
        //console.log(selectedVariant)
        product.quantity = selectedVariant.quantity;
        product.variant_id = selectedVariant.id;
      }
    } else {
      //console.log(product.variants)
      product.quantity = product.variants[0].quantity;
    }
    document.title = product.title;
    document
      .querySelector("meta[property='og:image']")
      .setAttribute("content", product.photo);
    document
      .querySelector("meta[property='og:title']")
      .setAttribute("content", product.title);
    loading.value = false;
  });
}

onBeforeMount(() => {
  axios.get(`${basic.serverUrl}/api/latest-products?take=6`).then((res) => {
    relatedProducts.value = res.data.data;
  });
});

function selectColor(color) {
  product.selectedColor = color;
  let selectedVariant = product.variants.find(
    (variant) =>
      variant.color_id == color && variant.size_id == product.selectedSize
  );
  if (selectedVariant) {
    //console.log(selectedVariant)
    product.title =
      product_title_original.value +
      " - " +
      selectedVariant.color +
      " - " +
      selectedVariant.size;
    selectedColor.value = selectedVariant.color;
    product.price = selectedVariant.price;
    product.reduced_price = selectedVariant.reduced_price;
    product.quantity = selectedVariant.quantity;
    product.variant_id = selectedVariant.id;
    //console.log(product)
    axios
      .get(
        `${basic.serverUrl}/api/product-variant-gallery/${product.id}/${color}`
      )
      .then((res) => {
        if (res.data.data.length > 0) {
          currentPhoto.value = res.data.data[0].id;
          product.galleries = res.data.data;
        }
        //console.log(res.data.data)
      });
  }
}

function selectSize(size) {
  product.selectedSize = size;
  let selectedVariant = product.variants.find(
    (variant) =>
      variant.color_id == product.selectedColor && variant.size_id == size
  );
  if (selectedVariant) {
    //console.log(selectedVariant)
    product.title =
      product_title_original.value +
      " - " +
      selectedVariant.color +
      " - " +
      selectedVariant.size;
    selectedSize.value = selectedVariant.size;
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

<template>

  <section class="bg-[#e2e8eb] border-solid border-y-rose-300">
    <div class="max-w-[1320px] mx-auto py-3">
      <div class="px-10 xl:px-0">
        <ul class="flex gap-2 flex-wrap">
          <li class="text-[#0d6efd]">
            <router-link to="/" class="text-primary no-underline ms-3">
              <font-awesome-icon class="me-3" icon="fa-solid fa-house" /> Home
            </router-link>
            <span class="text-sm text-gray-400 ms-3">
              <font-awesome-icon icon="fa-solid fa-chevron-right" />
            </span>
          </li>
          <li class="text-[#212529bf]">
            {{ product.title }}
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section class="bg-[rgb(242, 248, 253)]">
    <div class="max-w-[1320px] mx-auto pt-5 pb-10">
      <div class="flex flex-col lg:flex-row gap-10 lg:gap-5 px-10 xl:px-0">
        <div class="w-[100%] lg:w-[50%]">

          <template v-for="photo in product.galleries" :key="'full' + photo.id">
            <inner-image-zoom v-if="currentPhoto == photo.id" :src="photo.photo" :zoomSrc="photo.photoOriginal"
              zoomType="hover" :hasSpacer="true" :fullscreenOnMobile="true" :zoomPreload="true" />
          </template>
          <div class="flex flex-row gap-2">
            <img v-for="photo in product.galleries" :key="photo.id" :src="photo.photo" @click="currentPhoto = photo.id"
              alt="product2" class="thumbnail w-[70px] lg:w-[100px] cursor-pointer border" />
          </div>
        </div>

        <div class="w-[100%] lg:w-[50%]">
          
          <div>
            <h2 class="mb-0 text-primary pb-2 text-xl font-medium">
              {{ product.title }}
            </h2>
            <p class="mb-2 text-primary">SKU: {{ product.sku }}</p>
            <p class="text-primary text-2xl font-semibold mb-4">
              <!-- Price: -->
              <template v-if="product.reduced_price != null">
                ৳ {{ product.reduced_price }}
                <span class="text-gray-400 line-through">৳ {{ product.price }}</span>
              </template>
              <template v-else> ৳ {{ product.price }} </template>
            </p>

            <div class="flex flex-col gap-2" v-if="product.colors != ''">
              <h4 class="mr-2">Color: <b>{{ selectedColor }}</b></h4>
              <div class="flex flex-col gap-2">
                <div class="color-selector" v-for="(color, index) in product.colors" :key="index">
                  <input type="radio" name="color" :id="'color-' + index" class="hidden" />
                  <label :for="'color-' + index" v-on:click="selectColor(index)"
                    class="border-0 rounded-0 h-6 w-14 cursor-pointer shadow-sm block" :class="{
                      'border-green-600':
                        product.selectedColor == index,
                    }" :style="{ backgroundColor: color }"></label>

                </div>
              </div>
            </div>
            <div class="flex flex-col gap-3 flex-wrap my-4" v-if="product.sizes != ''">
              <h4 class="mr-2">Size: <b>{{ selectedSize }}</b></h4>
              <div class="flex gap-2 flex-wrap">
                <div class="size-selector" v-for="(size, index) in product.sizes" :key="index">
                  <input type="radio" name="size" :id="'size-' + index" class="hidden" />
                  <label :for="'size-' + index" v-on:click="selectSize(index)"
                    class="text-xs md:text-md md:text-md border border-gray-200 rounded-sm flex items-center justify-center cursor-pointer shadow-sm text-gray-600 px-3 md:px-6 md:py-4 py-[6px]"
                    :class="{
                      'text-white bg-primary':
                        product.selectedSize == index,
                    }">{{ size }}</label>
                </div>
              </div>
            </div>
            <div class="my-6 text-primary flex justify-start items-center gap-2 flex-wrap">
              <form class="w-[50%]">
                <div class="flex items-center md:max-w-[261px] border border-[#5a53538f] rounded-md">
                  <button @click="decreaseQuantity()" type="button" id="decrement-button"
                    data-input-counter-decrement="quantity-input" class="w-[25%] flex items-center justify-center py-2">
                    -
                  </button>
                  <input type="text" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation"
                    class="bg-white border-x-0 border-gray-300 lg:h-14 text-center text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5"
                    v-model="quantity" required />
                  <button @click="increaseQuantity()" type="button" id="increment-button"
                    data-input-counter-increment="quantity-input" class="w-[25%] flex items-center justify-center py-2">
                    +
                  </button>
                </div>
              </form>
              <p class="w-[25%] font-bold text-primary">
                {{
                  (product.quantity > 0 && product.quantity >= quantity)
                ? "In Stock"
                : "Out of Stock"
                }}
              </p>
            </div>
            <div class="flex gap-5 my-3 flex-wrap">
              <button @click="cart.addItem(product, quantity)"
                class="w-full border border-black rounded-xl uppercase text-white bg-black px-5 py-1 lg:px-8 lg:py-3">
                Add To Cart
              </button>
              <button class="w-full text-[#0d6efd]">
                <a href="#" @click="wishlist.toggleWishlist(product)"
                  class="text-gray-600 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                  <font-awesome-icon v-if="wishlist.isWishListed(product)" :icon="['fas', 'heart']" />
                  <font-awesome-icon v-else :icon="['far', 'heart']" />
                  Wishlist
                </a>
              </button>
            </div>

            <div class="flex my-3 p-3 gap-2 flex-wrap">
              <h5 class="uppercase text-[#de5531]">share:</h5>
              <ul class="flex text-[#008bd1] gap-3 text-xl flex-wrap">
                <li>
                  <a :href="'https://www.facebook.com/sharer/sharer.php?u=' +
                    currentUrl
                    ">
                    <font-awesome-icon :icon="['fab', 'facebook']" />
                  </a>
                </li>
                <li>
                  <a :href="'https://api.whatsapp.com/send?text=' +
                    currentUrl
                    ">
                    <font-awesome-icon :icon="['fab', 'whatsapp']" />
                  </a>
                </li>

                <li>
                  <a :href="'https://twitter.com/intent/tweet?url=' +
                    currentUrl
                    ">
                    <font-awesome-icon :icon="['fab', 'x-twitter']" />
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="max-w-[1320px] mx-auto px-5 xl:px-0 pb-10">
      <div class="py-5 md:py-6 border-t border-b-[#212529bf]">
        <div class="uppercase md:text-3xl px-4 py-2 font-bold flex gap-3 justify-center flex-wrap">
          <h4 @click="tabItem = 'description'" class="text-primary cursor-pointer border px-5 py-2">
            Description
          </h4>
          <h4 @click="tabItem = 'short_description'" class="text-primary cursor-pointer border px-5 py-2">
            Size
          </h4>
          <!-- <p class="text-[#0d6efd]">reviews (0)</p> -->
        </div>
      </div>

      <div v-show="tabItem == 'description'" id="description" v-html="product.description"></div>
      <div v-show="tabItem == 'short_description'" id="short_description" class="d-none"
        v-html="product.short_description">
      </div>
    </div>
  </section>

  <section class="bg-[#e2e8eb] py-12 product__section">
    <div class="container-fluid mx-auto px-5">
      <div>
        <h3 class="text-primary text-2xl lg:text-4xl text-center pb-2 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]">Recommended<span class="font-semibold"> Products</span></h3>
      </div>
      <div class="grid grid-cols-2 xl:grid-cols-6 gap-3 mt-10 gap-y-[32px]">
        <LoopProduct v-for="product in relatedProducts" :key="product.id" :product="product" />
      </div>

    </div>
  </section>
  <div v-show="loading"
    class="fixed bottom-0 left-0 w-full bg-black opacity-50 flex justify-center items-center h-screen">
    <div class="relative inline-flex">
      <div class="flex space-x-2 justify-center items-center h-screen dark:invert">
        <span class="sr-only">Loading...</span>
        <div class="h-8 w-8 bg-white rounded-full animate-bounce [animation-delay:-0.3s]"></div>
        <div class="h-8 w-8 bg-white rounded-full animate-bounce [animation-delay:-0.15s]"></div>
        <div class="h-8 w-8 bg-white rounded-full animate-bounce"></div>
      </div>
    </div>
  </div>
</template>
