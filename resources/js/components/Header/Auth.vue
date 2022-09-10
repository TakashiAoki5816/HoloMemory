<template>
    <!-- ログイン状態確認処理の完了確認 -->
    <div v-if="isCheckDoneConfirmLoginStatus" class="my-auto mr-5">
        <!-- ログイン状態かの確認 -->
        <div v-if="checkLoginStatus">
            <a
                class="text-gray-100"
                :href="logoutUrl"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
                {{ logout }}
            </a>
            <form
                id="logout-form"
                :action="logoutUrl"
                method="POST"
                style="display: none"
            >
                <input type="hidden" name="_token" v-bind:value="csrf" />
            </form>
        </div>
        <!-- ログインしていなかった場合 -->
        <div v-else>
            <a class="text-gray-100" :href="loginUrl">{{ login }}</a>
        </div>
    </div>
    <!-- ログイン状態確認処理 完了までの間、空のdivタグを表示する -->
    <div v-else></div>
</template>
<script>
export default {
    data: function () {
        return {
            isCheckDoneConfirmLoginStatus: false, // ログイン状態確認 完了フラグ
            checkLoginStatus: false, // ログイン状態かの確認フラグ
            user: {},
            login: "Login",
            loginUrl: "/login",
            logout: "Logout",
            logoutUrl: "/logout",
        };
    },
    props: ["csrf"],
    methods: {
        /**
         * ログインユーザーを取得
         * @return void
         */
        fetchLoginUser() {
            axios.get("/user").then((res) => {
                this.user = res;
                this.isCheckLoginStatusUser(this.user.data);
                this.isCheckDoneConfirmLoginStatus = true;
            });
        },
        /**
         * ユーザーがログイン状態かの確認
         * @param {object} user
         * @return {boolean} checkLoginStatus
         */
        isCheckLoginStatusUser(user) {
            if (Object.keys(user).length === 0) {
                return (this.checkLoginStatus = false);
            }
            return (this.checkLoginStatus = true);
        },
    },
    mounted: function () {
        this.fetchLoginUser();
    },
};
</script>
