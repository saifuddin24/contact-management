import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/group',
        name: 'Group',
        component: function () {
            return import(  '../views/Group.vue')
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: function () {
            return import(  '../views/Login.vue')
        }
    },
    {
        path: '/add-contact',
        name: 'AddContact',
        component: function () {
            return import(  '../views/AddContact.vue')
        }
    }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
