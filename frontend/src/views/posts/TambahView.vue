<template>
  <div class="form-auth">
    <h1>Tambah Siswa</h1>
    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: red">{{ error }}</p>
    <input id="input" type="text" placeholder="Nama" v-model="user.nama" /><br />
    <input id="input" type="text" placeholder="Alamat" v-model="user.alamat" /><br />
    <input id="input" type="email" placeholder="Kota" v-model="user.kota" /><br />
    <input id="input" type="email" placeholder="Provinsi" v-model="user.provinsi" /><br />
    <input id="input" type="email" placeholder="Email" v-model="user.email" /><br />
    <button id="btn-main" @click="store">Tambah</button>
  </div>
</template>

<script>
import repository from "@/api/repository";
export default {
  name: "TambahView",

  data() {
    return {
      user: {
        nama: null,
        alamat: null,
        kota: null,
        provinsi: null,
        email: null,
      },
      loading: false,
      error: null,
    };
  },

  methods: {
    async store() {
      this.error = null;

      try {
        await repository.store(this.user).then(async () => {
          await this.$router.push({ name: "AdminPost" });
        });
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
