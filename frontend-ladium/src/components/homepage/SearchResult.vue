<script setup>
import { ref, onMounted } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const SearchBox = ref(false);
const products = ref([])
const searchText = ref('')
const emit = defineEmits(['searchToggle'])

onMounted(() => {
  document.getElementById("searchProduct").focus();
})

function fetchProducts(){
  if(searchText.value.length>1){
  setTimeout(function() {
    //your code to be executed after 1 second
      axios.get(`${basic.serverUrl}/api/search-products?searchText=${searchText.value}`)
          .then(res => {
              products.value = res.data.data
          });
    }, 100);
  }
}

</script>
<template>    
  <div>
    <div @keyup="fetchProducts" class="text-center p-3 flex-auto justify-center leading-6">
      <input id="searchProduct" type="text" v-model="searchText"  placeholder="Search" class="border border-[#ced9d9] text-primary px-3 py-[.375rem] rounded-md inline-block w-full" autofocus />
    </div>
    <ul role="list" class="w-full">
      <li class="lx flex items-center px-2 py-2 hover:bg-gray-100" v-for="product in products" :key="product.id">
        <img class="w-12 h-12 mr-4" :src="product.photo" alt="">
        <router-link @click="$emit('searchToggle')" :to="{ name: 'product-single', params: { slug: product.slug }}" class="w-full">
          <p class="">{{ product.title }}</p>
          <p class="text-sm text-gray-600">৳{{ product.price }}</p>
        </router-link>
      </li>
    </ul>
  </div>
</template>