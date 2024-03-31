<script setup>
import {onBeforeMount,ref} from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const categories = ref([])
onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/categories`)
        .then(res => {
            categories.value = res.data.data
        });
})
</script>
<template>
    <section class="product__section py-12">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-4xl lg:text-4xl text-center pb-10 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >
              TOP <span class="font-semibold">CATEGORIES</span>
            </h3>
          </div>
          <div
            class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-3 mt-10"
          >
            <div v-for="category in categories" :key="category.id"
              class="py-6 px-3 flex-col-reverse lg:flex-row flex gap-6 items-center bg-white rounded-2xl border border-[#c4c8cb]"
            >
              <div>
                <h4>{{category.title}}</h4>
                <router-link :to="{ name: 'category-product', params: { slug: category.slug }}"
                  class="px-[14px] py-[3px] btn__gradient text-white mt-2"
                >
                  View All
                </router-link>
              </div>
              <div class="w-full lg:w-[100px] lg:h-[100px]">
                <img
                  class="w-full h-full"
                  :src="category.photo"
                  alt="top product"
                />
              </div>
            </div>
          
          </div>
        </div>
      </section>
</template>