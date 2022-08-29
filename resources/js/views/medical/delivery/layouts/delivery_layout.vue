<template>
    <div>
        <delivery_header/>
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
import Delivery_header from "./delivery_header";
export default {
    name: "delivery_layout",
    components: {Delivery_header}
}
</script>

<style scoped>

</style>
