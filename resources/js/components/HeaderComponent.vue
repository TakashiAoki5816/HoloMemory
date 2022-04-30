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
    </header>
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
