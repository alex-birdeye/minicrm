/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
//
// import Vue from 'vue'
// import VueRouter from 'vue-router'
//
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default-dark.css'

Vue.use(VueMaterial)
//
// Vue.use(VueRouter)
//
// import App from './views/App'
// import Hello from './views/Hello'
// import Home from './views/Home'
// import Login from './views/Login'
//
// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/',
//             name: 'home',
//             component: Home
//         },
//         {
//             path: '/hello',
//             name: 'hello',
//             component: Hello,
//         },
//         {
//             path: '/login',
//             name: 'login',
//             component: Login,
//         },
//     ],
// });


import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import auth from './auth'

import App from './views/App'
import Hello from './views/Hello'
import Home from './views/Home'
import Login from './views/Login'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
            meta: {
                auth: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});

// Set Vue globally
window.Vue = Vue
// Set Vue router
Vue.router = router
Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)
// axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
axios.defaults.baseURL = `/api`
Vue.use(VueAuth, auth)


const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
