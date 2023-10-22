<template>
    <nav class="navbar bg-light">
        <ul v-if="basic.settings.menus" class="navbar-nav">
            <li v-for="menu in basic.settings.menus.categories" :key="menu.id" class="nav-item">                
                <router-link class="nav-link" :to="menu.menu_url"><i :class="menu.menu_class"></i>  {{ menu.lebel }} </router-link>
            </li>            
        </ul>
    </nav>
</template>
<script setup>
import { ref, onUpdated } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;

</script>