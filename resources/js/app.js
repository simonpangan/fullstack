

require('./bootstrap');

window.Vue = require('vue').default;

import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
import VueRouter from 'vue-router';

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);



//global  // means can access in any url
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

//not found

Vue.component(
  'not-found', 
  require('./components/NotFound.vue').default);


//pagination 

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueRouter);


let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
    
  ];

Vue.filter('upText',(text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate',(created) => {
  return moment(created).format('MMMM Do YYYY, h:mm:ss a');
});

const router = new VueRouter({
  mode:'history', 
  // to remove /home in the route  just the /dashboard or / profile instead of /home/profile
  routes 
});

import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
});


//sweat alert

import swal from 'sweetalert2';
window.swal = swal; 

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});

window.toast = toast;


window.Fire = new Vue(); //windows means globaL  



// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    data: {
      search: ''
    },
    methods: {
      searchit: _.debounce(() => {
        Fire.$emit('searching');
      },1000),
      printme() {
        window.print();
      }
    }
});



