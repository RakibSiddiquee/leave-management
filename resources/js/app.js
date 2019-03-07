
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('designation', require('./components/admin/DesignationListComponent.vue').default);
Vue.component('department', require('./components/admin/DepartmentListComponent.vue').default);
Vue.component('admin', require('./components/admin/AdminListComponent.vue').default);
Vue.component('employee', require('./components/admin/EmployeeListComponent.vue').default);


const app = new Vue({
    el: '#app'
});
