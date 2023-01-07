<template>
  <div class="user-page">
    <div class="navbar">
      <h4>Halaman User</h4>
      <button id="btn-logout" @click="logout">Logout</button>
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
            </tr>

            <tr v-for="(post, index) in posts[page]" :key="index">
              <td>{{ post.nama }}</td>
              <td>{{ post.alamat }}</td>
              <td>{{ post.kota }}</td>
              <td>{{ post.provinsi }}</td>
              <td>{{ post.email }}</td>
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
  name: "UserView",
  components: {
    paginate: Paginate,
  },
  setup() {},
  data() {
    return {
      posts: null,
      error: null,
      i: 0,
      page: 0,
      pageRange: 8,
      pageCount: 0,
    };
  },
  methods: {
    clickCallback(pageNum) {
      this.page = pageNum;
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
</style>
