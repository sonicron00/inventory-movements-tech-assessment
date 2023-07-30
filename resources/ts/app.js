import Vuetify from "vuetify";

require('./bootstrap');

import App from './components/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import store from "./store/index.ts"
import {routes} from './routes';
import vuetify from './vuetify';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'



import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

Vue.use(Vuetify);
import 'vuetify/dist/vuetify.min.css'
import Vue from "vue";

const app = new Vue({
    el: '#app',
    vuetify,
    router: router,
    store,
    render: h => h(App),
});