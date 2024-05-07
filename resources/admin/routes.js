import { createRouter, createWebHashHistory } from 'vue-router'
import { AddressList } from "./views";

const routes = [
    {
      path: "/",
      name: "home",
      component: AddressList,
    },
  ];

  const router = createRouter({
    history: createWebHashHistory(),
    routes,
  });

  export default router