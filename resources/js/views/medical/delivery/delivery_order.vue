<template>
    <v-app>
        <item_order :orderer_id="10"/>
    </v-app>
</template>

<script>
import Item_order from "../../../components/item_order";
export default {
    name: "delivery_order",
    components: {Item_order}
}
</script>

<style scoped>

</style>
