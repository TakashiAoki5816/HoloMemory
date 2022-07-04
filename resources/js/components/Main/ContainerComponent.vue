<template>
    <div class="w-10/12 m-auto">
        <div class="flex justify-between">
            <div class="mt-5">
                <select
                    v-if="groups.length > 0"
                    class="select-group"
                    @change="fetchGroup"
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
            <div class="notification is-danger">
                <strong class="mt-5 font-bold text-red-600"></strong>
            </div>
            <div class="request-box">
                <form v-on:submit.prevent="clickLatestRequest">
                    <button class="request-button" type="submit">
                        最新の配信情報を取得
                    </button>
                </form>
            </div>
        </div>
        <main>
            <div>
                <div v-if="videos.length">
                    <div v-for="(video, index) in videos" :key="index">
                        <div
                            class="date-section"
                            v-if="
                                index === 0 ||
                                video.start_date != videos[index - 1].start_date
                            "
                        >
                            <h2 class="text-white text-center leading-[60px]">
                                {{ video.start_date }}
                            </h2>
                        </div>
                        <ul
                            class="lessons"
                            v-if="
                                index === 0 ||
                                video.start_date != videos[index - 1].start_date
                            "
                        >
                            <li v-for="(lesson, index) in lessons" :key="index">
                                <div
                                    class="lesson"
                                    v-if="
                                        video.start_date === lesson.start_date
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
            videos: [1],
            lessons: [],
            all_url: "api/videos",
            jp_url: "api/videos/jp",
            en_url: "api/videos/en",
            id_url: "api/videos/id",
            empty_message: "直近の配信予定はございません。",
            undefind_group_message: "存在しないグループです。",
        };
    },
    methods: {
        getGroups() {
            axios.get("api/groups").then((res) => {
                this.groups = res.data;
            });
        },
        fetchGroup(selectedGroup) {
            switch (selectedGroup.target.value) {
                case "ALL":
                    this.getVideos(this.all_url);
                    break;
                case "JP":
                    this.getVideos(this.jp_url);
                    break;
                case "EN":
                    this.getVideos(this.en_url);
                    break;
                case "ID":
                    this.getVideos(this.id_url);
                    break;
                default:
                    "存在しないグループです。";
            }
        },
        getGroupVideos() {
            switch (this.selectedGroup) {
                case "ALL":
                    this.getVideos(this.all_url);
                    break;
                case "JP":
                    this.getVideos(this.jp_url);
                    break;
                case "EN":
                    this.getVideos(this.en_url);
                    break;
                case "ID":
                    this.getVideos(this.id_url);
                    break;
                default:
                    return this.undefind_group_message;
            }
        },
        clickLatestRequest() {
            if (confirm("最新の配信情報を取得しますか？")) {
                this.submit();
            }
        },
        getVideos(url) {
            axios.get(url).then((res) => {
                console.log(res.data);
                this.videos = res.data;
                this.lessons = res.data;
            });
        },
        submit() {
            axios.get("/api/videos/create").then(() => {
                this.getGroupVideos();
            });
        },
    },
    mounted() {
        this.getGroups();
        this.getVideos(this.all_url);
    },
};
</script>
