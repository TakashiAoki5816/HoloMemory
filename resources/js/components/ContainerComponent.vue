<template>
    <div class="container m-auto">
        <div class="flex justify-between">
            <div class="notification is-danger">
                <strong class="mt-5 font-bold text-red-600">
                    {{ error.exception + "(" + error.statusCode + "エラー)" }}
                </strong>
            </div>
            <div class="request-box">
                <form v-on:submit.prevent="submit">
                    <button class="request-button" type="submit">
                        最新の配信情報を取得
                    </button>
                </form>
            </div>
        </div>
        <main>
            <div class="container">
                <ul>
                    <li v-for="(video, index) in videos" :key="index">
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
                        <div class="lesson">
                            <div class="lesson-header">
                                <div>{{ video.start_time }}</div>
                                <div>{{ video.member.name }}</div>
                            </div>
                            <div class="lesson-image">
                                <a
                                    v-bind:href="
                                        'https://www.youtube.com/watch?v=' +
                                        video.video_id
                                    "
                                    target="_blank"
                                    rel="noopener
                            noreferrer"
                                >
                                    <img v-bind:src="video.thumbnails_url" />
                                </a>
                            </div>
                            <div>
                                <a
                                    class="lesson-channel-icon"
                                    v-bind:href="
                                        'https://www.youtube.com/channel/' +
                                        video.member.channel_id
                                    "
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        v-bind:src="
                                            video.member.channel_icon_url
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
                            <!-- </div> -->
                        </div>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    props: ["errors"],
    data: function () {
        return {
            videos: [],
            error: {
                exception: this.errors.exception,
                statusCode: this.errors.statusCode,
            },
        };
    },
    methods: {
        getVideos() {
            axios.get("api/videos").then((res) => {
                console.log(res.data);
                this.videos = res.data;
            });
        },
        submit() {
            axios.get("/api/videos/create").then(() => {
                // this.$router.push("/");
                this.getVideos();
            });
        },
    },
    mounted() {
        this.getVideos();
    },
};
</script>
