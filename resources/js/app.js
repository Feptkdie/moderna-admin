/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.bootbox = require('bootbox');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('confirm-delete', require('./components/ConfirmDelete.vue').default);
Vue.component('multi-select', require('./components/MultiSelect.vue').default);
Vue.component('location-map', require('./components/LocationMap.vue').default);
Vue.component('info-file-select', require('./components/InfoFileSelect.vue').default);
Vue.component('car-category-add', require('./components/CarCategoryAdd.vue').default);
Vue.component('car-category-filters', require('./components/CarCategoryFilters.vue').default);
Vue.component('car-multiple-upload', require('./components/CarMultipleUpload.vue').default);
Vue.component('company-additions', require('./components/CompanyAdditions.vue').default);
Vue.component('home-sliders', require('./components/HomeSliders.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
