<template>
  <div>
    <b-form class="login-box" @submit.prevent="handleRegister">
      <h1 class="text-center">Register</h1>

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

      <b-form-group label="Password again" label-for="password_again">
        <b-form-input
          id="password_again"
          v-model="form.password_again"
          type="password"
          placeholder="Password again"
          :state="errors.password_again ? false : null"
        ></b-form-input>
        
        <b-form-invalid-feedback :state="!errors.password_again">
          {{ errors.password_again }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="E-mail address" label-for="email">
        <b-form-input
          id="email"
          v-model="form.email"
          type="text"
          placeholder="E-mail address"
          :state="errors.email ? false : null"
        ></b-form-input>
        
        <b-form-invalid-feedback :state="!errors.email">
          {{ errors.email }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-button variant="primary" type="submit">Register</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data(){
    return {
      form: {
        username: "",
        email: "",
        password: "",
        password_again: "",
      },
      errors: {},
    }
  },
  methods: {
    handleRegister(){
      this.errors = {};

      this.$store.dispatch('register', this.form)
        .then(() => this.$router.push('/login'))
        .catch(() => {
            this.errors = this.$store.getters.registerErrors;
        });
    }
  },
  watch: {
    username: function(){
      this.errors = {};
    },
    email: function(){
      this.errors = {};
    },
    password: function(){
      this.errors = {};
    },
    password_again: function(){
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