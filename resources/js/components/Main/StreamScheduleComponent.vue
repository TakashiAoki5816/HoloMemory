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
                <div v-if="streams.length">
                    <div
                        v-for="(stream, index) in streams"
                        :key="stream.video_id"
                    >
                        <!-- 日付表示 -->
                        <div
                            class="date-section"
                            v-if="
                                (index === 0 &&
                                    isUnEmptyFlg(stream.start_date)) ||
                                (index !== 0 &&
                                    isUnEmptyFlg(stream.start_date) &&
                                    stream.start_date !=
                                        streams[index - 1].start_date)
                            "
                        >
                            <h2 class="date-text">
                                {{ stream.start_date }}
                            </h2>
                        </div>
                        <!-- 配信一覧 -->
                        <ul
                            class="lessons"
                            v-if="
                                index === 0 ||
                                stream.start_date !=
                                    streams[index - 1].start_date
                            "
                        >
                            <li
                                v-for="lesson in lessons"
                                :key="lesson.video_id"
                            >
                                <div
                                    class="lesson"
                                    v-if="
                                        (selectedGroup === 'ALL' ||
                                            lesson.country === selectedGroup) &&
                                        lesson.start_date === stream.start_date
                                    "
                                >
                                    <div class="lesson-header">
                                        <div>{{ lesson.start_time }}</div>
                                        <div>{{ lesson.member.name }}</div>
                                    </div>
                                    <div class="lesson-image">
                                        <a
                                            v-bind:href="
                                                'https://www.youtube.com/watch?v=' +
                                                lesson.video_id
                                            "
                                            target="_blank"
                                            rel="noopener
                                noreferrer"
                                        >
                                            <img
                                                v-bind:src="
                                                    lesson.thumbnails_url
                                                "
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <a
                                            class="lesson-channel-icon"
                                            v-bind:href="
                                                'https://www.youtube.com/channel/' +
                                                lesson.member.channel_id
                                            "
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <img
                                                v-bind:src="
                                                    lesson.member
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
            streams: [],
            lessons: [],
            streams_lessons: [],
            selectedGroup: "ALL",
            all_url: "api/videos",
            empty_message: "直近の配信予定はございません。",
            undefind_group_message: "存在しないグループです。",
            unEmptyFlg: true,
            message: "",
            error_message: "",
        };
    },
    mounted() {
        this.fetchAllGroups();
        this.fetchVideosByUrl(this.all_url);
        console.log(this.streams);
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
         * URLに応じた配信情報を取得
         * @param {string} url
         * @return {void}
         */
        fetchVideosByUrl(url) {
            axios.get(url).then((res) => {
                // 配信動画と日付を区別するために同じ情報を二つの変数に格納（TODO:もしかしたら1つで行ける？）
                this.streams = res.data;
                console.log(this.streams);
                this.lessons = res.data;
                this.streams_lessons = res.data;
            });
        },
        /**
         * 選択されたグループの配信情報を取得
         * TODO:現状、グループごとにSQLを発行しているが、よくよくは一度に配信情報を全て取得し、Vue側でうまく切り替えたい
         * @param {int} selectedGroup
         * @return {void}
         */
        fetchVideosBySelectedGroup(selectedGroup) {
            // 最新の配信情報を取得した際にどのグループを選択しているのかが判るように格納
            this.selectedGroup = selectedGroup.target.value;

            // if (selectedGroup !== "ALL") {
            //     streams.find((stream) => stream.start_date);
            // }

            // this.isUnEmptyFlg(this.selectedGroup);
            // console.log(this.selectedGroup);
            // switch (selectedGroup.target.value) {
            //     case "ALL":
            //         true;
            //         break;
            //     case "JP":
            //         this.fetchVideosByUrl(this.jp_url);
            //         break;
            //     case "EN":
            //         this.fetchVideosByUrl(this.en_url);
            //         break;
            //     case "ID":
            //         this.fetchVideosByUrl(this.id_url);
            //         break;
            //     default:
            //         alert(this.undefind_group_message);
            // }
        },
        /**
         * 最新の配信情報取得リクエスト
         * @return {void}
         */
        fetchLatestVideos() {
            if (confirm("最新の配信情報を取得しますか？")) {
                axios
                    .get("/api/videos/create")
                    .then(() => {
                        // this.fetchGroupVideos();
                        this.fetchVideosByUrl(this.all_url);
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
        fetchGroupVideos() {
            switch (this.selectedGroup) {
                case "ALL":
                    this.fetchVideosByUrl(this.all_url);
                    break;
                case "JP":
                    this.fetchVideosByUrl(this.jp_url);
                    break;
                case "EN":
                    this.fetchVideosByUrl(this.en_url);
                    break;
                case "ID":
                    this.fetchVideosByUrl(this.id_url);
                    break;
                default:
                    alert(this.undefind_group_message);
            }
        },
        isUnEmptyFlg(targetDate) {
            // console.log(targetDate);
            // this.streams_lessons.forEach((stream, index) => {
            //     console.log("aaa");
            //     console.log(stream.country);
            //     console.log(this.streams_lessons.pop());
            //     console.log(index);
            //     if (
            //         stream.country === this.selectedGroup &&
            //         stream.start_date === targetDate
            //     ) {
            //         console.log(stream);
            //         return (this.unEmptyFlg = true);
            //     }
            //     if (index === this.streams_lessons.pop()) {
            //         return (this.unEmptyFlg = false);
            //     }
            // });
            // console.log(this.unEmptyFlg);
            // // console.log(this.streams_lessons);
            // console.log("bbb");
            // console.log(this.streams);
            return this.unEmptyFlg;
        },
    },
};
</script>
