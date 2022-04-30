<template>
    <header class="header">
        <button>
            <svg class="hamburger" viewBox="0 0 24 24">
                <path
                    d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"
                />
            </svg>
        </button>
        <h1 class="logo">HoloMemory</h1>
        <Auth :csrf="csrf"></Auth>
    </header>
</template>

<script>
import Auth from "../Header/Auth.vue";

export default {
    components: {
        Auth,
    },
    props: ["csrf"],
};
</script>
