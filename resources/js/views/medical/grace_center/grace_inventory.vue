<template>
    <div class="container">
        <item_index :is_admin="is_admin" :orderer_id="orderer_id" />
<!--        <inventory_service/>-->
    </div>
</template>

<script>
import Item_index from "../../inventory_management/item/item_index";
export default {
    name: "grace_inventory",
    components: {Item_index},
    data(){
        return{
            is_admin:false,
            orderer_id:1
        }
    }
}
</script>

<style scoped>

</style>
