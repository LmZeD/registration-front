require('./bootstrap');

window.Vue = require('vue');
import router from './router/router'
import components from './components/index'

Vue.prototype.$apiUrl = 'http://127.0.0.1:8000/api/';

const app = new Vue({
    el: '#app',
    data() {
        return {
        }
    },
    router,
});

