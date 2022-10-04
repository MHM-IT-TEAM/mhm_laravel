<template>
    <div class="container-fluid">
        <patient_list :headers="headers" :service_id="7" @edit="process_consultation"/>
    </div>
</template>

<script>
import Patient_list from "../../../components/patient_list";
export default {
    name: "dentist_patient_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                {text:'Time',value:'time'},
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Type", value: "admission_type.code" },
                { text: "From", value:"from_admission" },
                { text: "Remark", value:"remark" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ]
        }
    },
    methods:{
        process_consultation(consultation){
            this.$router.push({name:'dental_diagnostic_form',params:{admission:consultation}})
        }
    }
}
</script>

<style scoped>

</style>
