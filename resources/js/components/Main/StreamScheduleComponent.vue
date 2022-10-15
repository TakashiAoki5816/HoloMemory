<template>
    <div class="w-10/12 m-auto">
        <div class="flex justify-between">
            <div class="mt-5">
                <select
                    v-if="groups.length > 0"
                    class="select-group"
                    @change="fetchVideosBySelectedGroup"
                >
                    <option value="ALL">全て</option>
                    <option
                        v-for="group in groups"
                        :key="group"
                        :value="group.name"
                    >
                        {{ group.name }}
                    </option>
                </select>
            </div>
            <div v-if="message" class="notification mt-7">
                <strong class="font-bold text-gray-500">{{ message }}</strong>
            </div>
            <div v-if="error_message" class="notification is-danger mt-7">
                <strong class="font-bold text-red-600">{{
                    error_message
                }}</strong>
            </div>
            <div class="request-box">
                <form v-on:submit.prevent="fetchLatestVideos">
                    <button class="request-button" type="submit">
                        最新の配信情報を取得
                    </button>
                </form>
            </div>
        </div>
        <main>
            <div>
                <div v-if="Object.keys(streams).length">
                    <div
                        v-for="(scheduleDate, index) in scheduleDates"
                        :key="index"
                    >
                        <!-- 日付表示 -->
                        <div class="date-section">
                            <h2 class="date-text">
                                {{ scheduleDate }}
                            </h2>
                        </div>
                        <!-- 配信一覧 -->

                        <ul class="lessons">
                            <li
                                v-for="stream in streams[scheduleDate]"
                                :key="stream.video_id"
                            >
                                <div class="lesson">
                                    <div class="lesson-header">
                                        <div>
                                            {{ stream.start_time }}
                                        </div>
                                        <div>
                                            {{ stream.member.name }}
                                        </div>
                                    </div>
                                    <div class="lesson-image">
                                        <a
                                            v-bind:href="
                                                'https://www.youtube.com/watch?v=' +
                                                stream.video_id
                                            "
                                            target="_blank"
                                            rel="noopener
                                noreferrer"
                                        >
                                            <img
                                                v-bind:src="
                                                    stream.thumbnails_url
                                                "
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <a
                                            class="lesson-channel-icon"
                                            v-bind:href="
                                                'https://www.youtube.com/channel/' +
                                                stream.member.channel_id
                                            "
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <img
                                                v-bind:src="
                                                    stream.member
                                                        .channel_icon_url
                                                "
                                                style="
                                                    border-radius: 50%;
                                                    border: 2px#eeac5e solid;
                                                "
                                                width="60"
                                                height="60"
                                            />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-else class="text-center font-bold mt-5">
                    {{ empty_message }}
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            groups: [],
            streams: {},
            lessons: [],
            scheduleDates: [],
            selectedGroup: "ALL",
            all_url: "api/videos",
            empty_message: "直近の配信予定はございません。",
            undefind_group_message: "存在しないグループです。",
            message: "",
            error_message: "",
        };
    },
    mounted() {
        this.fetchAllGroups();
        this.fetchScheduleDate(this.selectedGroup);
        this.fetchVideosByUrl(this.all_url, this.selectedGroup);
    },
    methods: {
        /**
         * 全てのグループを取得（2022/09/10現在 JP, EN, ID）
         * @return {void}
         */
        fetchAllGroups() {
            axios.get("api/groups").then((res) => {
                this.groups = res.data;
            });
        },

        /**
         * 対象のグループの配信日付を取得する
         * @param {string}
         * @return {void}
         */
        fetchScheduleDate(selectedGroup) {
            axios
                .get("api/videos/date/index?group=" + selectedGroup)
                .then((res) => {
                    this.scheduleDates = res.data;
                    console.log(this.scheduleDates);
                });
        },

        /**
         * URLに応じた配信情報を取得
         * @param {string} url
         * @return {void}
         */
        fetchVideosByUrl(url, selectedGroup) {
            axios.get(url + "?group=" + selectedGroup).then((res) => {
                this.streams = res.data;
                console.log(this.streams);
            });
        },

        /**
         * 選択されたグループの配信情報を取得
         * @param {int} selectedGroup
         * @return {void}
         */
        fetchVideosBySelectedGroup(selectedGroup) {
            // 最新の配信情報を取得した際にどのグループを選択しているのかが判るように格納
            this.selectedGroup = selectedGroup.target.value;
            this.fetchScheduleDate(this.selectedGroup);
            this.fetchVideosByUrl(this.all_url, this.selectedGroup);
        },

        /**
         * 最新の配信情報を取得
         * @return {void}
         */
        fetchLatestVideos() {
            if (confirm("最新の配信情報を取得しますか？")) {
                axios
                    .get("/api/videos/create")
                    .then(() => {
                        this.fetchScheduleDate(this.selectedGroup);
                        this.fetchVideosByUrl(this.all_url, this.selectedGroup);
                        this.message = "配信情報を取得しました。";
                    })
                    .catch(
                        (e) =>
                            (this.error_message =
                                "配信情報取得に失敗しました。　" + e)
                    );
            }
            return;
        },
    },
};
</script>
