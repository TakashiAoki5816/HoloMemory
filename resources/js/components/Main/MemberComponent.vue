<template>
    <div class="w-2/3 m-auto">
        <div class="mt-5">
            <select
                v-if="groups.length > 0"
                class="select-group"
                @change="fetchMembersAfterChangeGroup"
            >
                <option value="ALL">全て</option>
                <option
                    v-for="group in groups"
                    :key="group.id"
                    :value="group.name"
                >
                    {{ group.name }}
                </option>
            </select>
        </div>
        <div class="members-container">
            <div v-for="(member, index) in members" :key="member.id">
                <!-- 国籍表示 -->
                <div
                    :class="[index === 0 ? countryBoxMt0 : countryBox]"
                    v-if="
                        index === 0 ||
                        member.country != members[index - 1].country
                    "
                >
                    <h1 class="country-name">{{ member.country }}</h1>
                </div>
                <!-- グループ名表示 -->
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
                                getGenerationName(
                                    member.country,
                                    member.graduate_id
                                )
                            }}
                        </h2>
                    </div>
                </div>
                <!-- メンバー表示 -->
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
            member_url: "/api/member?group=",
            jp_url: "/api/member/jp",
            en_url: "/api/member/en",
            id_url: "/api/member/id",
            error: "",
        };
    },
    mounted() {
        this.fetchAllGroups();
        this.fetchMembers(this.selectedGroup);
    },
    methods: {
        /**
         * 全てのグループを取得（2022/09/10現在 JP, EN, ID）
         * @return {void}
         */
        fetchAllGroups() {
            axios.get("/api/groups").then((res) => {
                this.groups = res.data;
            });
        },
        /**
         * メンバーを取得
         * @param {string} url
         * @return {void}
         */
        fetchMembers(selectedGroup) {
            console.log(selectedGroup);
            axios
                .get(this.member_url + selectedGroup)
                .then((res) => {
                    this.members = res.data;
                })
                .catch((e) => (this.error = e));
        },
        /**
         * グループ変更後のメンバーを取得
         */
        fetchMembersAfterChangeGroup(selectedGroup) {
            this.selectedGroup = selectedGroup.target.value;
            this.fetchMembers(this.selectedGroup);
        },
        /**
         * 期生名を取得
         * @param {string} country
         * @param {number} graduateId
         * @return {void｜string}
         */
        getGenerationName(country, graduateId) {
            switch (country) {
                case "JP":
                    switch (graduateId) {
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
                    switch (graduateId) {
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
                    switch (graduateId) {
                        case 1:
                            return "1期生";
                        case 2:
                            return "2期生";
                        case 3:
                            return "3期生";
                        default:
                            return "ID 該当なし";
                    }
                default:
                    return "該当なし";
            }
        },
    },
};
</script>
