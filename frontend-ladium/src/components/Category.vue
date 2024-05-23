<script setup>
import LoopProduct from './LoopProduct.vue';
import {onBeforeMount,ref, reactive, computed, watch} from "vue";
import { basicStore } from "../store/basic";
const basic = basicStore;
import axios from "axios";
import { useRoute } from 'vue-router';
const route = useRoute()
const slug = ref(route.params.slug)
const products = ref([])
const categories = ref([])
const colors = ref([])
const sizes = ref([])
const selectedCategory = ref([])
const selectedColors = ref([])
const selectedSizes = ref([])
const minPrice = ref(0)
const maxPrice = ref(2000)
const loading = ref(false)
const filter =ref('hidden')

watch(() => route.params.slug, fetchData, { immediate: true })


async function fetchData(data) {
  loading.value = true
    axios.get(`${basic.serverUrl}/api/latest-products?category_slug=${data}&take=100`)//
      .then(res => {
          products.value = res.data.data
          loading.value = false
      });
      slug.value = data
}

function fetchProducts(){
  setTimeout(function() {
    loading.value = true
    //your code to be executed after 1 second
    axios.get(`${basic.serverUrl}/api/latest-products?colors=${selectedColors.value}&sizes=${selectedSizes.value}&min=${minPrice.value}&max=${maxPrice.value}&categories=${selectedCategory.value}&take=100`)
        .then(res => {
            products.value = res.data.data
            loading.value = false
        });
  }, 100);
}

onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/categories`)
        .then(res => {
            categories.value = res.data.data
        });

    axios.get(`${basic.serverUrl}/api/sizes`)
        .then(res => {
            sizes.value = res.data
            //console.log(sizes)
        });

    axios.get(`${basic.serverUrl}/api/colors`)
        .then(res => {
            colors.value = res.data
        });
})

function filterToggle(){
  filter.value == '' ? filter.value = 'hidden' : filter.value = ''
}

</script>
<template>
    <section class="bg-[#f2f2f2] py-2">
        <div class="container mx-auto px-5">
          <div class="text-[#0000008a]">
            <ul class="flex items-center gap-3 justify-between">
              <div class="flex items-center gap-3">
                <li>
                    <router-link to="/" class="text-primary text-base">
                        <font-awesome-icon icon="fa-solid fa-house" /> Home
                    </router-link>
                </li>
                <li class="">|</li>
                <li><a href="#" class="underline">Products</a></li>
              </div>
              <div>
                <li class="lg:hidden">
                  <div @click="filterToggle" class="flex menu__toggle items-center">
                    <span class="mr-2">filter</span>
                    <span class="text-2xl"><font-awesome-icon :icon="['fas', 'filter']" /></span>
                  </div>
                </li>
              </div>
            </ul>
          </div>
        </div>
      </section>
      <section class="pb-10 md:py-[30px] bg-[#f6f6f6]">
        <div class="container-fluid mx-auto">
          <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-[25%] xl:w-[17%] px-5 pb-[10px]">
              <div :class="filter + ' lg:block menu'">
                      <!--
              <h3 class="mb-2">Price Range</h3>
                <div class="flex justify-between range-slider">
                  <div class="w-1/2">
                    <input
                      v-model="minPrice"
                      min="0"
                      max="19500"
                      step="0"
                      type="number"
                      class="w-[75%] bg-white px-[10px] py-[6px] rounded-[5px] border border-[#d7dbde] text-primary"
                    />
                  </div>
                  <div class="w-1/2 text-end">
                    <input
                      v-model="maxPrice"
                      min="0"
                      max="2000"
                      step="500"
                      type="number"
                      class="w-[75%] bg-white px-[10px] py-[6px] rounded-[5px] border border-[#d7dbde] text-primary"
                    />
                  </div>
                </div>
                <div class="my-4">
                  <input type="range" name="min" class="w-full" />
                  <input type="range" name="max" class="w-full" />
                </div>
                -->
                <div class="">
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">
                      Category
                    </h4>
                    <div v-for="category in categories" class="">
                      <div  class="flex justify-between text-primary mt-2">
                        <div class="flex gap-2">
                          <input
                            @click="fetchProducts()"
                            v-model="selectedCategory"
                            type="checkbox"
                            :id="'cat-' + category.id"
                            class="form-check-input"
                            :value="category.id"
                          />
                          <label @click="fetchProducts()"
                            title="{{category.title}}"
                            :for="'cat-' + category.id"
                            class="form-check-label"
                            >{{ category.title }}</label>
                        </div>
                        <div>
                          <span class="">{{ category.prodcuctCount }}</span>
                        </div>
                      </div>
                    </div>
                    <!-- subcategories
                    <div class="pl-4">
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            type="checkbox"
                            id="size"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="size"
                            for="size"
                            class="form-check-label"
                            >Plus size</label
                          >
                        </div>
                      </div>
                    </div>
                     -->
                  </div>
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">size</h4>

                    <div class="">
                      <div v-for="size in sizes" :key="size.id" class="flex justify-between text-primary mt-2">
                        <div class="flex gap-2">
                          <input @click="fetchProducts()"
                           v-model="selectedSizes"
                            type="checkbox"
                            :id="'size-'+size.id"
                            class="form-check-input"
                            :value="size.id"/>
                            <label @click="fetchProducts()" title="{{size.name}}" :for="'size-'+size.id" class="form-check-label">{{size.name}}</label>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">color</h4>

                    <div class="">
                      <div v-for="color in colors" :key="color.id" class="flex justify-between text-primary items-center">
                        <div class="flex gap-2">
                          <input
                            @click="fetchProducts()"
                            v-model="selectedColors"
                            type="checkbox"
                            :id="'color-'+color.id"
                            class="form-check-input"
                            :value="color.id"/>
                            <label @click="fetchProducts()"
                            title="{{color.name}}"
                            :for="'color-'+color.id"
                            class="form-check-label"
                            >{{color.name}}</label>
                        </div>
                        <div class="w-[32px] h-5" :style="{backgroundColor: color.code}">
                          <span class="inline-block"></span>
                        </div>
                      </div>                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full lg:w-[75%] xl:w-[83%]">
              <div
                class="grid grid-cols-2 xl:grid-cols-5 gap-3 gap-y-[32px]"
              >
                <loop-product
                  v-for="product in products"
                  :key="product.id"
                  :product="product"
                ></loop-product>                
              </div>
            </div>
          </div>
        </div>
      </section>

      <div v-show="loading" class="fixed bottom-0 left-0 w-full bg-black opacity-50 flex justify-center items-center h-screen">
          <div class="relative inline-flex">
              <!-- <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
              <div class="w-8 h-8 bg-blue-500 rounded-full absolute top-0 left-0 animate-ping"></div>
              <div class="w-8 h-8 bg-blue-500 rounded-full absolute top-0 left-0 animate-pulse"></div> -->
              <!-- <div class="border-gray-300 h-20 w-20 animate-spin rounded-full border-8 border-t-blue-600" /> -->
              <div class='flex space-x-2 justify-center items-center h-screen dark:invert'>
                <span class='sr-only'>Loading...</span>
                  <div class='h-8 w-8 bg-white rounded-full animate-bounce [animation-delay:-0.3s]'></div>
                <div class='h-8 w-8 bg-white rounded-full animate-bounce [animation-delay:-0.15s]'></div>
                <div class='h-8 w-8 bg-white rounded-full animate-bounce'></div>
              </div>
          </div>
      </div>
</template>