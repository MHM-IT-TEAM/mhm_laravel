<template>
    <div class="container">
        <patient-list :service_id="8" :service_activity_id="74" :headers="headers" @edit="editItem" title="FAMILY PLANNING"></patient-list>
    </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
    name: "family_planning_list",
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
                name: "family_planning_form",
                params: {
                    patient_id: item.patient_id,
                    admission_id: item.id,
                },
            });
        }
    }
}
</script>

<style scoped>

</style>
