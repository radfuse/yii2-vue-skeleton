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
    login_success(state, { access_token, user }){
      state.loginErrors = {};
      state.token = access_token;
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
    refresh_success(state, { access_token }){
      state.token = access_token;
    }
	},
	actions: {
		login({commit}, user){
			return new Promise((resolve, reject) => {
        ApiService.post('site/login', user)
          .then(res => {
            const access_token = res.data.access_token;
            const refresh_token = res.data.refresh_token;
            const user = res.data.user;

            TokenService.setToken(access_token);
            TokenService.setRefreshToken(refresh_token);
            UserService.setUser(user);
            ApiService.setHeader();
            ApiService.mountTokenRefresh();

            commit('login_success', { access_token, user });
            resolve(res);
          })
          .catch(err => {
            TokenService.removeToken();
            TokenService.removeRefreshToken();
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
        TokenService.removeRefreshToken();
        UserService.removeUser();
        ApiService.removeHeader();
        ApiService.unmountTokenRefresh();

        commit('logout');
        resolve();
      })
    },
		refreshToken({commit}){
			return new Promise((resolve, reject) => {

        ApiService.post('site/refresh-token', {access_token: TokenService.getToken(), refresh_token: TokenService.getRefreshToken()})
          .then(res => {
            const access_token = res.data.access_token;
            const refresh_token = res.data.refresh_token;

            TokenService.setToken(access_token);
            TokenService.setRefreshToken(refresh_token);
            ApiService.setHeader();

            commit('refresh_success', { access_token });
            resolve(res);
          })
          .catch(err => {
            console.log(err);
            reject(err);
          });
			});
    },
	},
	getters : {
    isLoggedIn: state => !!state.token,
    username: state => state.user ? state.user.username : null,
    loginErrors: state => state.loginErrors,
    registerErrors: state => state.registerErrors,
	}
})