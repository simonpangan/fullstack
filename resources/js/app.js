

require('./bootstrap');

window.Vue = require('vue').default;

import moment from 'moment';
import { Form, HasError, AlertError } from 'vform'
import VueRouter from 'vue-router';

//global  // means can access in any url
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.use(VueRouter);


let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
  ]

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

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});



