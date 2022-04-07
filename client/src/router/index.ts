import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import DashBoard from "@/views/DashBoard.vue";
import ProfileData from "@/views/ProfileData.vue";
import OrderData from "@/views/OrderData.vue";
import ProductData from "@/views/ProductData.vue";
import Recruitment from "@/views/Recruitment.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "DashBoard",
    component: DashBoard,
  },
  {
    path: "/recruitment",
    name: "Recruitment",
    component: Recruitment,
  },
  {
    path: "/profile",
    name: "ProfileData",
    component: ProfileData,
  },
  {
    path: "/order",
    name: "OrderData",
    component: OrderData,
  },
  {
    path: "/product",
    name: "ProductData",
    component: ProductData,
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
