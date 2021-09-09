<template>
    <div>

        <cashier_header/>
        <transition
            name="fade"
            mode="out-in">
            <router-view />
        </transition>

    </div>
</template>

<script>
import Cashier_header from "./cashier_header";
export default {
    name: "cashier_layout",
    components: {Cashier_header}
}
</script>

<style scoped>

</style>
