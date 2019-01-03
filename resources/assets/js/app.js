
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueSocketio from 'vue-socket.io';
import socketio from 'socket.io-client'

window.Vue = require('vue');
Vue.use(VueSocketio,socketio(':6999'));
import VueRouter from 'vue-router'
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import VueNoty from 'vuejs-noty'
 
Vue.use(VueNoty)
Vue.use(VueRouter)
Vue.use(BootstrapVue);

const home = require('./components/Example.vue');
const perpost = require('./components/showpostComponents.vue');
const news = require('./components/News.vue');
const pernews = require('./components/Pernews.vue');

const routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/perpost/:userId/:post_id',
        name: 'article',
        component: perpost,
        props: true
    },
     {
        path: '/news',
        name: 'news',
        component: news,
        props: true
    },
     {
        path: '/pernews/:news_id',
        name: 'pernews',
        component: pernews,
        props: true
    },
    ];

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter('striphtml', function (value) {
  var div = document.createElement("div");
  div.innerHTML = value;
  var text = div.textContent || div.innerText || "";
  return text;
});
Vue.component('example', require('./components/Example.vue'));
Vue.component('liftside', require('./components/Left.vue'));
Vue.component('rightside', require('./components/Right.vue'));

const router= new VueRouter({
    routes
});
const app = new Vue({
    el: '#app',
    router,
});
