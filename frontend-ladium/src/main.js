import { createApp } from 'vue'
import router from './router/router.js'
import './style.css'
import App from './App.vue'

import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faHeart, faShoppingCart, faBars, faMagnifyingGlass, faHouse, faChevronRight, faGripVertical, faList, faUser, faStar, faXmark, faTrash, faFilter } from '@fortawesome/free-solid-svg-icons'
import { faFacebook, faInstagram, faXTwitter, faWhatsapp } from '@fortawesome/free-brands-svg-icons'
import { faHeart as farHeart, faStar as farStar, faStarHalfStroke } from '@fortawesome/free-regular-svg-icons'

/* add icons to the library */
library.add(faHeart,farHeart, faShoppingCart, faBars, faMagnifyingGlass, faHouse, faChevronRight, faGripVertical, faList, faUser,faStar,farStar,faStarHalfStroke,faFacebook,faInstagram,faXTwitter,faWhatsapp,faXmark,faTrash,faFilter)


createApp(App)
    .use(Vue3Toasity)
    .use(router)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app')
