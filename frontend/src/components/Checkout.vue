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
                                    <div class="col-md-12 mb-2">
                                        <label>Enter Your Full Name</label>
                                        <input class="form-control mb-1" :class="cartStore.errorMessage.name ? 'is-invalid' : ''" v-model="name" aria-describedby="nameError" type="text" placeholder=" সম্পূর্ন নামটি লিখুন ">
                                        <div v-if="cartStore.errorMessage.name" id="nameError" class="invalid-feedback">
                                            {{ cartStore.errorMessage.name[0] }}
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12 mb-2">
                                        <label>Enter Mobile No</label>
                                        <input class="form-control mb-1" :class="cartStore.errorMessage.phone ? 'is-invalid' : ''" v-model="phone" aria-describedby="phoneError" type="text" placeholder=" ১১ ডিজিটের মোবাইল নাম্বার লিখুন ">
                                        <div v-if="cartStore.errorMessage.phone" id="phoneError" class="invalid-feedback">
                                            {{ cartStore.errorMessage.phone[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Enter Full Address</label>
                                        <input class="form-control mb-1" :class="cartStore.errorMessage.address ? 'is-invalid' : ''" v-model="address" type="text" aria-describedby="addressError" placeholder=" সম্পূর্ন ঠিকানা লিখুন ">
                                        <div v-if="cartStore.errorMessage.address" id="addressError" class="invalid-feedback">
                                            {{ cartStore.errorMessage.address[0] }}
                                        </div>
                                    </div>                            
                                  
                                    
                                    <div class="col-md-12">
                                        <label>Choose Delivery Area </label>
                                        <select @change="cartStore.shippingMethod(shipping_method)" v-model="shipping_method" class="custom-select mb-1" :class="cartStore.errorMessage.address ? 'is-invalid' : ''" aria-describedby="shipping_methodError">
                                            <option value="" selected> ডেলিভারি এরিয়া নির্বাচন করুন </option>
                                            <option value="ঢাকার ভিতরে"> ঢাকার ভিতরে </option>
                                            <option value="ঢাকার বাহিরে"> ঢাকার বাহিরে </option>                                            
                                        </select>
                                        <div v-if="cartStore.errorMessage.shipping_method" id="shipping_methodError" class="invalid-feedback">
                                            {{ cartStore.errorMessage.shipping_method[0] }}
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12 text-center">
                                        <div class="checkout-btn">
                                            <button @click="cartStore.placeOrder(name, phone, address, shipping_method)"> Submit Your Order </button>
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

            <div class="modal" id="checkoutModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">অর্ডার সফল হয়েছে</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>খুব শীঘ্রই আপনার সাথে যোগাযোগ করা হবে</p>
                    </div>
                    <div class="modal-footer">
                        <router-link to="/" type="button" class="btn btn-secondary" data-dismiss="modal">Close</router-link>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->
</template>
<script setup>
import { ref } from "vue";
import { cart } from "../store/cart";
const cartStore = cart;

const name = ref('')
const phone = ref('')
const address = ref('')
const shipping_method = ref('')

</script>