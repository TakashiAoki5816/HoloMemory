<template>
    <div class="w-2/3 m-auto">
        <div class="mt-5">
            <select
                v-if="groups.length > 0"
                class="select-group"
                @change="changeGroup"
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
        <div class="members-container">
            <div v-for="(member, index) in members" :key="index">
                <div
                    :class="[index === 0 ? countryBoxMt0 : countryBox]"
                    v-if="
                        index === 0 ||
                        member.country != members[index - 1].country
                    "
                >
                    <h1 class="country-name">{{ member.country }}</h1>
                </div>
                <div
                    class="generation-box"
                    v-if="
                        index === 0 ||
                        member.graduate_id != members[index - 1].graduate_id
                    "
                >
                    <div class="generation-line">
                        <h2 class="generation-name">
                            {{
                                generationName(
                                    member.country,
                                    member.graduate_id
                                )
                            }}
                        </h2>
                    </div>
                </div>
                <div
                    class="member-box"
                    v-if="
                        index === 0 ||
                        member.generation_id ===
                            members[index - 1].generation_id
                    "
                >
                    <div class="member-left-box">
                        <div class="member-image-box">
                            <a
                                :href="
                                    'https://www.youtube.com/channel/' +
                                    member.channel_id
                                "
                            >
                                <img
                                    class="member-image"
                                    :src="member.channel_icon_url"
                                />
                            </a>
                        </div>
                        <div class="member-name-box">
                            <p class="member-name">{{ member.name }}</p>
                        </div>
                    </div>
                    <div class="member-right-box">
                        <div class="member-like-box">
                            <div class="member-like-button">
                                <font-awesome-icon
                                    class="member-like-icon"
                                    :icon="['fas', 'star']"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            groups: [],
            members: [],
            selectedGroup: "ALL",
            countryBox: "country-box",
            countryBoxMt0: "country-box-mt-0",
            all_url: "/api/member/index",
            jp_url: "/api/member/jp",
            en_url: "/api/member/en",
            id_url: "/api/member/id",
        };
    },
    methods: {
        fetchGroups() {
            axios.get("/api/groups").then((res) => {
                this.groups = res.data;
            });
        },
        changeGroup(selectedGroup) {
            this.selectedGroup = selectedGroup.target.value;
            switch (selectedGroup.target.value) {
                case "ALL":
                    this.fetchMembers(this.all_url);
                    break;
                case "JP":
                    this.fetchMembers(this.jp_url);
                    break;
                case "EN":
                    this.fetchMembers(this.en_url);
                    break;
                case "ID":
                    this.fetchMembers(this.id_url);
                    break;
                default:
                    "存在しないグループです。";
            }
        },
        fetchMembers(url) {
            axios.get(url).then((res) => {
                this.members = res.data;
                console.log(this.members);
            });
        },
        generationName(country, graduate_id) {
            console.log(graduate_id);
            switch (country) {
                case "JP":
                    switch (graduate_id) {
                        case 0:
                            return "０期生";
                        case 1:
                            return "１期生";
                        case 2:
                            return "２期生";
                        case 3:
                            return "３期生";
                        case 4:
                            return "4期生";
                        case 5:
                            return "5期生";
                        case 6:
                            return "秘密結社holoX";
                        case 99:
                            return "ホロライブゲーマーズ";
                        default:
                            return "JP 該当なし";
                    }
                case "EN":
                    switch (graduate_id) {
                        case 1:
                            return "Myth";
                        case 2:
                            return "Council";
                        case 98:
                            return "Project: HOPE";
                        default:
                            return "EN 該当なし";
                    }
                case "ID":
                    switch (graduate_id) {
                        case 1:
                            return "1期生";
                        case 2:
                            return "2期生";
                        case 3:
                            return "３期生";
                        default:
                            return "ID 該当なし";
                    }
                default:
                    return "該当なし";
            }
        },
    },
    mounted() {
        this.fetchGroups();
        this.fetchMembers(this.all_url);
    },
};
</script>
