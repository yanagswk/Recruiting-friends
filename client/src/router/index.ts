import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import DashBoard from "@/views/DashBoard.vue";
import Recruitment from "@/views/Recruitment.vue";
import NotFound from "@/views/NotFound.vue";
// import gsap from "gsap";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "DashBoard",
    component: DashBoard,
    meta: { title: "ゆるボ！" },
  },
  {
    path: "/recruitment/:id",
    name: "Recruitment",
    component: Recruitment,
    // meta: { title: "詳細画面" },
  },
  {
    // 指定したパスが存在しない場合は、NotFound
    path: "/:catchAll(.*)",
    component: NotFound,
    meta: { title: "404" },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

const DEFAULT_TITLE = "ゆるボ！";
router.afterEach((to, from) => {
  const title = to.meta.title as string;
  document.title = title || DEFAULT_TITLE;
});

// GSAPで遷移時にアニメーション
// router.beforeEach((to, from, next) => {
//   const tl = gsap.timeline();
//   tl.to(".wrapper", {
//     duration: 0.1,
//     opacity: 0,
//     onComplete: () => {
//       next();
//     },
//   }).to(
//     ".wrapper",
//     {
//       duration: 0.1,
//       opacity: 1,
//     },
//     1
//   );
// });

export default router;
