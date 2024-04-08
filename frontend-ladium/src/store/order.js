import { reactive } from 'vue'
import router from '../router/router'
import { authStore } from './authStore'
import { basicStore } from './basic'
import { cart } from './cart'
const basic = basicStore
const order = reactive({
    orders: [],
    shipping_amount: 0,
    loading:false,
    errorMessage: {},
    async fetchOrders() {
        const apiUrl = `${basic.serverUrl}/api/orders`
        const token = authStore.getUserToken()

        if (!token) {
            return
        }

        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const ordersData = await response.json();
            this.orders = ordersData.map(order => ({
                id: order.id,
                userId: order.user_id,
                showProducts: false,
                totalAmount: order.total_amount,
                products: order.products.map(productInfo => ({
                    id: productInfo.id,
                    title: productInfo.title,
                    price: productInfo.price,
                    variant_id: productInfo.variant_id,
                    quantity: productInfo.pivot.quantity,
                    totalPrice: productInfo.pivot.price
                }))
            }));
        } catch (error) {
            console.error('Error fetching orders:', error);
        }
    },
    async placeOrder(name, phone, email, address, city, postalCode) {
        this.loading = true
        const apiUrl = `${basic.serverUrl}/api/checkout`
        const token = authStore.getUserToken()
        if (!token) {            
            return
        }

        const products = Object.values(cart.items).map(item => ({
            product_id: item.product.id,
            quantity: item.quantity,
            variant_id: item.product.variant_id,
            price: item.product.reduced_price ?? item.product.price 
        }));

        const payload = {
            name,
            phone,
            email,
            address,
            city,
            postalCode,
            totalPrice: cart.totalPrice,
            shipping_amount: order.shipping_amount,
            products: products
        }

        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            let data = await response.json()
            if(data.success==true){
                this.errorMessage = {}
                cart.emptyCart()
                this.loading = false
                router.push('/dashboard/orders')
            }else{
                this.loading = false
                this.errorMessage = data.data
            }
            
        } catch (error) {
            console.error('Error placing order:', error);
        }
    }
})

export { order }