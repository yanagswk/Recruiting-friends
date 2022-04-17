import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import DashBoard from "@/views/DashBoard.vue";
import Recruitment from "@/views/Recruitment.vue";
import NotFound from "@/views/NotFound.vue";

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
  {
    // 指定したパスが存在しない場合は、NotFound
    path: "/:catchAll(.*)",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
