<template>
  <div class="form-auth">
    <h1>Register</h1>
    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: red">{{ error }}</p>
    <input id="input" type="text" placeholder="Nama" v-model="user.name" /><br />
    <input id="input" type="email" placeholder="Email" v-model="user.email" /><br />
    <input id="input" type="password" placeholder="Password" v-model="user.password" /> <br />
    <button id="btn-main" @click="register">Register</button>
    <p>Sudah punya akun? <router-link :to="{ name: 'login' }" id="link"> Login </router-link></p>
  </div>
</template>

<script>
import repository from "@/api/repository";
export default {
  name: "RegisterView",

  data() {
    return {
      user: {
        email: null,
        password: null,
        name: null,
      },
      loading: false,
      error: null,
    };
  },

  methods: {
    async register() {
      this.error = null;

      try {
        await repository.register(this.user).then(async () => {
          await this.$store.dispatch("login", this.user);
        });
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
