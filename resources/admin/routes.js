import { createRouter, createWebHashHistory } from 'vue-router'
import { AddressList, UserManage } from "./views";

const routes = [
    {
      path: "/",
      name: "home",
      component: AddressList,
    },
    {
      path: "/user-manage",
      name: "user-manage",
      component: UserManage,
    },
  ];

  const router = createRouter({
    history: createWebHashHistory(),
    routes,
  });

  export default router