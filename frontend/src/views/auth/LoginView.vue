<template>
  <div class="form-auth">
    <h1>Login</h1>

    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: red">{{ error }}</p>

    <input id="input-login" type="text" placeholder="Email" v-model="user.email" />
    <input id="input-login" type="password" placeholder="Password" v-model="user.password" />

    <button id="btn-main" @click="login">Login</button>

    <p>Belum punya akun? <router-link :to="{ name: 'register' }" id="link"> Register Sekarang! </router-link></p>
  </div>
</template>

<script>
export default {
  name: "LoginView",

  data() {
    return {
      user: {
        email: null,
        password: null,
      },
      loading: false,
      error: null,
    };
  },

  methods: {
    async login() {
      this.error = null;

      try {
        await this.$store.dispatch("login", this.user);
        await this.$router.push({ name: "UserPost" });
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style>
/* style the input and login button */
.form-auth {
  width: 360px;
  padding: 40px 36px;
  color: white;
  background-color: #1c1c1c;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

h1 {
  margin-bottom: 36px;
}

#input {
  width: 100%;
  padding: 8px 8px;
  border-radius: 4px;
  box-sizing: border-box;
  margin: 4px 0;
}

#input-login {
  width: 100%;
  padding: 8px 8px;
  border-radius: 4px;
  box-sizing: border-box;
  margin: 12px 0;
}

#input:focus {
  border: 1px solid white;
}
#btn-main {
  background-color: #005a8d;
  width: 100%;
  border: none;
  color: white;
  padding: 10px 20px;
  border-radius: 4px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  margin: 40px 0;
  font-size: 20px;
  font-weight: 600;
}

#link {
  font-weight: 600;
  text-decoration: none;
  color: #005a8d;
}
</style>
