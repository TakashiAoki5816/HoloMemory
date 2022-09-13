require("./bootstrap");
import { createApp } from "vue";

//********************
// 各種コンポーネント
//********************
import HeaderComponent from "./components/Main/HeaderComponent.vue";
import StreamScheduleComponent from "./components/Main/StreamScheduleComponent.vue";
import MembersComponent from "./components/Main/MemberComponent.vue";

//********************
// font-awesome
//********************
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fas, far);

//********************
// Vueインスタンス生成
//********************
const app = createApp({});
app.component("header-component", HeaderComponent);
app.component("stream-schedule-component", StreamScheduleComponent);
app.component("members-component", MembersComponent);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app");
