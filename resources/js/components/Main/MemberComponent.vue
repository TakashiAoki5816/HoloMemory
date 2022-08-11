<template>
    <div class="w-2/3 m-auto">
        <div class="mt-5">
            <select class="select-group">
                <option value="ALL">全て</option>
            </select>
        </div>
        <div class="generation-container">
            <div class="generation-box">
                <div class="generation-line">
                    <h2 class="generation-text">1期生</h2>
                </div>
            </div>
            <div class="member-box">
                <div class="member-left-box">
                    <div class="member-image-box">
                        <img
                            class="member-image"
                            src="../../../../public/images/kazama.jpeg"
                        />
                    </div>
                    <div class="member-name-box">
                        <p class="member-name">風間いろは</p>
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
</template>

<script>
export default {
    // mounted() {
    //     this.getMembers();
    // }
};
</script>
