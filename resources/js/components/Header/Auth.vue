<template>
    <div v-if="!checkLogin" class="my-auto mr-10">
        <a class="text-gray-100" :href="loginRoute">{{ loginText }}</a>
    </div>
    <div v-else class="my-auto mr-10">
        <a
            class="text-gray-100"
            :href="logoutRoute"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            {{ logoutText }}
        </a>
        <form
            id="logout-form"
            :action="logoutRoute"
            method="POST"
            style="display: none"
        >
            <input type="hidden" name="_token" v-bind:value="csrf" />
        </form>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            loginText: "Login",
            loginRoute: "/login",
            logoutText: "Logout",
            logoutRoute: "/logout",
            user: {},
            checkLogin: "",
        };
    },
    props: ["csrf"],
    methods: {
        getUser() {
            axios.get("/user").then((res) => {
                this.user = res;
                this.isEmptyKeysLength(this.user.data);
            });
        },
        isEmptyKeysLength(obj) {
            if (Object.keys(obj).length === 0) {
                return (this.checkLogin = false);
            }
            return (this.checkLogin = true);
        },
    },
    created: function () {
        this.getUser();
    },
};
</script>
