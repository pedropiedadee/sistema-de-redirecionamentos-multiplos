import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import redirect from '../views/Redirects.vue'
import Links from '../views/Links.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/redirects',
    name: 'redirects',
    component: redirect
  },
  {
    path: '/redirect/:id',
    name: 'redirect-links',
    component: Links
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
