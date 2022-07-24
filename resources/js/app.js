require("./bootstrap");
import { createApp } from "vue";
// import { createRouter, createWebHistory } from "vue-router";
import HeaderComponent from "./components/Main/HeaderComponent.vue";
import ContainerComponent from "./components/Main/ContainerComponent.vue";
import MembersComponent from "./components/Main/MemberComponent.vue";

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
        MembersComponent,
    },
});

// app.use(router);

app.mount("#app");
