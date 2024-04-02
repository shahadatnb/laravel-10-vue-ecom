import {reactive, computed} from 'vue'
import { basicStore } from './basic'
const basic = basicStore
import router from '../router/router'
const cart = reactive({
    items:{},
    errorMessage: {},
    shippingCost:0,
    totalCartItems:computed(()=>{
        let total = 0
        for(let item in cart.items){
            total += cart.items[item].quantity
        }
        return total
    }),
    totalPrice:computed(()=>{
        let total = 0
        for(let item in cart.items){
            total += (cart.items[item].product.reduced_price??cart.items[item].product.price) * cart.items[item].quantity
        }
        return parseFloat(total.toFixed(2))
    }),
    grandTotal:computed(()=>{
        return cart.totalPrice + cart.shippingCost*1
    }),
    addItem(product, quantity=1){
        if(this.items[product.variant_id]){
            this.items[product.variant_id].quantity++
        }else{
            this.items[product.variant_id] = {
                product,
                quantity: quantity
            }
        }
        this.saveCartInLocalStorage()
    },
    increaseQuantity(item){
        //console.log(product)
        this.items[item.product.variant_id].quantity++
        this.saveCartInLocalStorage()
    },
    decreaseQuantity(item){
        this.items[item.product.variant_id].quantity--
        this.saveCartInLocalStorage()
    },
    removeItem(product){
        delete this.items[product.variant_id]
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

})
cart.getCartFromLocalStorage()
export {cart}