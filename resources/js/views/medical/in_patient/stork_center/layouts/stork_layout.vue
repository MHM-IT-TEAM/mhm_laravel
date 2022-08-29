<template>
    <div>
       <stork_header/>
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
import Stork_header from "./partials/stork_header";
export default {
    name: "stork_layout",
    components: {Stork_header}
}
</script>

<style scoped>

</style>
