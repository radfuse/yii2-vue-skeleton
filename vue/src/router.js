import Vue from 'vue'
import Router from 'vue-router'
import store from './store.js'

import Index from './pages/Index.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import PageNotFound from './pages/PageNotFound.vue'

Vue.use(Router);

let router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index,
      meta: { requiresAuth: true }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { requiresGuest: true }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { requiresGuest: true }
    },
    { path: "*", component: PageNotFound }
  ]
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = store.getters.isLoggedIn;
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const requiresGuest = to.matched.some((record) => record.meta.requiresGuest);

  if(requiresAuth && !isLoggedIn)
    next({ name: 'login' });

  if(requiresGuest && isLoggedIn)
    next({ name: 'index' });

  next();
});

export default router;