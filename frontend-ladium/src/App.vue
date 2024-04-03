<script setup>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import { useRouter } from 'vue-router'
const router = useRouter()
</script>

<template>
  <!-- header -->
  <Header />
  <!-- ./header -->

    <router-view />

    <Footer />
</template>

<style scoped>
</style>
