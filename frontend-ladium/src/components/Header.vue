<script setup>
import { cart } from "../store/cart";
import { wishlist } from "../store/wishlist";
</script>
<template>
      <header class="bg-[#f5f5f5] py-3 sticky top-0 left-0 z-50 px-5 md:px-0">
        <div class="container-fluid mx-auto px-5">
          <div
            class="flex sm:flex-none sm:grid sm:grid-cols-3 xl:grid-cols-12 items-center xl:gap-20 gap-5 justify-between relative"
          >
            <!-- logo -->
            <div class="xl:col-span-2">
              <div class="w-[5.625rem] md:w-full">
                <router-link to="/">
                <img
                  class="w-full h-full"
                  src="../assets/images/logo.png"
                  alt="logo"
                />
                </router-link>
              </div>
            </div>
            <!-- desktop nav -->
            <nav
              class="hidden xl:block col-span-6 text-primary font-medium text-sm"
            >
              <ul class="flex gap-5 justify-center">
                <li>
                  <a href="/index.html">Home</a>
                </li>
                <li class="">
                  <a href="#">Woman </a>
                </li>
                <li><a href="/category.html">Plus Size</a></li>
                <li><a href="#">Sports Top</a></li>
                <li><a href="#">Sports Leggings</a></li>
                <li><a href="#">GYM Yoga</a> Set</li>
                <li><a href="#">Sports Bra</a></li>
              </ul>
            </nav>
            <!-- mobile nav -->
            <nav
              class="hidden text-primary font-semibold sm:text-xs bg-white absolute -right-0 top-[150%] w-full p-5 rounded z-50 MobielMenuItem"
            >
              <ul class="flex flex-col gap-5 justify-center">
                <li>
                  <a href="/index.html">Home</a>
                </li>
                <li class="">
                  <a href="#">Woman </a>
                </li>
                <li><a href="/category.html">Plus Size</a></li>
                <li><a href="#">Sports Top</a></li>
                <li><a href="#">Sports Leggings</a></li>
                <li><a href="#">GYM Yoga</a> Set</li>
                <li><a href="#">Sports Bra</a></li>
              </ul>
            </nav>

            <div class="xl:col-span-4 flex items-center gap-5 justify-between">
              <!-- search -->
              <div class="hidden md:block">
                <input
                  type="text"
                  placeholder="Search"
                  class="border border-[#ced9d9] text-primary px-3 py-[.375rem] rounded-md inline-block w-24 lg:w-full"
                />
              </div>
              <div class="flex items-center justify-between gap-5">
                <!-- shop -->
                <router-link to="/dashboard/account" class="flex gap-2 items-start">
                  <div>
                    <i class="fa-regular fa-circle-user"></i>
                  </div>
                  <div class="-mt-1">
                    <i class="fa-solid fa-sort-down"></i>
                  </div>
                </router-link>
                <!-- cart -->
                <div class="flex items-center gap-2">
                    <router-link to="/dashboard/wishlist" class="text-[#212529] opacity-75 relative">
                        <i class="fa-solid fa-heart"></i>
                        <span class="absolute -right-2 -top-3">{{ wishlist.totalWishlistItems }}</span>                        
                    </router-link>
                    <router-link to="/cart" class="relative">
                    <span><font-awesome-icon :icon="['fas', 'cart-shopping']" /></span>
                    <span class="absolute -right-2 -top-3">{{ cart.totalCartItems }}</span>
                  </router-link>
                </div>
              </div>
              <div>
                <!-- font awsome humbarger menu -->
                <div
                  class="block xl:hidden text-primary font-semibold text-[.5rem] sm:text-xs"
                >
                  <button
                    class="focus:outline-none text-xl"
                    onclick="document.querySelector('.MobielMenuItem').classList.toggle('!block')"
                  >
                    <i class="fa-solid fa-bars"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- sidebar -->
      </header>
</template>