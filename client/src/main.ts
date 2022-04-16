import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { store, key } from "./store";
import "./index.css";
// import axios from "axios";

createApp(App).use(store, key).use(router).mount("#app");
