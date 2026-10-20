import { createRouter, createWebHashHistory } from 'vue-router'
import HomePage from '../pages/HomePage.vue'
import CatalogPage from '../pages/CatalogPage.vue'
import ProductPage from '../pages/ProductPage.vue'
import CartPage from '../pages/CartPage.vue'
import CheckoutPage from '../pages/CheckoutPage.vue'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    { path: '/', component: HomePage, meta: { title: 'Home' } },
    { path: '/shop', component: CatalogPage, meta: { title: 'Shop' } },
    { path: '/shop/cotton-overshirt', component: ProductPage, meta: { title: 'Cotton overshirt' } },
    { path: '/bag', component: CartPage, meta: { title: 'Bag preview' } },
    { path: '/checkout', component: CheckoutPage, meta: { title: 'Checkout preview' } },
    { path: '/:pathMatch(.*)*', redirect: '/' },
  ],
  scrollBehavior: (to) => to.hash ? { el: to.hash, top: 32 } : { top: 0 },
})

router.afterEach(() => { document.title = 'Lorem ipsum' })

export default router
