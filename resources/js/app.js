
require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import {routes} from "./routes";
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;

import Notification from './Helpers/Notification';
window.Notification = Notification;

const router = new VueRouter({
    routes,
    mode:'history'
})

import User from "./Helpers/User";
window.User = User;

window.Reload = new Vue();
// window.location.reload = new Vue();
//location.reload = new Vue();
//loca.reload = new Vue();

const app = new Vue({
    el: '#app',
    router
});
