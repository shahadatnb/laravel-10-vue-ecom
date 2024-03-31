<script setup>
import {onBeforeMount,ref} from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const testimonials = ref([])
onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/posts?post_type=review&&take=2`)
        .then(res => {
          testimonials.value = res.data.data
        });
})
</script>
<template>
  <!-- clients testimonial -->
  <section class="py-12 bg-white">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-4xl lg:text-4xl text-center pb-10 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >
              CLIENTS <span class="font-semibold">TESTIMONIAL</span>
            </h3>
          </div>
          <div
            class="max-w-[1296px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-5 mt-10"
          >
            <div v-for="testimonial in testimonials" :key="testimonial.id" class="border border-[#c4c8cb] rounded-2xl p-2 text-center">
              <figure class="max-w-[160px] h-[160px] mx-auto mb-4">
                <img
                  class="w-full h-full"
                  :src="testimonial.image"
                  :alt="testimonial.title"
                />
              </figure>
              <div>
                <div class="mb-2">
                  <h6>{{ testimonial.title }}</h6>
                  <strong>{{ testimonial.postMeta ? testimonial.postMeta.profession : '' }}</strong>
                </div>
                <p>
                  {{testimonial.body}}
                </p>
              </div>
            </div>
            
          </div>
        </div>
      </section>
</template>