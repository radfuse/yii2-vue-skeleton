<template>
  <div>
    <b-form class="login-box" @submit.prevent="handleLogin">
      <h1 class="text-center">Login</h1>

      <b-form-group label="Username" label-for="username">
        <b-form-input
          id="username"
          v-model="form.username"
          type="text"
          placeholder="Username"
          :state="errors.username ? false : null"
        ></b-form-input>

        <b-form-invalid-feedback :state="!errors.username">
          {{ errors.username }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Password" label-for="password">
        <b-form-input
          id="password"
          v-model="form.password"
          type="password"
          placeholder="Password"
          :state="errors.password ? false : null"
        ></b-form-input>
        
        <b-form-invalid-feedback :state="!errors.password">
          {{ errors.password }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-button variant="primary" type="submit">Login</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data(){
    return {
      form: {
        username : "",
        password : "",
      },
      errors: {},
    }
  },
  methods: {
    handleLogin(){
      this.errors = {};

      this.$store.dispatch('login', this.form)
        .then(() => this.$router.push('/'))
        .catch(() => {
            this.errors = this.$store.getters.loginErrors;
        });
    }
  },
  watch: {
    username: function(){
      this.errors = {};
    },
    password: function(){
      this.errors = {};
    }
  }
}
</script>

<style lang="scss" scoped>
.login-box {
  margin: auto;
  max-width: 500px;
}
</style>