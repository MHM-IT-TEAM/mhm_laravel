<template>
    <div class="container">
        <patient-list :type_consult="8" :headers="headers" @edit="editItem"></patient-list>
    </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
    name: "baby_checkup_list",
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
                name: "baby_checkup",
                params: {
                    patient_id: item.patient_id,
                    fullName:item.patient.firstName +" "+ item.patient.lastName,
                    consultation_id: item.id,
                },
            });
        }
    }
}
</script>

<style scoped>

</style>
