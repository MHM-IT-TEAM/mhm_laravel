<template>
    <div class="container w-75">
       <patient_list :headers="headers" :type_consult="14" @edit="process_consultation"/>
    </div>
</template>

<script>
import Patient_list from "../../../components/patient_list";
export default {
    name: "maternity_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Type", value: "admission_type.code" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ]
        }
    },
    methods:{
        process_consultation(consultation){
            this.$router.push({name:'maternity_admission',params:{admission:consultation}})
        }
    }
}
</script>

<style scoped>

</style>
