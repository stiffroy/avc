/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
/**
 * Importing the Vue2 Admin LTE
 */
import 'vue2-admin-lte/src/lib/css';
import 'vue2-admin-lte/src/lib/script';
import Home from './components/Home';
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

window.Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('side-menu', require('./components/SideMenu'));

const routes = [
    {path: '/', component: Home, name: 'home'},
    {path: '/users', component: Users, name: 'users'},
    {path: '/users/list', component: UsersList, name: 'listUsers'},
    {path: '/users/create', component: UserCreate, name: 'createUser'},
    {path: '/users/show/:id', component: UserShow, name: 'showUser'},
    {path: '/users/edit/:id', component: UserEdit, name: 'editUser'},
    {path: '/groups', component: Groups, name: 'groups'},
    {path: '/groups/list', component: GroupsList, name: 'listGroups'},
    {path: '/groups/create', component: GroupCreate, name: 'createGroup'},
    {path: '/groups/show/:id', component: GroupShow, name: 'showGroup'},
    {path: '/groups/edit/:id', component: GroupEdit, name: 'editGroup'},
    {path: '/clients', component: Clients, name: 'clients'},
    {path: '/clients/list', component: ClientsList, name: 'listClients'},
    {path: '/clients/create', component: ClientCreate, name: 'createClient'},
    {path: '/clients/show/:id', component: ClientShow, name: 'showClient'},
    {path: '/clients/edit/:id', component: ClientEdit, name: 'editClient'},
];

const router = new VueRouter({ routes });
const app = new Vue({ router }).$mount('#app');
