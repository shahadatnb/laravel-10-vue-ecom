<script setup>
import { onMounted, ref } from 'vue'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import { useRouter } from 'vue-router'
const router = useRouter()
const scY = ref(0)
const scTimer = ref(0)

  onMounted(() => {
    window.addEventListener('scroll', handleScroll);
  })
  function handleScroll() {
    if (scTimer.value) return;
      scTimer.value = setTimeout(() => {
      scY.value = window.scrollY;
      clearTimeout(scTimer.value);
      scTimer.value = 0;
    }, 100);
  }
  function toTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  }
</script>

<template>
  <!-- header -->
  <Header />
  <!-- ./header -->

    <router-view />

    <Footer />
    <transition name="fade">
      <div id="pagetop" class="fixed right-5 bottom-5 cursor-pointer bg-yellow-500 rounded-full hover:bg-gray-200" v-show="scY > 300" @click="toTop">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
            stroke="#4a5568"
            stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs">
          <path d="M18 15l-6-6-6 6"/>
        </svg>
      </div>
    </transition>
</template>

<style scoped>
</style>
