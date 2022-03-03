<template>
    <div class="container m-auto">
        <div class="flex justify-between">
            <div class="notification is-danger">
                <strong class="mt-5 font-bold text-red-600">
                    {{ error.exception + "(" + error.statusCode + "エラー)" }}
                </strong>
            </div>
            <div class="request-box">
                <form method="GET" action="/api/videos/store">
                    <button class="request-button" type="submit">
                        最新の配信情報を取得
                    </button>
                </form>
            </div>
        </div>
        <main>
            <!-- @if (isset($videos)) -->
            <div class="lessons">
                <!-- 日付の境界線チェック -->
                <!-- @if ($key === 0 || substr($videos[$key]["scheduled_start_time"],
                5, 5) != substr($videos[$key-1]["scheduled_start_time"], 5, 5)) -->
                <!-- <div class="date-section">
                    <h2 class="text-white text-center leading-[60px]">
                        {{ $video.start_date }}
                    </h2>
                </div> -->
                <!-- @endif -->

                <div
                    class="lesson"
                    v-for="(video, index) in videos"
                    :key="index"
                >
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
                                v-bind:src="video.member.channel_icon_url"
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
            </div>
            <!-- @endif -->
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
                this.videos = res.data;
            });
        },
    },
    mounted() {
        this.getVideos();
    },
};
</script>
