import LoginView from "@/views/auth/LoginView";
import RegisterView from "@/views/auth/RegisterView";
import UserView from "@/views/posts/UserView";
import AdminView from "@/views/posts/AdminView";
import TambahView from "@/views/posts/TambahView";

import middleware from "./middleware";

export default [
  {
    path: "/login",
    name: "login",
    component: LoginView,
    beforeEnter: middleware.guest,
  },
  {
    path: "/register",
    name: "register",
    component: RegisterView,
    beforeEnter: middleware.guest,
  },
  {
    path: "/",
    name: "UserPost",
    component: UserView,
    beforeEnter: middleware.user,
  },
  {
    path: "/",
    name: "AdminPost",
    component: AdminView,
    beforeEnter: middleware.admin,
  },
  {
    path: "/tambahsiswa",
    name: "TambahView",
    component: TambahView,
    beforeEnter: middleware.admin,
  },
];
