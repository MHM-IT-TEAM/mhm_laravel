<template>
    <div>
        <woundcare_header/>
        <transition
            name="fade"
            mode="out-in">
            <div class="container">
                <router-view />
            </div>
        </transition>
    </div>

</template>

<script>
import Woundcare_header from "./woundcare_header";
export default {
    name: "wound_care_layout",
    components: {Woundcare_header}
}
</script>

<style scoped>

</style>
