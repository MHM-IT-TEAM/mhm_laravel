<template>
    <div class="container w-75">
        <v-app>
            <item_order :orderer_id="4"/>
        </v-app>
    </div>
</template>

<script>

import Item_order from "../../../components/item_order";
export default {
    name: "item_order_obstetrics",
    components: {Item_order},
}
</script>

<style scoped>

</style>
