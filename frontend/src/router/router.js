import { createRouter, createWebHistory } from 'vue-router';

//import Login from '../components/Login.vue';
//import Register from '../components/Register.vue';/
import Home from '../components/Home.vue';
import ProductSingle from "../components/ProductSingle.vue";

const routes = [
    {
        path: '/', component: Home, 'name': 'home'
    },
    {
        path: '/product/:slug', component: ProductSingle, 'name': 'product-single'
    },
    /*
    {
        path: '/dashboard', component: Dashboard, 'name': 'dashboard',meta: {
            requiresAuth: true
        }
    },
    {
        path: '/todo', component: Todo, 'name': 'todo'
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
