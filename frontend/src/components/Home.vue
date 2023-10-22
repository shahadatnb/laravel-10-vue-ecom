<template>
  <!-- Main Slider Start -->
  <div class="header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <LeftSidebar></LeftSidebar>
        </div>
        <div class="col-md-6">
            <Slider></Slider>
        </div>
        <div class="col-md-3">
          <div class="header-img">
            <div v-for="slide in slides" :key="slide.id" class="img-item">
              <img :src="slide.image" />
              <a class="img-text" :href="slide.postMeta.link">
                <p>{{ slide.title }}</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Main Slider End -->

  <!-- Brand Start -->
  <!-- <div class="brand">
      <div class="container-fluid">
          <div class="brand-slider">
              <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
              <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
              <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
              <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
              <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
              <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
          </div>
      </div>
  </div> -->
  <!-- Brand End -->
  <!-- Feature Start-->
  <div class="feature">
    <div class="container-fluid">
      <div class="row align-items-center">
        <template v-if="basic.settings.menus">
        <div v-for="feature in basic.settings.menus.lebel" :key="feature.id" class="col-lg-3 col-md-6 feature-col">          
          <div class="feature-content">
            <i :class="feature.menu_class"></i>
            <h2>{{ feature.lebel }}</h2>
            <!-- <p>
              Lorem ipsum dolor sit amet consectetur elit
            </p> -->
          </div>
        </div>
      </template>
      </div>
    </div>
  </div>
  <!-- Feature End-->

  <!-- Category Start-->
    <!-- <Categories></Categories> -->
  <!-- Category End-->

  <!-- Call to Action Start -->
  <div class="call-to-action">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1>call us for any queries</h1>
        </div>
        <div class="col-md-6">
          <a :href="'tel:' + basic.settings.sitePhone">{{ basic.settings.sitePhone }}</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Call to Action End -->

  <!-- Featured Product Start -->
    <HotProduct></HotProduct>
  <!-- Featured Product End -->

  <!--    sexaul wellness start -->
    <AllProducts></AllProducts>
  <!-- sexaul wellness end-->

  <!-- Review Start -->
   <Review></Review>
  <!-- Review End -->
<!--    <div>-->
<!--        <button @click="notify">Notify !</button>-->
<!--        <button @click="warning">Alert !</button>-->
<!--    </div>-->
</template>

<script setup>
import LeftSidebar from "./homepage/LeftSidebar.vue";
import Slider from "./homepage/Slider.vue";
import HotProduct from "./homepage/HotProduct.vue";
import AllProducts from "./homepage/AllProducts.vue";
import Categories from "./homepage/Categories.vue";
import Review from "./homepage/Review.vue";
import {onMounted,onBeforeMount,ref,computed, onUpdated} from "vue";
import axios from "axios";
import { basicStore } from "../store/basic";
const basic = basicStore;
const slides = ref([])

//lebels.value = basic.settings.menus.lebel
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=offer&take=2`)
      .then(res => {
          //console.log(res.data)
          slides.value = res.data.data
      });
})

onMounted(()=>{
$(function () {
    "use strict";
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 768) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }

        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });
});
});

//import { toast } from 'vue3-toastify';
//import 'vue3-toastify/dist/index.css';
/*
const notify = () => {
    toast("Success !", {
        autoClose: 1000,
        type: 'success',
    });
}

const warning = () => {
    toast("Alert !", {
        autoClose: 1000,
        type: 'warning',
    });
}
*/

</script>

<style scoped>

</style>
