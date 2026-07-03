<template>
<!-- Progress -->
  <section class="max-w-7xl mx-auto px-6 mt-5 relative z-10">
    <div class="bg-white rounded-2xl shadow-lg p-5 grid gap-4 md:grid-cols-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold">1</div>
        <div>
          <h3 class="font-bold">Select Book</h3>
          <p class="text-sm text-gray-500">Review product details</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">2</div>
        <div>
          <h3 class="font-bold">Delivery Details</h3>
          <p class="text-sm text-gray-500">Add name, phone & address</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">3</div>
        <div>
          <h3 class="font-bold">Confirm Order</h3>
          <p class="text-sm text-gray-500">Check total and submit</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Order Content -->
  <main class="max-w-7xl mx-auto px-6 py-14">
    <div id="successMessage" class="hidden mb-8 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800">
      <div class="flex items-start gap-3">
        <div class="text-2xl">✅</div>
        <div>
          <h3 class="font-bold text-lg">Order submitted successfully!</h3>
          <p class="text-sm mt-1">Thank you. Our team will contact you soon to confirm delivery and payment details.</p>
        </div>
      </div>
    </div>

    <form id="orderForm" class="grid lg:grid-cols-3 gap-8 items-start" @submit.prevent="placeOrder">
      <!-- Left: Order Form -->
      <div class="lg:col-span-2 space-y-8">
        <!-- Product Selection -->
        <section class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <div class="flex items-start justify-between gap-4 mb-6">
            <div>
              <h2 class="text-2xl font-bold">Book Information</h2>
              <p class="text-gray-500 mt-1">Review the book and quantity before placing your order.</p>
            </div>
            <span class="hidden sm:inline-flex bg-indigo-50 text-indigo-700 text-sm font-semibold px-3 py-1 rounded-full">In Stock</span>
          </div>
          <template v-for="item in cart.items" :key="item.id">
          <div class="grid md:grid-cols-[150px_1fr] gap-6">
            <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center">
              <img :src="item.product.photo" alt="a2zcse book cover" class="max-h-52 rounded-lg shadow-sm">
            </div>

            <div>
              <h3 class="text-xl font-bold">{{ item.product.title }}</h3>
              <p class="text-gray-500 mt-1">Author: Zahidul Islam</p>

              <div class="mt-4 flex flex-wrap items-center gap-3">
                <span class="text-2xl font-bold text-indigo-600">Tk {{ item.product.reduced_price ?? item.product.price }}</span>
                <span
                  v-if="item.product.reduced_price && Number(item.product.reduced_price) < Number(item.product.price)"
                  class="text-gray-400 line-through"
                >
                  Tk {{ item.product.price }}
                </span>
                <span
                  v-if="discountAmount(item.product) > 0"
                  class="bg-red-50 text-red-600 text-sm font-semibold px-3 py-1 rounded-full"
                >
                  Save Tk {{ discountAmount(item.product) }}
                </span>
              </div>

              <div class="mt-6">
                <label for="quantity" class="block text-sm font-semibold mb-2">Quantity</label>
                <div class="inline-flex items-center border border-gray-300 rounded-lg overflow-hidden">
                  <button @click="cart.decreaseQuantity(item)" type="button" id="decreaseQty" class="px-4 py-3 hover:bg-gray-100 text-lg font-bold" aria-label="Decrease quantity">−</button>
                  <input v-model="item.quantity" id="quantity" name="quantity" type="number" min="1" max="20" value="1"
                    class="w-20 text-center border-x border-gray-300 py-3 focus:outline-none no-spinner" />
                  <button @click="cart.increaseQuantity(item)" type="button" id="increaseQty" class="px-4 py-3 hover:bg-gray-100 text-lg font-bold" aria-label="Increase quantity">+</button>
                </div>
                <button type="button" class="ml-4 text-sm font-semibold text-red-500 p-3" @click="cart.removeItem(item.product)"> X</button>
              </div>
            </div>
          </div>
          </template>
        </section>

        <!-- Customer Information -->
        <section class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <h2 class="text-2xl font-bold mb-6">Customer Information</h2>

          <div class="grid md:grid-cols-2 gap-5">
            <div>
              <label for="fullName" class="block text-sm font-semibold mb-2">Full Name <span class="text-red-500">*</span></label>
              <input id="fullName" name="fullName" :class="cartStore.errorMessage.name ? 'is-invalid' : ''" v-model="name" type="text" required placeholder="Enter your full name"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
              <div v-if="cartStore.errorMessage.name" class="invalid-feedback text-red-500 text-sm mt-1">
                  {{ cartStore.errorMessage.name[0] }}
              </div>
            </div>

            <div>
              <label for="phone" class="block text-sm font-semibold mb-2">Phone Number <span class="text-red-500">*</span></label>
              <input id="phone" name="phone" type="tel" :class="cartStore.errorMessage.phone ? 'is-invalid' : ''" v-model="phone"  required placeholder="01XXXXXXXXX"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
              <div v-if="cartStore.errorMessage.phone" class="invalid-feedback text-red-500 text-sm mt-1">
                  {{ cartStore.errorMessage.phone[0] }}
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-semibold mb-2">Email Address</label>
              <input id="email" name="email" type="email":class="cartStore.errorMessage.email ? 'is-invalid' : ''" v-model="email"  placeholder="example@email.com"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
              <div v-if="cartStore.errorMessage.email" class="invalid-feedback text-red-500 text-sm mt-1">
                  {{ cartStore.errorMessage.email[0] }}
              </div>
            </div>

            <div>
              <label for="state" class="block text-sm font-semibold mb-2">State / District <span class="text-red-500">*</span></label>
              <input id="state" name="state":class="cartStore.errorMessage.state ? 'is-invalid' : ''" v-model="state"  type="text" required placeholder="Dhaka, Chattogram, Khulna..."
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
              <div v-if="cartStore.errorMessage.state" class="invalid-feedback text-red-500 text-sm mt-1">
                  {{ cartStore.errorMessage.state[0] }}
              </div>
            </div>
          </div>
        </section>

        <!-- Delivery Information -->
        <section class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <h2 class="text-2xl font-bold mb-6">Delivery Information</h2>

          <div class="space-y-5">
            <div>
              <label for="address" class="block text-sm font-semibold mb-2">Full Delivery Address <span class="text-red-500">*</span></label>
              <textarea id="address":class="cartStore.errorMessage.address ? 'is-invalid' : ''" v-model="address"  name="address" rows="4" required placeholder="House, road, area, landmark..."
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
              <div v-if="cartStore.errorMessage.address" class="invalid-feedback text-red-500 text-sm mt-1">
                  {{ cartStore.errorMessage.address[0] }}
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold mb-3">Delivery Type <span class="text-red-500">*</span></label>
              <div class="grid sm:grid-cols-2 gap-4">
                <label class="delivery-card cursor-pointer border border-indigo-500 bg-indigo-50 rounded-xl p-4 flex gap-3">
                  <input type="radio" name="shipping_method" @change="cartStore.shippingMethod(shipping_method)" v-model="shipping_method" value="sundarban_point" checked class="mt-1 delivery-option" />
                  <span>
                    <span class="block font-bold">Sundarban Point </span>
                    <!-- <span class="block text-sm text-gray-500">Tk 60 delivery charge</span> -->
                  </span>
                </label>

                <label class="delivery-card cursor-pointer border border-gray-200 rounded-xl p-4 flex gap-3 hover:border-indigo-400">
                  <input type="radio" name="shipping_method" @change="cartStore.shippingMethod(shipping_method)" v-model="shipping_method" value="home_delivery" class="mt-1 delivery-option" />
                  <span>
                    <span class="block font-bold">Home Delivery</span>
                    <!-- <span class="block text-sm text-gray-500">Tk 100 delivery charge</span> -->
                  </span>
                </label>                
              </div>
            </div>
          </div>
        </section>

        <!-- Payment Information -->
        <section class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <h2 class="text-2xl font-bold mb-6">Payment Method</h2>

          <div class="grid sm:grid-cols-2 gap-4">
            <label class="payment-card cursor-pointer border border-gray-200 rounded-xl p-4 flex gap-3 hover:border-indigo-400">
              <input type="radio" v-model="payment_method" name="payment_method" value="Cash on Delivery" class="mt-1 payment-option" />
              <span>
                <span class="block font-bold">Cash on Delivery</span>
                <span class="block text-sm text-gray-500">Pay when you receive the book</span>
              </span>
            </label>

            <label class="payment-card cursor-pointer border border-indigo-500 bg-indigo-50 rounded-xl p-4 flex gap-3 hover:border-indigo-400">
              <input type="radio" v-model="payment_method" name="payment_method" value="bKash" checked class="mt-1 payment-option" />
              <span>
                <span class="block font-bold">bKash</span>
                <span class="block text-sm text-gray-500">Pay first and add transaction ID</span>
              </span>
            </label>

            <label class="payment-card cursor-pointer border border-gray-200 rounded-xl p-4 flex gap-3 hover:border-indigo-400">
              <input type="radio" v-model="payment_method" name="payment_method" value="Nagad" class="mt-1 payment-option" />
              <span>
                <span class="block font-bold">Nagad</span>
                <span class="block text-sm text-gray-500">Mobile payment accepted</span>
              </span>
            </label>

            <label class="payment-card cursor-pointer border border-gray-200 rounded-xl p-4 flex gap-3 hover:border-indigo-400">
              <input type="radio" v-model="payment_method" name="payment_method" value="Rocket" class="mt-1 payment-option" />
              <span>
                <span class="block font-bold">Rocket</span>
                <span class="block text-sm text-gray-500">Mobile payment accepted</span>
              </span>
            </label>
          </div>

          <div id="transactionBox" class="mt-5">
            <label for="transactionId" class="block text-sm font-semibold mb-2">Transaction ID <span class="text-red-500">*</span></label>
            <input id="transactionId"  v-model="txn_id" name="transactionId" required type="text" placeholder="Enter transaction ID after payment"
              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            <div v-if="cartStore.errorMessage.txn_id" class="invalid-feedback text-red-500 text-sm mt-1">
                {{ cartStore.errorMessage.txn_id[0] }}
            </div>
          </div>

          <div class="mt-5">
            <label for="note" class="block text-sm font-semibold mb-2">Order Note</label>
            <textarea id="note" name="note" v-model="note" rows="3" placeholder="Any special instruction?"
              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
          </div>
        </section>
    </div>
      <!-- Right: Order Summary -->
      <aside class="lg:sticky lg:top-28">
        <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <h2 class="text-2xl font-bold mb-6">Order Summary</h2>

        <template v-for="item in cart.items" :key="item.id">
          <div class="flex gap-4 pb-6 border-b">
            <img :src="item.product.photo" alt="a2zcse book cover" class="w-20 h-28 object-cover rounded-lg">
            <div>
              <h3 class="font-bold leading-snug">{{ item.product.title }}</h3>
              <p class="text-sm text-gray-500 mt-1">Zahidul Islam</p>
              <p class="text-indigo-600 font-bold mt-2">Tk {{ item.quantity * item.product.price }}</p>
            </div>
          </div>
        </template>

          <div class="py-6 space-y-4 text-sm">
            <!-- <div class="flex justify-between">
              <span class="text-gray-500">Book Price</span>
              <span class="font-semibold sub-total">Tk <span id="bookPrice">{{ cart.totalPrice }}</span></span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Quantity</span>
              <span class="font-semibold" id="summaryQty">1</span>
            </div> -->
            <div class="flex justify-between">
              <span class="text-gray-500 sub-total">Subtotal</span>
              <span class="font-semibold">Tk <span id="subtotal">{{ cart.totalPrice }}</span></span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Delivery Charge</span>
              <span class="font-semibold ship-cost">Tk <span id="deliveryCharge">{{ cart.shippingCost }}</span></span>
            </div>
          </div>

          <div class="border-t pt-5 flex justify-between items-center">
            <span class="text-lg font-bold">Total</span>
            <span class="text-2xl font-bold text-indigo-600">Tk <span id="totalAmount">{{ cart.grandTotal }}</span></span>
          </div>

          <div class="mt-6 bg-gray-50 rounded-xl p-4 space-y-3 text-sm text-gray-600">
            <div class="flex gap-2">
              <span>🚚</span>
              <p>Delivery time: Inside Dhaka 1–2 days, outside Dhaka 2–4 days.</p>
            </div>
            <div class="flex gap-2">
              <span>📞</span>
              <p>Our team will call you before dispatching the order.</p>
            </div>
            <div class="flex gap-2">
              <span>🔒</span>
              <p>Your information is used only for order confirmation and delivery.</p>
            </div>
          </div>
        </div>
          <button type="submit" @click="cartStore.placeOrder(name, phone, email, state, address, shipping_method, payment_method, txn_id, note)" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 shadow-lg shadow-indigo-200">
          Confirm Order
        </button>
     
      </aside>
    </form>
  
  </main>

</template>
<script setup>
import { ref, computed } from "vue";
import { cart } from "../store/cart";
const cartStore = cart;

const name = ref('')
const phone = ref('')
const email = ref('')
const state = ref('')
const address = ref('')
const shipping_method = ref('sundarban_point')
const payment_method = ref('bKash')
const txn_id = ref('')
const note = ref('')

function discountAmount(product) {
  if (!product.price || !product.reduced_price) return 0;
  const diff = Number(product.price) - Number(product.reduced_price);
  return diff > 0 ? diff : 0;
}

/*
function metaInfo() {
        return {
            title: "Checkout",
            meta: [
                { name: 'description', content:  'Checkout' },
                { property: 'og:title', content: "Checkout"},
                { property: 'og:site_name', content: 'Laravel-10-Vue-Ecommerce'},
                {property: 'og:type', content: 'website'},    
                {name: 'robots', content: 'index,follow'} 
            ]
        }
    }
*/
</script>
<style scoped>
/* ক্রোম, সাফারি, এজ এবং অপেরার জন্য */
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* ফায়ারফক্সের (Firefox) জন্য */
.no-spinner {
  -moz-appearance: textfield;
}
</style>