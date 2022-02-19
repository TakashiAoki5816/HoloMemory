<template>Hello Vue !!</template>
<script>
import { onMounted } from "vue";
export default {
    setup() {
        console.log("start vue");

        onMounted(() => {
            console.log("start mounted !");
        });
    },
};
</script>
