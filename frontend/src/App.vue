<!-- <template>
  <div id="app">
    <div id="nav">
      <router-link v-if="!authenticated" :to="{ name: 'login' }"> Login  </router-link>
      <router-link v-if="!authenticated" :to="{ name: 'register' }"> Register  </router-link>
      <router-link v-if="authenticated" :to="{ name: 'UserPost' }">Posts </router-link>
      <button v-if="authenticated" @click="logout">logout</button>
    </div>
    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: red">{{ error }}</p>
    <router-view />
  </div>
</template> -->
<template>
  <div id="app">
    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: red">{{ error }}</p>
    <router-view></router-view>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "App",
  data() {
    return {
      loading: false,
      error: false,
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
    }),
  },
  methods: {
    async logout() {
      this.loading = true;

      try {
        await this.$store.dispatch("logout");
        await this.$router.push({ name: "login" });
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
* {
  font-family: Outfit, Helvetica, Arial, sans-serif;
  margin: 0;
  padding: 0;
}
body {
  background-color: #0d0d0d;
  /* remove padding and other styles from the body element */
}
#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

#nav {
  height: 7vw;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
  background-color: #ffff;
}

#nav div {
  display: inline-block;
}

.link-logout:hover {
  cursor: pointer;
  text-decoration: underline;
}
.pagination {
  padding-left: 0;
  font-weight: bold;
  display: inline-flex;
  list-style: none;
  background-color: #ffff;
  border-radius: 1.5rem;
  border: 1px solid #aaaaaa;
  overflow: hidden;
}
.pagination li {
  border-right: 1px solid #aaaaaa;
}
.pagination li:last-child {
  border-right: none;
}
.pagination li:hover {
  background-color: #c0c0c0;
}
.pagination li.active {
  background-color: #66addb;
}

.pagination li a {
  padding: 0.5rem 1rem;
  cursor: pointer;
  text-decoration: none;
  display: block;
}
button {
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 10px 20px;
  border-radius: 4px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
button:hover {
  background-color: #3e8e41;
}

#nav {
  background-color: #327a81;
  overflow: hidden;
}

#nav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 3vw 4vw 3vw 4vw;
  text-decoration: none;
}

#nav li a:hover {
  background-color: #111;
}

#nav li a.active {
  background-color: #4caf50;
}

#nav button {
  float: right;
  height: 100%;
  border-radius: 0;
  background-color: rgb(194, 66, 66);
  margin: 0;
  font-size: medium;
  font-weight: bolder;
}

#nav button:hover {
  background-color: rgb(150, 58, 58);
}
td button {
  padding: 0.4rem 0.6rem;
  font-size: small;
}
td button:last-child {
  background-color: #f73f3f;
}
</style>
