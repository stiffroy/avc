import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('token'),
        authUser: JSON.parse(localStorage.getItem('user'))
    },
    mutations: {
        loginUser (state) {
            state.isLoggedIn = !!localStorage.getItem('token');
            state.authUser = JSON.parse(localStorage.getItem('user'));
        },
        logoutUser (state) {
            state.isLoggedIn = false;
            state.user = null
        },
    }
})