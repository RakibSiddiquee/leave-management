
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

Vue.mixin({
    methods: {
        fFormatDate(dt){
            let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            let d = new Date(dt),
                month = '' + d.getMonth(),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (day.length < 2) day = '0' + day;

            return [day, months[month], year].join(' ');
        }
    }

});



Vue.component('designation', require('./components/admin/DesignationListComponent.vue').default);
Vue.component('department', require('./components/admin/DepartmentListComponent.vue').default);
Vue.component('admin', require('./components/admin/AdminListComponent.vue').default);
Vue.component('employee', require('./components/admin/EmployeeListComponent.vue').default);
Vue.component('leave-type', require('./components/admin/LeaveTypeListComponent.vue').default);
Vue.component('employee-leave', require('./components/EmployeeLeaveListComponent.vue').default);
Vue.component('leave-list', require('./components/Admin/LeaveListComponent.vue').default);
Vue.component('leave-report', require('./components/Admin/LeaveReportComponent.vue').default);


const app = new Vue({
    el: '#app',
});
