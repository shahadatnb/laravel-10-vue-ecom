<script setup>
import { ref } from "vue";
import Sidebar from './Sidebar.vue';
import { authStore } from "../../store/authStore";
const auth = authStore.userProfile
const email = ref(auth.email)
const name = ref(auth.name)
const address = ref(auth.address)
const phone = ref(auth.phone)
const zip_code = ref(auth.zip_code)
const date_of_birth = ref(auth.date_of_birth)
</script>
<template>
    <!-- breadcrumb -->
    <div class="container py-4 flex items-center gap-3">
        <router-link to="/" class="text-primary text-base">
            <font-awesome-icon icon="fa-solid fa-house" />
        </router-link>
        <span class="text-sm text-gray-400">
            <font-awesome-icon icon="fa-solid fa-chevron-right" />
        </span>
        <p class="text-gray-600 font-medium">Profile</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16">

        <!-- sidebar -->
        <Sidebar />
        <!-- ./sidebar -->

        <!-- info -->
        <div class="col-span-12 lg:col-span-9 shadow rounded px-6 pt-5 pb-7">
            <h4 class="text-lg font-medium capitalize mb-4">
                Profile information
            </h4>
            <div class="">
                <!-- <div class="grid grid-cols-2 gap-4"> -->
                    <div class="w-full flex justify-start items-center gap-2 my-2">
                        <label class="w-28" for="first">Full Name:</label>
                        <input type="text" name="first" id="first" v-model="name" class="input-box">
                    </div>
                    <span v-if="authStore.errorMessage.name" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                        {{ authStore.errorMessage.name[0] }}
                    </span>
                    <div class="w-full flex justify-start items-center gap-2 my-2">
                        <label class="w-28" for="last">Address:</label>
                        <textarea type="text" name="last" id="last" v-model="address" class="input-box h-32"></textarea>
                    </div>
                    <span v-if="authStore.errorMessage.address" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                        {{ authStore.errorMessage.address[0] }}
                    </span>
                    <div class="w-full flex justify-start items-center gap-2 my-2">
                        <label class="w-28" for="zip_code">Zip/Postal Code:</label>
                        <input type="text" name="zip_code" id="zip_code" v-model="zip_code" class="input-box">
                    </div>
                    <span v-if="authStore.errorMessage.zip_code" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ authStore.errorMessage.zip_code[0] }}</span>
                <!-- </div> -->
                <!--
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birthday">Birthday</label>
                        <input type="text" name="birthday" id="birthday" v-model="date_of_birth" class="input-box">
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="input-box">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
            -->
                <!-- <div class="grid grid-cols-2 gap-4"> -->
                    <div class="w-full flex justify-start items-center gap-2 my-2">
                        <label class="w-28" for="email">Email Address:</label>
                        <input type="email" name="email" id="email" v-model="email" class="input-box">
                    </div>
                    <span v-if="authStore.errorMessage.email" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ authStore.errorMessage.email[0] }}</span>
                    <div class="w-full flex justify-start items-center gap-2 my-2">
                        <label class="w-28" for="phone">Phone Number:</label>
                        <input type="text" name="phone" id="phone" v-model="phone" class="input-box">
                    </div>
                    <span v-if="authStore.errorMessage.phone" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ authStore.errorMessage.phone[0] }}</span>
                <!-- </div> -->
            </div>

            <div class="mt-4">
                <button type="submit" @click="authStore.updateProfile(name, email, phone, address, zip_code, date_of_birth)"
                    class="py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">save
                    changes</button>
            </div>
        </div>
        <!-- ./info -->

    </div>
    <!-- ./wrapper -->
</template>