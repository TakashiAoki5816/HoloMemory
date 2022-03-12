require("./bootstrap");
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
// import Home from "../views/Home";
import HeaderComponent from "./components/HeaderComponent.vue";
import ContainerComponent from "./components/ContainerComponent.vue";

// const routes = [
//     {
//         path: "/",
//         name: "Home",
//         component: Home,
//     },
// ];

// const router = createRouter({
//     history: createWebHistory(),
//     routes,
// });

const app = createApp({
    components: {
        HeaderComponent,
        ContainerComponent,
    },
});

// app.use(router);

app.mount("#app");
