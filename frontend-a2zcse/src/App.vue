<template>
  <header class="bg-white shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

    <!-- Logo -->
    <div class="logo">
      <router-link :to="'/'">
      <img src="./assets/img/a2zcse logo.png" alt="">
      </router-link>
    </div>

    <!-- Desktop Menu -->
    <nav class="hidden md:flex space-x-8 font-medium">
    <template v-if="basic?.settings?.menus">
          <router-link 
            v-for="menu in basic.settings.menus.main" 
            :key="menu.id" 
            :to="menu.menu_url" 
            class="hover:text-indigo-600"
          >
            {{ menu.lebel }}
          </router-link>
        </template>
    </nav>

    <!-- Right -->
    <div class="flex items-center gap-3">

      <button class="hidden sm:block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        Login
      </button>

      <!-- <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        Cart
      </button> -->

      <!-- Open Button -->
      <button 
          @click="openMenu" 
          class="md:hidden text-3xl"
          aria-label="Open Menu"
          :aria-expanded="isOpen.toString()"
        >
          ☰
      </button>
    </div>
  </div>

  <!-- Overlay -->
  <div 
      v-if="isOpen" 
      @click="closeMenu" 
      class="fixed inset-0 bg-black/40 z-40"
    ></div>

  <!-- Mobile Menu -->
  <div 
      class="fixed top-0 right-0 w-72 h-full bg-white shadow-lg z-50 transform transition-transform duration-300"
      :class="{ 'translate-x-full': !isOpen }"
    >
    <!-- Top bar -->
    <div class="flex items-center justify-between p-5 border-b">
      <h2 class="font-bold text-lg text-indigo-600">Menu</h2>

      <!-- Close Button -->
      <button 
          @click="closeMenu" 
          class="text-2xl"
          aria-label="Close Menu"
        >
          ✖
        </button>
    </div>

    <!-- Links -->
    <div class="p-5 space-y-4 font-medium">
      <template v-if="basic?.settings?.menus">
          <router-link 
            v-for="menu in basic.settings.menus.main" 
            :key="menu.id" 
            :to="menu.menu_url" 
            @click="closeMenu"
            class="block hover:text-indigo-600"
          >
            {{ menu.lebel }}
          </router-link>
        </template>
    </div>
  </div>
</header>
<router-view></router-view>

  <!-- Newsletter -->
  <section class="bg-indigo-600 py-16">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
      <h2 class="text-3xl font-bold">Subscribe for New Book Updates</h2>
      <p class="mt-3 text-indigo-100">
        Get latest offers, new arrivals and book recommendations.
      </p>

      <div class="mt-8 flex flex-col sm:flex-row gap-4">
        <input 
          type="email" 
          placeholder="Enter your email"
          class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:outline-none"
        />
        <button class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
          Subscribe
        </button>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-10">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">
      
      <div>
        <div class="logo-footer">
          <img src="./assets/img/logo  white.png" alt="">
        </div>
        <p class="text-sm pt-5">
          Your trusted online bookstore for academic and personal reading.
        </p>
      </div>

      <div>
        <h4 class="font-bold text-white mb-3">Quick Links</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-white">Home</a></li>
          <li><a href="#" class="hover:text-white">Books</a></li>
          <li><a href="#" class="hover:text-white">Categories</a></li>
          <li><a href="#" class="hover:text-white">Offers</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-white mb-3">Categories</h4>
        <ul class="space-y-2 text-sm">
          <li>Academic</li>
          <li>Programming</li>
          <li>Fiction</li>
          <li>Business</li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-white mb-3">Contact</h4>
        <p class="text-sm">Email: a2zcsebd.com</p>
        <p class="text-sm mt-2">Phone: +8801351-007888</p>
      </div>

    </div>

    <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm">
      © 2026 a2zcse. All rights reserved.
    </div>
  </footer>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { basicStore } from "./store/basic";
import { cart } from "./store/cart";
const basic = basicStore;
//console.log(settings);
// Mobile menu toggle state
const isOpen = ref(false)

const openMenu = () => {
  isOpen.value = true
}

const closeMenu = () => {
  isOpen.value = false
}

// Close sidebar on Escape key down
const handleKeyDown = (e) => {
  if (e.key === 'Escape' && isOpen.value) {
    closeMenu()
  }
}

// Global lifecycle hooks for structural keyboard accessibility
onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown)
})


</script>

<style scoped>


</style>
