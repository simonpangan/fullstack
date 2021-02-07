

require('./bootstrap');

window.Vue = require('vue').default;
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


const router = new VueRouter({
  mode:'history', 
  // to remove /home in the route  just the /dashboard or / profile instead of /home/profile
  routes 
});


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});



