<template>
    <header class="header">
        <Slide>
            <a :href="this.homeUrl">
                <span>{{ this.home }}</span>
            </a>
            <a :href="this.memberUrl">
                <span>{{ this.member }}</span>
            </a>
        </Slide>
        <h1 class="logo">
            <a href="/">HoloMemory</a>
        </h1>
        <Auth :csrf="csrf"></Auth>
    </header>
</template>

<script>
import Auth from "../Header/Auth.vue";
import { Slide } from "vue3-burger-menu";

export default {
    data: function () {
        return {
            homeUrl: "/",
            home: "Home",
            memberUrl: "/member/index",
            member: "Member",
        };
    },
    components: {
        Auth,
        Slide,
    },
    props: ["csrf"],
};
</script>
<style>
.bm-burger-button {
    top: 25px;
    left: 25px;
}

.bm-burger-bars {
    background-color: rgb(239, 239, 239);
}

.bm-overlay {
    background-color: #fff;
}
</style>
