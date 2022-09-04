require("./bootstrap");
import { createApp } from "vue";
// import { createRouter, createWebHistory } from "vue-router";
import HeaderComponent from "./components/Main/HeaderComponent.vue";
import ContainerComponent from "./components/Main/ContainerComponent.vue";
import MembersComponent from "./components/Main/MemberComponent.vue";

import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fas, far);

const app = createApp({});
app.component("header-component", HeaderComponent);
app.component("container-component", ContainerComponent);
app.component("members-component", MembersComponent);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app");

// const app = createApp({
//     components: {
//         HeaderComponent,
//         ContainerComponent,
//         MembersComponent,
//         FontAwesomeIcon,
//     },
// });

// app.mount("#app");
