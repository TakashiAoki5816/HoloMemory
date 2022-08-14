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
                    class="country-box"
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
                            {{ member.graduate_id }}期生
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
                            <img
                                class="member-image"
                                :src="member.channel_icon_url"
                            />
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
            all_url: "api/videos",
            jp_url: "api/videos/jp",
            en_url: "api/videos/en",
            id_url: "api/videos/id",
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
            axios.get("/api/member/index").then((res) => {
                this.members = res.data;
                console.log(this.members);
            });
        },
    },
    mounted() {
        this.fetchGroups();
        this.fetchMembers(this.all_url);
    },
};
</script>
