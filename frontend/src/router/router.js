import { createRouter, createWebHistory } from 'vue-router';

//import Login from '../components/Login.vue';
//import Register from '../components/Register.vue';/
import Home from '../components/Home.vue';
import ProductSingle from "../components/ProductSingle.vue";
import Category from "../components/Category.vue";
import Contact from "../components/Contact.vue";
import Cart from "../components/Cart.vue";
import Checkout from "../components/Checkout.vue";
import Page from "../components/Page.vue";

const routes = [
    {
        path: '/', component: Home, name: 'home'
    },
    {
        path: '/product/:slug', component: ProductSingle, name: 'product-single'
    },
    {
        path: '/category/:slug', component: Category, name: 'category-product'
    },
    {
        path: '/page/:slug', component: Page, name: 'page'
    },
    {
        path: '/contact', component: Contact, name: 'contact'
    },
    {
        path: '/cart', component: Cart, name: 'cart'
    },
    {
        path: '/checkout', component: Checkout, name: 'checkout'
    },
    /*
    {
        path: '/dashboard', component: Dashboard, 'name': 'dashboard',meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login', component: Login, 'name': 'login'
    },
    {
        path: '/register', component: Register, 'name': 'register'
    }
    */
]

const router = createRouter({
    history: createWebHistory(),
    routes
});
/*
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !autoStore.isAuthenticated) {
        next({ name: 'login' })
    } else {
        next()
    }
})
*/
export default router
