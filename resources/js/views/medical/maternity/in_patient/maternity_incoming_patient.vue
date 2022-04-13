<template>
    <div class="container">
        <patient-list :service_id="14" :service_activity_id="25" :headers="headers" @edit="editItem" title="admission request"></patient-list>
    </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
    name: "maternity_incoming_patient",
    components: {PatientList},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ]
        }
    },
    methods:{
        editItem(item) {
            this.$router.push({
                name: "maternity_in_patient_admission",
                params: {
                    patient_id: item.patient_id,
                    fullName:nullToString(item.patient.firstName) +" "+ nullToString(item.patient.lastName),
                    admission_id: item.id,
                },
            });
        }
    }
}
function nullToString(el) {
    return el ?? ''
}
</script>

<style scoped>

</style>
