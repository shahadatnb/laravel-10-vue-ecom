<template>
<div>
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">Cart</li>
            </ul>
        </div>
    </div>
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    <tr v-for="item in cart.items" :key="item.id">
                                        <td>
                                            <div class="img">
                                                <a href="#"><img :src="item.product.photo" alt="Image"></a>
                                                <p>{{ item.product.title }}</p>
                                            </div>
                                        </td>
                                        <td>{{ item.product.price }}</td>
                                        <td>
                                            <div class="qty">
                                                <button @click="cart.decreaseQuantity(item)" class="btn-minus"><i class="fa fa-minus"></i></button>
                                                <input type="text" v-model="item.quantity">
                                                <button @click="cart.increaseQuantity(item)" class="btn-plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td>{{ item.product.price * item.quantity }}</td>
                                        <td><button @click="cart.removeItem(item.product)"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-page-inner">
                        <div class="row">
                            <!-- <div class="col-md-12">
                                <div class="coupon">
                                    <input type="text" placeholder="Coupon Code">
                                    <button>Apply Code</button>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h1>Cart Summary</h1>
                                        <p>Sub Total<span>{{ cart.totalPrice }}</span></p>
                                        <p>Shipping Cost<span>{{ cart.shippingCost }}</span></p>
                                        <h2>Grand Total<span>{{ cart.grandTotal }}</span></h2>
                                    </div>
                                    <div class="cart-btn">
                                        <!-- <button @click="cart.saveCartInLocalStorage()">Update Cart</button> -->
                                        <button @click="cart.emptyCart()">Empty Cart</button>
                                        <button @click="cart.checkout()">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { cart } from "../store/cart";
const cartStore = cart;
</script>