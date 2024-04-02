<script setup>
import LoopProduct from './LoopProduct.vue';
import {onBeforeMount,ref, reactive, computed} from "vue";
import { basicStore } from "../store/basic";
const basic = basicStore;
import axios from "axios";
import { useRoute } from 'vue-router';
const route = useRoute()
const slug = route.params.slug
const products = ref([])
const categories = ref([])
const colors = ref([])
const sizes = ref([])
const selectedCategory = ref([])
const selectedColor = ref([])
const selectedSize = ref([])

//selectedCategory.value = slug
console.log(slug)
const testProducts = reactive({
    product: [],
    categories: [],
})

function fetchProducts(){
    axios.get(`${basic.serverUrl}/api/latest-products?take=8&categories=${selectedCategory.value}`)
        .then(res => {
            products.value = res.data.data
        });
}

onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/latest-products`)//?categories='health-beauty'
        .then(res => {
            products.value = res.data.data
            testProducts.data = res.data.data
        });

    axios.get(`${basic.serverUrl}/api/categories`)
        .then(res => {
            categories.value = res.data.data
            
            //console.log(categories)
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
                  <div class="flex menu__toggle items-center">
                    <span class="mr-2">filter</span>
                    <span class="text-2xl"
                      ><i class="fa-solid fa-filter"></i
                    ></span>
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
            <div class="w-full lg:w-[30%] xl:w-[17%] px-5 py-[10px]">
              <div class="hidden lg:block menu">
                <h3 class="mb-2">Price Range</h3>
                <div class="flex justify-between range-slider">
                  <div class="w-1/2">
                    <input
                      value="0"
                      min="0"
                      max="2600"
                      step="0"
                      type="number"
                      class="w-[75%] bg-white px-[10px] py-[6px] rounded-[5px] border border-[#d7dbde] text-primary"
                    />
                  </div>
                  <div class="w-1/2 text-end">
                    <input
                      value="2600"
                      min="0"
                      max="2600"
                      step="500"
                      type="number"
                      class="w-[75%] bg-white px-[10px] py-[6px] rounded-[5px] border border-[#d7dbde] text-primary"
                    />
                  </div>
                </div>
                <div class="my-4">
                  <input type="range" class="w-full" />
                </div>
                <div class="">
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">
                      Category
                    </h4>
                    <div class="">
                      <div class="flex justify-between text-primary mt-2">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="women"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="Women"
                            for="women"
                            class="form-check-label"
                            >Women</label
                          >
                        </div>
                        <div>
                          <span class="">103</span>
                        </div>
                      </div>
                    </div>
                    <div class="pl-4">
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
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
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="sports"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="sports"
                            for="sports"
                            class="form-check-label"
                            >Sports Top</label
                          >
                        </div>
                      </div>
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="leggings"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="leggings"
                            for="leggings"
                            class="form-check-label"
                            >Sports Leggings</label
                          >
                        </div>
                      </div>
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="yoga"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="yoga"
                            for="yoga"
                            class="form-check-label"
                            >Gym yoga set</label
                          >
                        </div>
                      </div>
                      <div class="flex justify-between text-primary">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="sports-bra"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="sports-bra"
                            for="sports-bra"
                            class="form-check-label"
                            >Sports bra</label
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">size</h4>

                    <div v-for="size in sizes" :key="size.id" class="">
                      <div class="flex justify-between text-primary mt-2">
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="S"
                            class="form-check-input"
                            value="31"/>
                            <label title="S" for="S" class="form-check-label">S</label>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <div class="border-t border-t-[#dddddd] py-2">
                    <h4 class="text-xl font-semibold uppercase mb-2">color</h4>

                    <div class="">
                      <div
                        class="flex justify-between text-primary items-center"
                      >
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="Red"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="Red"
                            for="Red"
                            class="form-check-label"
                            >Red</label
                          >
                        </div>
                        <div class="w-[32px] h-5 bg-[#ff0000]">
                          <span class="inline-block"></span>
                        </div>
                      </div>
                      
                      <div
                        class="flex justify-between text-primary items-center"
                      >
                        <div class="flex gap-2">
                          <input
                            wire:model="cats.31"
                            type="checkbox"
                            id="Black"
                            class="form-check-input"
                            value="31"
                          /><label
                            title="Black"
                            for="Black"
                            class="form-check-label"
                            >Same as Picture</label
                          >
                        </div>
                        <div class="w-[32px] h-5 bg-black">
                          <span class="inline-block"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full lg:w-[70%] xl:w-[73%]">
              <div
                class="grid grid-cols-2 xl:grid-cols-5 gap-3 mt-10 gap-y-[32px]"
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
</template>