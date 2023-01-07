<template>
  <div class="admin-page">
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="showModal = false">&times;</span>
        <h3>Edit User</h3>
        <form @submit.prevent="updateUser">
          <label>Nama</label>
          <input type="text" placeholder="Nama" v-model="user.nama" /><br />
          <label>Alamat</label>
          <input type="text" placeholder="Alamat" v-model="user.alamat" /><br />
          <label>Kota</label>
          <input type="text" placeholder="Kota" v-model="user.kota" /><br />
          <label>Provinsi</label>
          <input type="text" placeholder="Provinsi" v-model="user.provinsi" /><br />
          <label>Email</label>
          <input type="text" placeholder="Email" v-model="user.email" /><br />
          <button @click="SureorNot(updateUser, [user.id], 'apa kamu yakin ingin mengubah user ini?')">Update</button>
        </form>
      </div>
    </div>
    <div v-if="showModall" class="modal">
      <div class="modal-content">
        <span class="close" @click="showModall = false">&times;</span>
        <h3>{{ question }}</h3>
        <div class="question-btn">
          <button @click="showModall = false" id="btn-no">No</button>
          <button @click="fun.apply(this, arg)" id="btn-yes">Yes</button>
        </div>
      </div>
    </div>
    <div class="navbar">
      <h4>Halaman Admin</h4>
      <div>
        <router-link :to="{ name: 'TambahView' }" id="btn-tambah">Tambah Siswa</router-link>
        <button id="btn-logout" @click="logout">Logout</button>
      </div>
    </div>
    <div class="main">
      <p v-if="error" style="color: red">{{ error }}</p>
      <div v-if="posts" class="posts-wrapper">
        <div class="table-users">
          <table cellspacing="0">
            <tr>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Kota</th>
              <th>Provinsi</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>

            <tr v-for="(post, index) in posts[page]" :key="index">
              <td>{{ post.nama }}</td>
              <td>{{ post.alamat }}</td>
              <td>{{ post.kota }}</td>
              <td>{{ post.provinsi }}</td>
              <td>{{ post.email }}</td>
              <td>
                <button @click="editUser(post.id)">Edit</button>
                <button @click="SureorNot(deleteUser, [post.id], 'apa kamu yakin ingin menghapus user ini?')">Delete</button>
              </td>
            </tr>
          </table>
        </div>
        <paginate v-model="page" :page-count="this.pageCount" :page-range="this.pageRange" :margin-pages="2" :click-handler="clickCallback" :prev-text="'Prev'" :next-text="'Next'" :container-class="'pagination'" :page-class="'page-item'">
        </paginate>
      </div>
      <p v-else>loading...</p>
    </div>
  </div>
</template>

<script>
import repository from "@/api/repository";
import Paginate from "vuejs-paginate-next";

export default {
  name: "AdminView",
  components: {
    paginate: Paginate,
  },
  setup() {},
  data() {
    return {
      posts: null,
      error: null,
      showModal: false,
      user: {
        id: null,
        nama: null,
        alamat: null,
        kota: null,
        provinsi: null,
        email: null,
      },
      showModall: false,
      fun: null,
      arg: null,
      i: 0,
      page: 0,
      pageRange: 5,
      pageCount: 0,
    };
  },
  methods: {
    clickCallback(pageNum) {
      this.page = pageNum;
    },
    async editUser(id) {
      await repository.getPost(id).then((response) => {
        this.user = response.data[0];
        this.showModal = true;
      });
    },
    async updateUser(id) {
      await repository.setUpdate(id, this.user).then(async () => {
        this.showModall = false;
        await repository.getPosts().then((response) => {
          const originalArr = response.data;
          const splittedArray = [""];
          while (originalArr.length > 0) {
            splittedArray.push(originalArr.splice(0, this.pageRange));
          }
          this.pageCount = splittedArray.length - 1;
          this.posts = splittedArray;
        });
      });
    },
    async deleteUser(id) {
      await repository.setDelete(id).then(async () => {
        this.showModall = false;
        await repository.getPosts().then((response) => {
          const originalArr = response.data;
          const splittedArray = [""];
          while (originalArr.length > 0) {
            splittedArray.push(originalArr.splice(0, this.pageRange));
          }
          this.pageCount = splittedArray.length - 1;
          this.posts = splittedArray;
        });
      });
    },
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
    SureorNot(callback, args, question) {
      this.showModal = false;
      this.showModall = true;
      this.fun = callback;
      this.arg = args;
      this.question = question;
    },
  },

  async mounted() {
    try {
      let { data } = await repository.getPosts();
      const originalArr = data;
      const splittedArray = [""];
      while (originalArr.length > 0) {
        splittedArray.push(originalArr.splice(0, this.pageRange));
      }
      this.pageCount = splittedArray.length - 1;
      this.page = 1;
      this.posts = splittedArray;
    } catch (error) {
      this.error = error;
    }
  },
};
</script>

<style>
.question-btn {
  margin-top: 36px;
  display: flex;
}

#btn-no {
  background-color: red;
  width: 100%;
}

#btn-yes {
  width: 100%;
}

#btn-tambah {
  background-color: green;
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
  margin-right: 20px;
}

.navbar {
  padding: 0 16px;
  color: white;
  font-size: 24px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

#btn-logout {
  background-color: red;
  width: 100px;
  font-size: 20px;
  font-weight: 600px;
}
.table-users {
  border: 1px solid white;
  border-radius: 10px;
  box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
  max-width: calc(100% - 2em);
  margin: 1em auto;
  overflow: hidden;
  width: 800px;
}
table {
  width: 100%;
}
table td,
table th {
  color: white;
  padding: 10px;
}
table td {
  text-align: left;
  vertical-align: middle;
}
table th {
  background-color: #1c1c1c;
  font-weight: 300;
  text-align: center;
}

.modal {
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 999;
}
.modal .modal-content {
  background-color: #1c1c1c;
  border-radius: 10px;
  padding: 40px 24px;
  width: 400px;
  position: relative;
  text-align: left;
  color: white;
  box-sizing: border-box;
}
.modal .modal-content h3 {
  color: white;
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 0 1rem 0;
  text-align: center;
  text-transform: uppercase;
  margin-bottom: 24px;
}
.modal .modal-content form {
  display: flex;
  flex-direction: column;
}
.modal .modal-content form label {
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}
.modal .modal-content form input {
  border: 1px solid #327a81;
  border-radius: 5px;
  font-size: 1rem;
  margin: 0;
  padding: 8px 8px;
  margin-bottom: 4px;
  width: 100%;
  box-sizing: border-box;
}

.modal .modal-content form select {
  border: 1px solid #327a81;
  border-radius: 5px;
  font-size: 1rem;
  margin-bottom: 1rem;
  padding: 0.5rem;
}

.modal .modal-content form button {
  background-color: #005a8d;
  width: 100%;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  padding: 12px 0;
  text-transform: uppercase;
  box-sizing: border-box;
  margin-top: 24px;
}
.modal .modal-content form button[type="submit"] {
  background-color: #327a81;
}
.modal .modal-content form button[type="button"] {
  background-color: #c8e7ea;
}
.modal .modal-content form button[type="button"]:hover {
  background-color: #91ced4;
}
.modal .modal-content form button[type="button"]:active {
  background-color: #6cbec6;
}
.modal .modal-content form button[type="button"]:focus {
  outline: none;
}
.modal .modal-content form button[type="submit"]:hover {
  background-color: #6cbec6;
}
.modal .modal-content form button[type="submit"]:active {
  background-color: #327a81;
}
.modal .modal-content form button[type="submit"]:focus {
  outline: none;
}
.modal .modal-content form input:focus {
  outline: none;
}

.modal .modal-content form input[type="submit"] {
  background-color: #327a81;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 700;
  margin: 0 0.5rem;
  padding: 0.5rem 1rem;
  text-transform: uppercase;
}
.modal .modal-content form input[type="submit"]:hover {
  background-color: #6cbec6;
}
.modal .modal-content form input[type="submit"]:active {
  background-color: #327a81;
}
.modal .modal-content form input[type="submit"]:focus {
  outline: none;
}
.modal-content span {
  position: absolute;
  right: 20px;
  top: 10px;
  cursor: pointer;
  font-size: xx-large;
}
</style>
