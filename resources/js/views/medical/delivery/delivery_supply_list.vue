<template>
    <supply_list :headers="headers" :orderer_id="10" />
</template>

<script>
import Supply_list from "../../../components/supply_list";
export default {
    name: "delivery_supply_list",
    components: {Supply_list},
    data(){
        return{
            headers:[
                {text:"Date",value:"created_at"},
                { text: "Code", value: "code" },
                { text: "Collector", value: "collector.name" },
                { text: "Remark", value: "remark" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            dialog:false
        }
    },
    methods:{
        async open_request(request){

        }
    }
}
</script>

<style scoped>

</style>
