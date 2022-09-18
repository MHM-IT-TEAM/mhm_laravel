<template>
    <internal_lab_list :headers="headers" @open="open_request" :service_id="services"/>
</template>

<script>
import Internal_lab_list from "../../labwork/internal/internal_lab_list";
export default {
    name: "stork_internal_lab_list",
    components: {Internal_lab_list},
    data(){
        return{
            headers:[
                {text:"Date",value:"created_at"},
                { text: "Id", value: "admission.patient_id" },
                { text: "First Name", value: "admission.patient.firstName" },
                { text: "Last Name", value: "admission.patient.lastName" },
                { text: "Orderer", value: "orderer" },
                { text: "Status", value: "lab_work_step.description" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            services:[12,13,14,15,16,17]
        }
    },
    methods:{
        async open_request(request){
            this.$router.push({name:'stork_view_internal_lab_result',params:{request:request}})
        }
    }
}
</script>

<style scoped>

</style>
