import { createRouter, createWebHistory } from 'vue-router';
import { nextTick } from 'vue'
//import Login from '../components/Login.vue';
//import Register from '../components/Register.vue';/
import Home from '../components/Home.vue';
import ProductSingle from "../components/ProductSingle.vue";
import Category from "../components/Category.vue";
import Contact from "../components/Contact.vue";
import Cart from "../components/Cart.vue";
import Checkout from "../components/Checkout.vue";
import Page from "../components/Page.vue";
import OrderSuccess from "../components/OrderSuccess.vue";

const routes = [
    {
        path: '/', component: Home, name: 'home'
    },
    {
        path: '/product/:slug', component: ProductSingle, name: 'product-single', meta: { title: 'Product' }
    },
    {
        path: '/category/:slug', component: Category, name: 'category-product', meta: { title: 'Category' }
    },
    {
        path: '/page/:slug', component: Page, name: 'page', meta: { title: 'Page' }
    },
    {
        path: '/contact', component: Contact, name: 'contact', meta: { title: 'Contact' }
    },
    {
        path: '/cart', component: Cart, name: 'cart', meta: {
            title: 'Cart'
        }
    },
    {
        path: '/checkout', component: Checkout, name: 'checkout', meta: {
            title: 'Checkout'
        }
    },
    {
        path: '/order_success', component: OrderSuccess, name: 'order_success', meta: {
            title: 'Order Success'
        }
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
    routes,
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        //return { top: 0 }
        window.scrollTo({
            top: 0,
            behavior: "smooth"
          });
      }
});

const DEFAULT_TITLE = 'a2zcse - Online Book Store';
router.afterEach((to, from) => {
    nextTick(() => {
        document.title = to.meta.title || DEFAULT_TITLE;
    });
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
