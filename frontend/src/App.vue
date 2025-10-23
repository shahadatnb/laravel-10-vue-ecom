<template>
  <!-- Top bar Start -->
  <div class="top-bar">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <i class="fa fa-envelope"></i>
          {{ basic.settings.siteEmail }}
        </div>
        <div class="col-sm-6">
          <i class="fa fa-phone-alt"></i>
          {{ basic.settings.sitePhone }}
        </div>
      </div>
    </div>
  </div>
  <!-- Top bar End -->

  <!-- Nav Bar Start -->
  <div class="nav">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a href="#" class="navbar-brand">MENU</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
          <div class="navbar-nav mr-auto">
            <template v-if="basic.settings.menus">
              <router-link v-for="menu in basic.settings.menus.main" :key="menu.id" :to="menu.menu_url" class="nav-item nav-link">{{menu.lebel}}</router-link>
            </template>
              <!-- <router-link :to="'/contact'" class="nav-item nav-link">Contact</router-link> -->
            <!-- <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dry Fruits  </a>
              <div class="dropdown-menu">
                <a href="wishlist.html" class="dropdown-item">Wishlist</a>
                <a href="login.html" class="dropdown-item">Login & Register</a>
                <a href="contact.html" class="dropdown-item">Contact Us</a>
              </div>
            </div> -->
          </div>
          <!-- <div class="navbar-nav ml-auto">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
              <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Login</a>
                <a href="#" class="dropdown-item">Register</a>
              </div>
            </div>
          </div> -->
        </div>
      </nav>
    </div>
  </div>
  <!-- Nav Bar End -->

  <!-- Bottom Bar Start -->
  <div class="bottom-bar">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-3">
          <div class="logo">
          <router-link to="/" >
              <img :src="basic.serverUrl + '/upload/site_file/' + basic.settings.siteLogo" alt="Logo">
          </router-link>
          </div>
        </div>
        <div class="col-md-6">
          <div class="search">
            <input type="text" placeholder="Search">
            <button><i class="fa fa-search"></i></button>
          </div>
        </div>
        <div class="col-md-3">
          <div class="user">
            <!-- <router-link :to="/" class="btn wishlist">
              <i class="fa fa-heart"></i>
              <span>(0)</span>
            </router-link> -->
            <router-link :to="'/cart'" class="btn cart">
              <i class="fa fa-shopping-cart"></i>
              <span>({{ cart.totalCartItems }})</span>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bottom Bar End -->
<router-view></router-view>
  <!-- Footer Start -->
  <div class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="footer-widget">
            <h2>Get in Touch</h2>
            <div class="contact-info">
              <p><i class="fa fa-map-marker"></i>{{ basic.settings.siteAddress }}</p>
              <p><i class="fa fa-envelope"></i>{{ basic.settings.siteEmail }}</p>
              <p><i class="fa fa-phone"></i>{{ basic.settings.sitePhone }}</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="footer-widget">
            <h2>Follow Us</h2>
            <div class="contact-info">
              <div class="social">
                <a :href="basic.settings.facebook"><i class="fab fa-facebook-f"></i></a>
                <!-- <a href=""><i class="fab fa-linkedin-in"></i></a> -->
                <!-- <a href=""><i class="fab fa-instagram"></i></a> -->
                <a :href="basic.settings.youtube"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="footer-widget">
            <h2>Company Info</h2>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Terms & Condition</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="footer-widget">
            <h2>Purchase Info</h2>
            <ul>
              <li><a href="#">Pyament Policy</a></li>
              <li><a href="#">Shipping Policy</a></li>
              <li><a href="#">Return Policy</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- <div class="row payment align-items-center">
        <div class="col-md-6">
          <div class="payment-method">
            <h2>We Accept:</h2>
            <img src="./assets/img/payment-method.png" alt="Payment Method" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="payment-security">
            <h2>Secured By:</h2>
            <img src="./assets/img/godaddy.svg" alt="Payment Security" />
            <img src="./assets/img/norton.svg" alt="Payment Security" />
            <img src="./assets/img/ssl.svg" alt="Payment Security" />
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <!-- Footer End -->

  <!-- Footer Bottom Start -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 copyright">
          <p>Design & Developed by &copy; <a href="https://asiancoder.com">Asian Coder</a></p>
        </div>

        <div class="col-md-6 template-by">
          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->

        </div>
      </div>
    </div>
  </div>
  <!-- Footer Bottom End -->

  <!-- Back to Top -->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
</template>
<script setup>
import { basicStore } from "./store/basic";
import { cart } from "./store/cart";
const basic = basicStore;


//console.log(settings);

</script>

<style scoped>


</style>
