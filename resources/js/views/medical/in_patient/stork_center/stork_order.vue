<template>
    <div class="container w-75">
        <v-app>
            <item_order :orderer_id="2"/>
        </v-app>
    </div>
</template>

<script>
import item_order from "../../../../components/item_order";
export default {
    name: "stork_order",
    components: {item_order}
}
</script>

<style scoped>

</style>
