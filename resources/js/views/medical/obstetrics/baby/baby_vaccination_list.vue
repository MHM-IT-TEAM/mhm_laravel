<template>
    <div class="container">
        <patient-list :headers="headers" @edit="editItem" :type_consult="17"></patient-list>
    </div>
</template>

<script>
import PatientList from "../../../../components/patient_list.vue";



export default {
    name: "baby_checkup_list",
    components: { PatientList },
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
                name: "baby_vaccination_card",
                params: {
                    patient_id: item.patient_id,
                    consultation_id: item.id,
                },
            });
        }
    }
}
</script>

<style scoped>

</style>
