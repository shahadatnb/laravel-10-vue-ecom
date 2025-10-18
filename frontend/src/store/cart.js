import {reactive, computed} from 'vue'
import { toast } from 'vue3-toastify';
import { basicStore } from './basic'
const basic = basicStore
import router from '../router/router'
const cart = reactive({
    items:{},
    errorMessage: {},
    shippingCost:0,
    totalCartItems:computed(()=>{
        let total = 0
        for(let id in cart.items){
            total += cart.items[id].quantity
        }
        return total
    }),
    totalPrice:computed(()=>{
        let total = 0
        for(let id in cart.items){
            total += cart.items[id].product.reduced_price * cart.items[id].quantity
        }
        return parseFloat(total.toFixed(2))
    }),
    grandTotal:computed(()=>{
        return cart.totalPrice + cart.shippingCost*1
    }),
    addItem(product, quantity=1){
        console.log(product.variants)
        if(product.variant_id == null || product.variant_id == undefined || product.variant_id == ''){
            router.push('/product/'+product.slug)
            return
        }
        if(product.quantity >= quantity){
            if(this.items[product.variant_id]){
                this.items[product.variant_id].quantity++
            }else{
                this.items[product.variant_id] = {
                    product: {
                        'id':product.id,
                        'title':product.title,
                        'sku':product.sku,
                        'slug':product.slug,
                        'price':product.reduced_price !== null ? product.reduced_price : product.price,
                        'reduced_price':product.reduced_price,
                        'product_type':product.product_type,
                        'photo':product.photo,
                        'variant_id':product.variant_id,
                    },
                    quantity: quantity
                }
            }
            toast("Cart added", {
                "theme": "auto",
                "type": "success",
                "autoClose": 1000,
                "dangerouslyHTMLString": true
            })
            this.saveCartInLocalStorage()
        }else{
            toast("Out of stock! Stock:"+ product.quantity, {
                "theme": "auto",
                "type": "error",
                "autoClose": 1000,
                "dangerouslyHTMLString": true
            })
        }
        this.saveCartInLocalStorage()
    },
    increaseQuantity(item){
        //console.log(product)
        this.items[item.product.variant_id].quantity++
        this.saveCartInLocalStorage()
    },
    decreaseQuantity(item){
        if(this.items[item.product.variant_id].quantity > 1){
            this.items[item.product.variant_id].quantity--
            this.saveCartInLocalStorage()
        }
    },
    removeItem(product){
        delete this.items[product.variant_id]
        toast("Cart removed", {
            "theme": "auto",
            "type": "info",
            "autoClose": 1000,
            "dangerouslyHTMLString": true
          })
        this.saveCartInLocalStorage()
    },
    emptyCart(){
        this.items = {}
        this.saveCartInLocalStorage()
    },
    saveCartInLocalStorage(){
        localStorage.setItem('cart', JSON.stringify(this.items))
        localStorage.setItem('shippingCost', this.shippingCost)
    },
    getCartFromLocalStorage(){
        this.items = JSON.parse(localStorage.getItem('cart')) || {}
        this.shippingCost = localStorage.getItem('shippingCost')
    },
    checkout(){
        router.push('/checkout')
    },
    async placeOrder(name, phone, address, shipping_method){
        const products = Object.values(this.items).map(item => ({
            product_id: item.product.id,
            quantity: item.quantity,
            price: item.product.price,
            variant_id: item.product.variant_id
        }));
        try {
            const response = await fetch(`${basic.serverUrl}/api/placeOrderNonAuth`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, phone, address, shipping_method, products, shippingCost:this.shippingCost, totalPrice: this.totalPrice })
            })
            const data = await response.json()
            //console.log(response)
            if(data.success===true){
                this.errorMessage = {}
                this.emptyCart()
                // $(function () {
                //     $('#checkoutModal').modal('show')
                // });
                toast("অর্ডার সফল হয়েছে", {
                    "theme": "auto",
                    "type": "info",
                    "autoClose": 2000,
                    "dangerouslyHTMLString": true
                })
            }else{
                //console.log(data)
                this.errorMessage = data.data
            }
        } catch (error) {
            console.error('Error placing order:', error);
        }
        
    },
    shippingMethod(shipping_method){
        if(shipping_method == 'ঢাকার বাহিরে'){
            this.shippingCost = basic.settings.shipping_outside__dhaka
        }else if(shipping_method == 'ঢাকার ভিতরে'){
            this.shippingCost = basic.settings.shipping_inside_dhaka
        }else{
            this.shippingCost = 0
        }
        //console.log(this.shippingCost)
        this.saveCartInLocalStorage()
    }
})
cart.getCartFromLocalStorage()
export {cart}