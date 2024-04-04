<script setup>
import { ref } from "vue";
import { cart } from "../store/cart";
import { authStore } from "../store/authStore";
import { order } from "../store/order";
const cartStore = cart;
const user = authStore.user.user
const name = ref(user.name)
const phone = ref(user.phone)
const address = ref(user.address)
const email = ref(user.email)
const city = ref(user.city)
const postalCode = ref(user.postalCode)
</script>
<template>
    <!-- breadcrumb -->
    <div class="container py-4 flex items-center gap-3">
        <router-link to="/" class="text-primary text-base">
            <!-- <i class="fa-solid fa-house"></i> -->
            <font-awesome-icon icon="fa-solid fa-house" />
        </router-link>
        <span class="text-sm text-gray-400">
            <!-- <i class="fa-solid fa-chevron-right"></i> -->
            <font-awesome-icon icon="fa-solid fa-chevron-right" />
        </span>
        <p class="text-gray-600 font-medium">Checkout</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- wrapper -->
    <div class="container">
        <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-[66%] p-5 lg:px-[50px] py-10 rounded">
            <h3 class="text-lg font-medium capitalize mb-4">Shipping Address</h3>
            <div class="space-y-4 flex gap-5 flex-wrap justify-between">

                <!-- <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first-name" class="text-gray-600">First Name <span
                                class="text-primary">*</span></label>
                        <input type="text" name="first-name" id="first-name" class="input-box">
                    </div>
                    <div>
                        <label for="last-name" class="text-gray-600">Last Name <span
                                class="text-primary">*</span></label>
                        <input type="text" name="last-name" id="last-name" class="input-box">
                    </div>
                </div> -->
                <div class="w-full md:w-[100%]">
                    <input
                    class="w-full border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white"
                    required=""
                    :class="order.errorMessage.name ? 'border-red-500' : ''"
                    placeholder="Name"
                    v-model="name"
                    name="first_name"
                    type="text"
                    />
                    <span v-if="order.errorMessage.name" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.name[0] }}</span>
                </div>
                <div class="w-full md:w-[48%]">
                    <input
                    class="w-full border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white"
                    required=""
                    placeholder="Email"
                    v-model="email"
                    name="email"
                    type="email"
                    :class="order.errorMessage.email ? 'border-red-500' : ''"
                    />
                    <span v-if="order.errorMessage.email" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.email[0] }}</span>
                </div>
                <div class="w-full md:w-[48%]">
                    <input
                    class="w-full border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white"
                    required=""
                    placeholder="Phone"
                    v-model="phone"
                    name="phone"
                    type="text"
                    :class="order.errorMessage.phone ? 'border-red-500' : ''"
                    />
                    <span v-if="order.errorMessage.phone" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.phone[0] }}</span>
                </div>
                <div class="w-full col-span-2">
                    <input
                    class="border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white w-full"
                    required=""
                    v-model="address"
                    placeholder="Address"
                    name="address1"
                    type="text"
                    :class="order.errorMessage.address ? 'border-red-500' : ''"
                    />
                    <span v-if="order.errorMessage.address" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.address[0] }}</span>
                </div>
                <div class="w-full md:w-[48%]">
                        <input
                        class="w-full border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white"
                        required=""
                        placeholder="City"
                        name="city"
                        type="text"
                        v-model="city"
                        />
                        <span v-if="order.errorMessage.city" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.city[0] }}</span>
                    </div>
                    <div class="w-full md:w-[48%]">
                        <input
                        class="w-full border-[#dee2e6] px-[15px] py-[10px] text-[#212529] border rounded-md bg-white"
                        placeholder="Postal Code"
                        name="postcode"
                        v-model="postalCode"
                        type="text"
                        :class="order.errorMessage.postalCode ? 'border-red-500' : ''"
                        />
                        <span v-if="order.errorMessage.postalCode" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.postalCode[0] }}</span>
                    </div>
                <!-- <div>
                    <label for="country" class="text-gray-600">Country/Region</label>
                    <input type="text" name="country" id="country" v-model="country" class="input-box"
                            :class="order.errorMessage.country ? 'border-red-500' : ''">
                            <span v-if="order.errorMessage.country" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ order.errorMessage.country[0] }}</span>
                </div> -->
            </div>

        </div>
        <div class="w-full lg:w-[33%] border-l-[#dee2e6] border-l pl-6 py-10 rounded" >
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
            <div class="space-y-2">
                <div v-for="item in cart.items" :key="item.id" class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium">{{ item.product.title }}</h5>
                        <!-- <p class="text-sm text-gray-600">Size: M</p> -->
                    </div>
                    <p class="text-gray-600">
                        x{{ item.quantity }}
                    </p>
                    <p class="text-gray-800 font-medium">৳{{ item.product.price * item.quantity }}</p>
                </div>                
            </div>

            <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>Subtotal</p>
                <p>৳{{ cart.totalPrice }}</p>
            </div>

            <!-- <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>Shipping</p>
                <p>Free</p>
            </div> -->

            <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
                <p class="font-semibold">Total</p>
                <p>৳{{ cart.totalPrice}}</p>
            </div>

            <div class="flex items-center mb-4 mt-2">
                <input type="checkbox" name="aggrement" id="aggrement"
                    class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3">
                <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer text-sm">I agree to the <a href="#"
                        class="text-primary">terms & conditions</a></label>
            </div>

            <a href="#" @click="order.placeOrder(name, phone, email, address, city, postalCode)"
                class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">Place
                order</a>
        </div>

    </div>
    </div>
    <!-- ./wrapper -->
</template>