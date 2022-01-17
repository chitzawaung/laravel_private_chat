

require('./bootstrap');
window.Vue = require('vue');

window.Vue = require('vue').default;
import Vue from 'vue';
import Vuex from 'vuex'
import storeVuex from './store/index.js'
import filter from './filter.js'

Vue.use(Vuex);
const store = new Vuex.Store(storeVuex)

window.moment = require('moment');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('main-app', require('./components/MainApp.vue').default);


const app = new Vue({
    el: '#app',
    store
});
