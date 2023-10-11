<template>
  <!-- Main Slider Start -->
  <div class="header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <nav class="navbar bg-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-home"></i>   Personal Care </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-shopping-bag"></i>Sexual wellness</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-plus-square"></i>Hair care</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-female"></i>Fashion & Beauty</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-child"></i>Kids & Babies Clothes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-tshirt"></i>Men & Women Clothes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-mobile-alt"></i>Gadgets & Accessories</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-microchip"></i>Electronics Accessories</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-6">
            <Slider></Slider>
        </div>
        <div class="col-md-3">
          <div class="header-img">
            <div class="img-item">
              <img src="/img/diaetic-care-compressor.jpg" />
              <a class="img-text" href="">
                <p>Some text goes here that describes the image</p>
              </a>
            </div>
            <div class="img-item">
              <img src="/img/improve-memory-compressor-1.jpg" />
              <a class="img-text" href="">
                <p>Some text goes here that describes the image</p>
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
        <div class="col-lg-3 col-md-6 feature-col">
          <div class="feature-content">
            <i class="fab fa-cc-mastercard"></i>
            <h2>Cash on Delivery</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur elit
            </p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 feature-col">
          <div class="feature-content">
            <i class="fa fa-truck"></i>
            <h2>First  Delivery</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur elit
            </p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 feature-col">
          <div class="feature-content">
            <i class="fa fa-sync-alt"></i>
            <h2>10 Days Return</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur elit
            </p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 feature-col">
          <div class="feature-content">
            <i class="fa fa-comments"></i>
            <h2>24/7 Support</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur elit
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Feature End-->

  <!-- Category Start-->
    <Categories></Categories>
  <!-- Category End-->

  <!-- Call to Action Start -->
  <div class="call-to-action">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1>call us for any queries</h1>
        </div>
        <div class="col-md-6">
          <a href="tel:0123456789">+012-345-6789</a>
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
<!--    <Review></Review>-->
  <!-- Review End -->
<!--    <div>-->
<!--        <button @click="notify">Notify !</button>-->
<!--        <button @click="warning">Alert !</button>-->
<!--    </div>-->
</template>

<script setup>
import Slider from "./homepage/Slider.vue";
import HotProduct from "./homepage/HotProduct.vue";
import AllProducts from "./homepage/AllProducts.vue";
import Categories from "./homepage/Categories.vue";
import Review from "./homepage/Review.vue";
import {onMounted} from "vue";

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
