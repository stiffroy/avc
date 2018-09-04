/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vue2Filters from 'vue2-filters';
import store from './store';
/**
 * Importing the Vue2 Admin LTE
 */
import 'vue2-admin-lte/src/lib/css';
import 'vue2-admin-lte/src/lib/script';
import Home from './components/Home';
import Login from './components/auth/Login';
import Logout from './components/auth/Logout';
import Users from './components/users/UsersOverview';
import UsersList from './components/users/UsersList';
import UserCreate from './components/users/UsersCreate';
import UserShow from './components/users/UsersShow';
import UserEdit from './components/users/UsersEdit';
import Groups from './components/groups/GroupsOverview';
import GroupsList from './components/groups/GroupsList';
import GroupCreate from './components/groups/GroupsCreate';
import GroupShow from './components/groups/GroupsShow';
import GroupEdit from './components/groups/GroupsEdit';
import Clients from './components/clients/ClientsOverview';
import ClientsList from './components/clients/ClientsList';
import ClientCreate from './components/clients/ClientsCreate';
import ClientShow from './components/clients/ClientsShow';
import ClientEdit from './components/clients/ClientsEdit';
import ClientNotified from './components/clients/ClientsNotified';

window.Vue.use(VueRouter);
window.Vue.use(Vue2Filters);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('side-menu', require('./components/includes/SideMenu'));
Vue.component('main-header', require('./components/includes/MainHeader'));

const routes = [
    {path: '/', component: Home, name: 'home', meta: { requiresAuth: true }},
    {path: '/login', component: Login, name: 'login'},
    {path: '/logout', component: Logout, name: 'logout'},
    {path: '/users', component: Users, name: 'users', meta: { requiresAuth: true }},
    {path: '/users/list', component: UsersList, name: 'listUsers', meta: { requiresAuth: true }},
    {path: '/users/create', component: UserCreate, name: 'createUser', meta: { requiresAuth: true }},
    {path: '/users/show/:id', component: UserShow, name: 'showUser', meta: { requiresAuth: true }},
    {path: '/users/edit/:id', component: UserEdit, name: 'editUser', meta: { requiresAuth: true }},
    {path: '/groups', component: Groups, name: 'groups', meta: { requiresAuth: true }},
    {path: '/groups/list', component: GroupsList, name: 'listGroups', meta: { requiresAuth: true }},
    {path: '/groups/create', component: GroupCreate, name: 'createGroup', meta: { requiresAuth: true }},
    {path: '/groups/show/:id', component: GroupShow, name: 'showGroup', meta: { requiresAuth: true }},
    {path: '/groups/edit/:id', component: GroupEdit, name: 'editGroup', meta: { requiresAuth: true }},
    {path: '/clients', component: Clients, name: 'clients', meta: { requiresAuth: true }},
    {path: '/clients/list', component: ClientsList, name: 'listClients', meta: { requiresAuth: true }},
    {path: '/clients/create', component: ClientCreate, name: 'createClient', meta: { requiresAuth: true }},
    {path: '/clients/show/:id', component: ClientShow, name: 'showClient', meta: { requiresAuth: true }},
    {path: '/clients/edit/:id', component: ClientEdit, name: 'editClient', meta: { requiresAuth: true }},
    {path: '/clients/notified/:id', component: ClientNotified, name: 'notifiedClient', meta: { requiresAuth: true }},
];

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {
    // Forward to home when an undefined route is given
    if (!to.name) {
        next({ name: 'home' });
    }

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login', query: {goto: to.name} });
        return;
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: url });
        return;
    }

    next()
});

const app = new Vue({ router, store }).$mount('#app');
