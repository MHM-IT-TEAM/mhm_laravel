<template>
    <div class="container w-75">
        <v-app>
            <item_order :orderer_id="2" :data_src="data_src" :is_overview="is_overview"/>
        </v-app>
    </div>
</template>

<script>
import item_order from "../../../../components/item_order";
export default {
    name: "stork_order",
    components: {item_order},
    data(){
        return{
            data_src:null,
            is_overview:false
        }
    },
    created(){
        if(this.$route.params.data){
            this.data_src= this.$route.params.data
            this.is_overview=true
        }
    }
}
</script>

<style scoped>

</style>
