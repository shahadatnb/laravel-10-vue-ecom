import { reactive } from 'vue'
import router from '../router/router'
import { authStore } from './authStore'
import { basicStore } from './basic'
import { toast } from 'vue3-toastify';
import { cart } from './cart'
const basic = basicStore
// const showPopup = ref(false);
const order = reactive({
    orders: [],
    shipping_amount: 0,
    loading:false,
    showPopup: false,
    orderId: 0,
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
            title: item.product.title,
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
            zip_code: postalCode,
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
                this.dataLayerPurchaseEvent(data.order,products)
                cart.emptyCart()
                this.loading = false
                // toast("Order placed successfully", {
                //     "theme": "auto",
                //     "type": "success",
                //     "autoClose": 1000,
                //     "dangerouslyHTMLString": true
                // })
                //router.push('/dashboard/orders')
                this.orderId = data.order.id

                this.showPopup = true
            }else{
                this.loading = false                
                this.errorMessage = data.data
                if(data.data.products){
                    toast(data.data.products[0], {
                        "theme": "auto",
                        "type": "error",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                }
            }
            
        } catch (error) {
            console.error('Error placing order:', error);
        }
    },
    viewOrderDetails(){ 
        this.showPopup = false;
        router.push('/dashboard/order/'+this.orderId)
    },
    dataLayerPurchaseEvent(order,products){
        dataLayer.push({
            event: "purchase",
            ecommerce: {
                transaction_id: order.id,
                value: order.sub_total,
                tax: 0,
                shipping: order.shipping_amount,
                currency: "BDT",
                items: products.map(product => ({
                    item_name: product.title,
                    item_id: product.product_id,
                    price: product.price,
                    quantity: product.quantity
                }))
            }
        });
        //console.log(dataLayer)
    }
    
})

export { order }