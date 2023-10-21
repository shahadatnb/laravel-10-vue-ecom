<template>
    <!-- Checkout Start -->
    <div class="checkout">
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-inner">
                            <div class="billing-address">
                                <p>অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span>Submit Your Order</span>  বাটনে ক্লিক করুন </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Enter Your Full Name</label>
                                        <input class="form-control" v-model="name" type="text" placeholder=" সম্পূর্ন নামটি লিখুন ">
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <label>Enter Mobile No</label>
                                        <input class="form-control" v-model="mobile" type="text" placeholder=" ১১ ডিজিটের মোবাইল নাম্বার লিখুন ">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Enter Full Address</label>
                                        <input class="form-control" v-model="address" type="text" placeholder=" সম্পূর্ন ঠিকানা লিখুন ">
                                    </div>                            
                                  
                                    
                                    <div class="col-md-12">
                                        <label>Choose Delivery Area </label>
                                        <select @change="cartStore.shippingMethod(shipping_method)" v-model="shipping_method" class="custom-select">
                                            <option value="" selected> ডেলিভারি এরিয়া নির্বাচন করুন </option>
                                            <option value="ঢাকার ভিতরে"> ঢাকার ভিতরে </option>
                                            <option value="ঢাকার বাহিরে"> ঢাকার বাহিরে </option>                                            
                                        </select>
                                    </div>
                                  
                                    <div class="col-md-12 text-center">
                                        <div class="checkout-btn">
                                            <button @click="cartStore.placeOrder(name, mobile, address, shipping_method)"> Submit Your Order </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                       
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-inner">
                            <div class="checkout-summary">
                                <h1>Cart Total</h1>
                                <p v-for="item in cart.items" :key="item.id">{{ item.product.title }}<span>{{ item.quantity * item.product.price }}</span></p>
                                <p class="sub-total">Sub Total<span>{{ cart.totalPrice }}</span></p>
                                <p class="ship-cost">Shipping Cost<span>{{ cart.shippingCost }}</span></p>
                                <h2>Grand Total<span>{{ cart.grandTotal }}</span></h2>
                            </div>

              
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->
</template>
<script setup>
import { ref } from "vue";
import { basicStore } from "../store/basic";
import { cart } from "../store/cart";
const cartStore = cart;

const name = ref('')
const mobile = ref('')
const address = ref('')
const shipping_method = ref('')

</script>