<template>
  <div id="app">

    <b-navbar toggleable="sm">
      <b-navbar-brand :to="'/'">Vue Yii2</b-navbar-brand>

      <b-navbar-nav class="ml-auto" v-if="isLoggedIn">
        <b-nav-item href="#" @click="logout">Logout ({{username}})</b-nav-item>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto" v-if="!isLoggedIn">
        <b-nav-item  :to="'/login'">Login</b-nav-item>
        <b-nav-item  :to="'/register'">Register</b-nav-item>
      </b-navbar-nav>
    </b-navbar>

    <div class="container-fluid">
      <router-view/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {
  },
  computed : {
    isLoggedIn(){
      return this.$store.getters.isLoggedIn;
    },
    username(){
      return this.$store.getters.username;
    }
  },
  methods: {
    logout(){      
      this.$store.dispatch('logout')
        .then(() => {
          this.$router.push({ name: 'login' });
        });
    }
  },
}
</script>

<style lang="scss">
@import "assets/scss/main.scss";
</style>