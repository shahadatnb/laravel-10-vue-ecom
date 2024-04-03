<script setup>
import { reactive, onBeforeMount, onMounted, ref } from 'vue'
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';
import axios from 'axios'
import LoopProduct from './LoopProduct.vue';
import { basicStore } from "../store/basic.js";
import { wishlist } from '../store/wishlist';
import { cart } from '../store/cart';
const basic = basicStore;
import { useRoute } from 'vue-router';
const route = useRoute()
const slug = route.params.slug
const product = reactive({})
const product_title_original = ref('')
const relatedProducts = ref([])
const quantity = ref(1)
const currentPhoto = ref(0)
const galleries = ref('')
const tabItem = ref('description')
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/single-product/${slug}`)
        .then(res => {
            //console.log(res.data)
            product_title_original.value = res.data.data.title
            product.id = res.data.data.id
            product.title = res.data.data.title
            product.price = res.data.data.price
            product.reduced_price = res.data.data.reduced_price            
            product.short_description = res.data.data.short_description
            product.description = res.data.data.description
            product.product_type = res.data.data.product_type
            product.colors = res.data.data.colors
            product.sizes = res.data.data.sizes
            product.variants = res.data.data.variants
            product.photo = res.data.data.photo
            product.galleries = res.data.data.galleries
            product.categories = res.data.data.categories
            currentPhoto.value = product.galleries[0].id
            if(product.product_type == 'variant') {
                product.selectedColor = product.variants[0].color_id
                product.selectedSize = product.variants[0].size_id
                let selectedVariant = product.variants.find((variant) => variant.color_id == product.selectedColor && variant.size_id == product.selectedSize)
                if(selectedVariant) {
                    //console.log(selectedVariant)
                    product.quantity = selectedVariant.quantity
                    product.variant_id = selectedVariant.id
                }
            }else{
                //console.log(product.variants)
                product.quantity = product.variants[0].quantity
            }
            document.title = product.title
            document.querySelector("meta[property='og:image']").setAttribute("content", product.photo);
            document.querySelector("meta[property='og:title']").setAttribute("content", product.title);
        });

    axios.get(`${basic.serverUrl}/api/latest-products?take=8`)
        .then(res => {
            relatedProducts.value = res.data.data
        });
})

onMounted(() => {
  window.scrollTo(0, 0)
})

function selectColor(color) {
    product.selectedColor = color
    let selectedVariant = product.variants.find((variant) => variant.color_id == color && variant.size_id == product.selectedSize)
    if(selectedVariant) {
        //console.log(selectedVariant)
        product.title = product_title_original.value + ' - ' + selectedVariant.color + ' - ' + selectedVariant.size
        product.price = selectedVariant.price
        product.reduced_price = selectedVariant.reduced_price
        product.quantity = selectedVariant.quantity
        product.variant_id = selectedVariant.id
        //console.log(product)
        axios.get(`${basic.serverUrl}/api/product-variant-gallery/${product.id}/${color}`)
        .then(res => {
          if(res.data.data.length > 0) {
            currentPhoto.value = res.data.data[0].id
            product.galleries = res.data.data
          }          
          //console.log(res.data.data)
        });
    };
}

function selectSize(size) {
    product.selectedSize = size
    let selectedVariant = product.variants.find((variant) => variant.color_id == product.selectedColor && variant.size_id == size)
    if(selectedVariant) {
        //console.log(selectedVariant)
        product.title = product_title_original.value + ' - ' + selectedVariant.color + ' - ' + selectedVariant.size
        product.price = selectedVariant.price
        product.reduced_price = selectedVariant.reduced_price
        product.quantity = selectedVariant.quantity
        product.variant_id = selectedVariant.id
    }
}

function increaseQuantity() {
    quantity.value++
}
function decreaseQuantity() {
    if(quantity.value > 1) {
        quantity.value--
    }
}

</script>

<template>
<section class="bg-[#f6f6f6]">
        <div class="max-w-[1320px] mx-auto pt-5 pb-10">
          <div class="px-10 xl:px-0">
            <ul class="py-4 flex gap-2 flex-wrap">
                <li class="text-[#0d6efd] underline">
                    <router-link to="/" class="text-primary text-base">
                        <font-awesome-icon icon="fa-solid fa-house" /> Home
                    </router-link>
                    <span class="text-sm text-gray-400">
                        <font-awesome-icon icon="fa-solid fa-chevron-right" />
                    </span>
                </li>
              <li class="text-[#212529bf]">
                {{ product.title }}
              </li>
            </ul>
          </div>
          <div class="flex flex-col lg:flex-row gap-10 lg:gap-5 px-10 xl:px-0">
            <div class="w-[100%] lg:w-[50%]">
              <div class="flex lg:gap-5 justify-between">
                <div class="w-[30%] lg:w-[20%]">
                  <div class="flex flex-col gap-3">                  
                    <img v-for="photo in product.galleries" :key="photo.id" :src="photo.photo" @click="currentPhoto = photo.id" alt="product2" class="thumbnail w-full cursor-pointer border">
                  </div>
                </div>
                <div class="w-[65%] lg:w-[80%]">
                  <div class="position-relative">
                    <template v-for="photo in product.galleries" :key="'full'+photo.id">
                      <inner-image-zoom v-if="currentPhoto == photo.id" :src="photo.photo" :zoomSrc="photo.photoOriginal" zoomType="hover" />
                      <!-- :zoomSrc="photo.photoOriginal" -->
                    </template>
                  </div>
                </div>
              </div>
            </div>

            <div class="w-[100%] lg:w-[50%]">
              <!-- <div class="flex gap-12">
                <h4 class="text-[#0d6efd] underline">Review 0</h4>
                <p>Sold 0</p>
              </div> -->
              <div>
                <h2 class="mb-0 text-primary pb-2 text-xl font-medium">
                    {{ product.title }}
                </h2>
                <p class="mb-2 text-primary">SKU: {{ product.sku }}</p>
                <p class="text-primary text-xl mb-4">Price: 
                    <template v-if="product.reduced_price != null">
                        ৳ {{ product.reduced_price }}
                        <span class="text-gray-400 line-through">৳ {{ product.price }}</span>
                    </template>
                    <template v-else>
                        ৳ {{ product.price }}
                    </template>
                </p>
                <div class="flex gap-3 flex-wrap mb-4" v-if="product.sizes != ''">
                  <span class="mr-2 font-medium">Size:</span>
                    <div class="size-selector" v-for="(size, index) in product.sizes" :key="index">
                        <input type="radio" name="size" :id="'size-'+index" class="hidden">
                        <label :for="'size-'+index" v-on:click="selectSize(index)"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">{{ size }}</label>
                    </div> 
                </div>
                <div class="flex items-center gap-2" v-if="product.colors != ''">
                  <h4>color:</h4>
                  <div class="color-selector" v-for="(color, index) in product.colors" :key="index">
                        <input type="radio" name="color" :id="'color-'+index" class="hidden">
                        <label :for="'color-'+index" v-on:click="selectColor(index)"
                            class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                            :style="{ backgroundColor: color }"></label>
                    </div>
                </div>
                <div class="my-4 text-primary flex justify-between">
                  <form class="w-full">
                    <div
                      class="flex items-center max-w-[261px] border border-[#5a53538f] rounded-md"
                    >
                      <button
                        @click="decreaseQuantity()"
                        type="button"
                        id="decrement-button"
                        data-input-counter-decrement="quantity-input"
                        class="w-[25%] flex items-center justify-center border-r-[#5a53538f] border-r py-2"
                      >
                        -
                      </button>
                      <input
                        type="text"
                        id="quantity-input"
                        data-input-counter
                        aria-describedby="helper-text-explanation"
                        class="bg-white border-x-0 border-gray-300 h-11 text-center text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5"
                        v-model="quantity"
                        required
                      />
                      <button @click="increaseQuantity()"
                        type="button"
                        id="increment-button"
                        data-input-counter-increment="quantity-input"
                        class="w-[25%] flex items-center justify-center border-l-[#5a53538f] border-l py-2"
                      >
                        +
                      </button>
                    </div>
                  </form>
                  <p class="w-[25%] font-bold text-primary">{{ product.quantity > 0 ? 'In Stock' : 'Out of Stock' }}</p>
                </div>
                <div class="flex gap-5 mt-10 flex-wrap">
                  <button @click="cart.addItem(product, quantity)"
                    class="border border-black font-semibold rounded-lg capitalize text-black bg-white px-5 py-1 lg:px-8 lg:py-3"
                  >
                    Add To Cart
                  </button>
                  <!-- <button
                    class="border border-black font-semibold rounded-lg capitalize text-black bg-white px-5 py-1 lg:px-8 lg:py-3"
                  >
                    Buy it Now
                  </button> -->
                  <button
                    class="border border-black font-semibold rounded-lg capitalize text-[#0d6efd] bg-white px-5 py-1 lg:px-8 lg:py-3"
                  >
                    <a href="#"  @click="wishlist.toggleWishlist(product)"
                        class="text-gray-600 px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                        <font-awesome-icon v-if="wishlist.isWishListed(product)" :icon="['fas', 'heart']" />
                        <font-awesome-icon v-else :icon="['far', 'heart']" />
                        Wishlist
                    </a>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="flex gap-2 p-5 md:py-20 flex-wrap px-10 xl:px-0">
            <h5 class="uppercase text-[#de5531]">share:</h5>
            <ul class="flex text-[#008bd1] gap-3 text-xl flex-wrap">
              <li>
                <a :href="'https://www.facebook.com/sharer/sharer.php?u=ladiumbd.com' + route.path"><font-awesome-icon :icon="['fab', 'facebook']" /> </a>
              </li>
              <!-- <li>
                <a href=""> <i class="fa-brands fa-instagram"></i></a>
              </li> -->

              <li>
                <a href="https://twitter.com/intent/tweet?url=ladiumbd.com"><i class="fa-brands fa-twitter"></i></a>
              </li>
              <!-- <li>
                <a href="#"><i class="fa-brands fa-youtube"></i> </a>
              </li> -->
            </ul>
          </div>
        </div>
      </section>

      <section class="bg-[#f6f6f6]">
        <div class="max-w-[1320px] mx-auto px-5 xl:px-0 pb-10">
          <div class="py-5 md:py-14 border-t border-b-[#212529bf]">
            <div
              class="uppercase md:text-3xl px-4 py-2 font-bold flex gap-0 justify-center flex-wrap"
            >
              <h4 @click="tabItem='description'" class="text-primary cursor-pointer border-2 p-2">Description</h4>
              <h4 @click="tabItem='short_description'" class="text-primary cursor-pointer border-2 p-2">Size</h4>
              <!-- <p class="text-[#0d6efd]">reviews (0)</p> -->
            </div>
          </div>

          <!-- <div class="flex justify-center mb-10">
            <div class="w-full">
              <div class="flex items-center mb-2">
                <svg
                  class="w-4 h-4 text-yellow-300 me-1"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 22 20"
                >
                  <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                  />
                </svg>
                <svg
                  class="w-4 h-4 text-yellow-300 me-1"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 22 20"
                >
                  <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                  />
                </svg>
                <svg
                  class="w-4 h-4 text-yellow-300 me-1"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 22 20"
                >
                  <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                  />
                </svg>
                <svg
                  class="w-4 h-4 text-yellow-300 me-1"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 22 20"
                >
                  <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                  />
                </svg>
                <svg
                  class="w-4 h-4 text-gray-300 me-1 dark:text-gray-500"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 22 20"
                >
                  <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                  />
                </svg>
                <p
                  class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400"
                >
                  4.95
                </p>
                <p
                  class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400"
                >
                  out of
                </p>
                <p
                  class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400"
                >
                  5
                </p>
              </div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                1,745 global ratings
              </p>
              <div class="flex items-center mt-4">
                <a
                  href="#"
                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"
                  >5 star</a
                >
                <div
                  class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                >
                  <div
                    class="h-5 bg-yellow-300 rounded"
                    style="width: 70%"
                  ></div>
                </div>
                <span
                  class="text-sm font-medium text-gray-500 dark:text-gray-400"
                  >70%</span
                >
              </div>
              <div class="flex items-center mt-4">
                <a
                  href="#"
                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"
                  >4 star</a
                >
                <div
                  class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                >
                  <div
                    class="h-5 bg-yellow-300 rounded"
                    style="width: 17%"
                  ></div>
                </div>
                <span
                  class="text-sm font-medium text-gray-500 dark:text-gray-400"
                  >17%</span
                >
              </div>
              <div class="flex items-center mt-4">
                <a
                  href="#"
                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"
                  >3 star</a
                >
                <div
                  class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                >
                  <div
                    class="h-5 bg-yellow-300 rounded"
                    style="width: 8%"
                  ></div>
                </div>
                <span
                  class="text-sm font-medium text-gray-500 dark:text-gray-400"
                  >8%</span
                >
              </div>
              <div class="flex items-center mt-4">
                <a
                  href="#"
                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"
                  >2 star</a
                >
                <div
                  class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                >
                  <div
                    class="h-5 bg-yellow-300 rounded"
                    style="width: 4%"
                  ></div>
                </div>
                <span
                  class="text-sm font-medium text-gray-500 dark:text-gray-400"
                  >4%</span
                >
              </div>
              <div class="flex items-center mt-4">
                <a
                  href="#"
                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"
                  >1 star</a
                >
                <div
                  class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                >
                  <div
                    class="h-5 bg-yellow-300 rounded"
                    style="width: 1%"
                  ></div>
                </div>
                <span
                  class="text-sm font-medium text-gray-500 dark:text-gray-400"
                  >1%</span
                >
              </div>
            </div>
          </div> -->
          <div v-show="tabItem=='description'" id="description" v-html="product.description">
          </div>
          <div v-show="tabItem=='short_description'" id="short_description" class="d-none" v-html="product.short_description">
          </div>
        </div>
      </section>
</template>