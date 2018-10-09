import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const Login = {template: '<login-component></login-component>'};
const Home = {template: '<home></home>'};
const Register = {template: '<register-component></register-component>'};
const CreateAppointment = {template: '<create-appointment></create-appointment>'};
const UpdateAppointment = {template: '<update-appointment></update-appointment>'};


const routes = [
    {path: '/', component: Home, name: 'home'},
    {path: '/login', component: Login, name: 'login'},
    {path: '/register', component: Register, name: 'register'},
    {path: '/create-appointment', component: CreateAppointment, name: 'create-appointment'},
    {path: '/update-appointment/:id', component: UpdateAppointment, name: 'update-appointment'},
];

const router = new VueRouter({
    routes
});

const authRoutes = ['login', 'register'];

router.beforeEach((to, from, next) => {
    if (authRoutes.includes(to.name) && !localStorage.getItem('token')) {
        next();
    } else if (localStorage.getItem('token') && !authRoutes.includes(to.name)) {
        next();
    } else if (localStorage.getItem('token')){//don't allow auth routes when logged in
        next('/');
    } else {
        next('/login');
    }
});

export default router
