<template>
    <div class="container">
        <internal_lab_list :headers="headers" @open="open_request"/>
    </div>
</template>

<script>
import Internal_lab_list from "../labwork/internal/internal_lab_list";
export default {
    name: "generalist_internal_lab_list",
    components: {Internal_lab_list},
    data(){
        return{
            headers:[
                { text: "Id", value: "admission.patient_id" },
                { text: "First Name", value: "admission.patient.firstName" },
                { text: "Last Name", value: "admission.patient.lastName" },
                { text: "Orderer", value: "orderer" },
                { text: "Status", value: "lab_work_step.description" },
                { text: "Actions", value: "actions", sortable: false },
            ]
        }
    },
    methods:{
        async open_request(request){
            // console.log(request)
            await axios.post('/api/v1/patient_system/internal_lab/open_request',{id:request.id}).then(response=>{
            })
        }
    }
}
</script>

<style scoped>

</style>
