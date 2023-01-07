import api from "./api";

export default {
  createSession() {
    return api.get("http://localhost:8000/sanctum/csrf-cookie");
  },
  login(params) {
    return api.post("http://localhost:8000/api/login", params);
  },
  register(params) {
    return api.post("http://localhost:8000/api/register", params);
  },
  store(params) {
    return api.post("http://localhost:8000/api/siswa/", params);
  },
  logout() {
    return api.delete("http://localhost:8000/api/logout");
  },
  getPosts() {
    return api.get(`http://localhost:8000/api/siswa`);
  },
  getPost(id) {
    return api.get(`http://localhost:8000/api/siswa/` + id);
  },
  setUpdate(id, params) {
    return api.put("http://localhost:8000/api/siswa/" + id, params);
  },
  setDelete(id) {
    return api.delete("http://localhost:8000/api/siswa/" + id);
  },
};
