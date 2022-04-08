import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import DashBoard from "@/views/DashBoard.vue";
import Recruitment from "@/views/Recruitment.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "DashBoard",
    component: DashBoard,
  },
  {
    path: "/recruitment/:id",
    name: "Recruitment",
    component: Recruitment,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
