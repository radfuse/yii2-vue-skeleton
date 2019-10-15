import Vue from 'vue'
import Vuex from 'vuex'

import ApiService from './services/api.service';
import TokenService from './services/token.service';
import UserService from './services/user.service';

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		token: TokenService.getToken(),
    user : UserService.getUser(),
    loginErrors: {},
    registerErrors: {},
	},
	mutations: {
    login_success(state, { token, user }){
      state.loginErrors = {};
      state.token = token;
      state.user = user;
    },
    login_error(state, errors){
      state.loginErrors = errors;
    },
    register_success(state){
      state.registerErrors = {};
    },
    register_error(state, errors){
      state.registerErrors = errors;
    },
    logout(state){
      state.loginErrors = {};
      state.user = {};
      state.token = '';
    },
	},
	actions: {
		login({commit}, user){
			return new Promise((resolve, reject) => {
        ApiService.post('site/login', user)
          .then(res => {
            const token = res.data.access_token
            const user = res.data.user

            TokenService.setToken(token);
            UserService.setUser(user);
            ApiService.setHeader();

            commit('login_success', { token, user });
            resolve(res);
          })
          .catch(err => {
            TokenService.removeToken();
            UserService.removeUser();
            ApiService.removeHeader();

            let errors = {};

            if(err.response && err.response.data){
              err.response.data.forEach((item) => {
                  errors[item.field] = item.message;
              });
            }

            commit('login_error', errors);
            reject(err);
          });
			});
    },
		register({commit}, user){
			return new Promise((resolve, reject) => {
        ApiService.post('site/register', user)
          .then(res => {
            commit('register_success');

            resolve(res);
          })
          .catch(err => {
            let errors = {};

            if(err.response && err.response.data){
              err.response.data.forEach((item) => {
                  errors[item.field] = item.message;
              });
            }

            commit('register_error', errors);
            reject(err);
          });
			});
    },
    logout({commit}){
      return new Promise((resolve) => {
        TokenService.removeToken();
        UserService.removeUser();
        ApiService.removeHeader();

        commit('logout');
        resolve();
      })
    }
	},
	getters : {
    isLoggedIn: state => !!state.token,
    username: state => state.user ? state.user.username : null,
    loginErrors: state => state.loginErrors,
    registerErrors: state => state.registerErrors,
	}
})