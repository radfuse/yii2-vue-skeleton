import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App.vue'
import router from './router'
import store from './store'

import ApiService from './services/api.service';
import TokenService from './services/token.service';

Vue.use(BootstrapVue);
Vue.config.productionTip = false;

ApiService.init(process.env.VUE_APP_API_URL);

if(TokenService.getToken()){
  ApiService.setHeader();
  ApiService.mountTokenRefresh();
}

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')