<template>
    <div class="container">
        <item_index :is_admin="is_admin"/>
    </div>
</template>

<script>
import Item_index from "../../inventory_management/item/item_index";
export default {
    name: "grace_inventory",
    components: {Item_index},
    data(){
        return{
            is_admin:false
        }
    }
}
</script>

<style scoped>

</style>
