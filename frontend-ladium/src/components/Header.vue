<script setup>
import { ref } from "vue";
import { cart } from "../store/cart";
import { wishlist } from "../store/wishlist";
import { basicStore } from "../store/basic";
const basic = basicStore;
import SearchResult from "./homepage/SearchResult.vue";
const MobielMenuItem = ref(false);
const SearchBox = ref(false);
function mobileMenuToggle() {
    MobielMenuItem.value = !MobielMenuItem.value;
}
function searchToggle() {
    SearchBox.value = !SearchBox.value;
    const searchText = ref("");
}
</script>
<style scoped>
.menu-item {
    border-bottom: 1px solid #636363;
}
</style>
<template>
    <header class="bg-[#f5f5f5] py-3 sticky top-0 left-0 z-50 px-5 md:px-0">
        <div class="container-fluid mx-auto px-5">
            <div
                class="flex sm:flex-none sm:grid sm:grid-cols-3 xl:grid-cols-12 items-center xl:gap-20 gap-5 justify-between relative"
            >
                <!-- logo -->
                <div class="col-span-1 xl:col-span-2">
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
                    <ul
                        class="flex gap-5 justify-end"
                        v-if="basic.settings.menus"
                    >
                        <li
                            v-for="menu in basic.settings.menus.main"
                            :key="menu.id"
                        >
                            <router-link :to="menu.menu_url" class="font-semibold">{{
                                menu.lebel
                            }}</router-link>
                        </li>
                    </ul>
                </nav>
                <div
                    class="col-span-2 xl:col-span-4 flex items-center gap-5 justify-end"
                >
                    <!-- search -->
                    <div class="hidden">
                        <input
                            @click="searchToggle"
                            type="text"
                            placeholder="Search"
                            class="border border-[#ced9d9] text-primary px-3 py-[.375rem] rounded-md inline-block w-24 lg:w-full"
                        />
                    </div>
                    <div class="flex items-center justify-between gap-5">
                        <div
                            @click="searchToggle"
                            class="cursor-pointer hover:text-[#0d6efd]"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'magnifying-glass']"
                            />
                        </div>
                        <!-- shop -->
                        <router-link
                            to="/dashboard/account"
                            class="flex gap-2 items-start"
                        >
                            <div class="hover:text-[#0d6efd]">
                                <font-awesome-icon :icon="['fas', 'user']" />
                            </div>
                            <!-- <div class="-mt-1">
                    <i class="fa-solid fa-sort-down"></i>
                  </div> -->
                        </router-link>
                        <!-- cart -->
                        <div class="flex items-center gap-2">
                            <router-link
                                to="/dashboard/wishlist"
                                class="hover:text-[#0d6efd] relative mr-3"
                            >
                                <font-awesome-icon :icon="['fas', 'heart']" />
                                <span class="absolute -right-2 -top-3">{{
                                    wishlist.totalWishlistItems
                                }}</span>
                            </router-link>
                            <router-link
                                to="/cart"
                                class="relative hover:text-[#0d6efd]"
                            >
                                <span
                                    ><font-awesome-icon
                                        :icon="['fas', 'cart-shopping']"
                                /></span>
                                <span class="absolute -right-2 -top-3">{{
                                    cart.totalCartItems
                                }}</span>
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
                                @click="mobileMenuToggle"
                            >
                                <font-awesome-icon
                                    v-if="!MobielMenuItem"
                                    :icon="['fas', 'bars']"
                                />
                                <font-awesome-icon
                                    v-else
                                    :icon="['fas', 'xmark']"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sidebar -->
    </header>
    <!-- mobile nav -->
    <nav
        v-show="MobielMenuItem"
        class="text-primary font-semibold sm:text-xs bg-[#f5f5f5] fixed -right-0 top-[50px] w-full p-5 rounded z-50 MobielMenuItem"
    >
        <ul
            class="flex flex-col gap-0 justify-center px-3"
            v-if="basic.settings.menus"
        >
            <li
                @click="mobileMenuToggle"
                v-for="menu in basic.settings.menus.main"
                :key="menu.id"
                class="menu-item hover:bg-[#ddd]"
            >
                <router-link :to="menu.menu_url" class="w-full text-xl block p-2">{{
                    menu.lebel
                }}</router-link>
            </li>
        </ul>
    </nav>
    <transition name="fade">
        <div v-if="SearchBox" class="fixed inset-0 z-50">
            <div
                @click="searchToggle"
                class="absolute bg-black opacity-70 inset-0 z-0"
            ></div>
            <div
                class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
            >
                <SearchResult @searchToggle="searchToggle" />
            </div>
        </div>
    </transition>
</template>
