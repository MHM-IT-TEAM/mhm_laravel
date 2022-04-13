<template>
    <div class="container w-75">
        <patient-list :service_id="14" :service_activity_id="25" :headers="headers" @edit="editItem" title="admission request"></patient-list>
    </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
    name: "stork_incoming_patient",
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
                name: "stork_admission",
                params: {
                    admission:item
                },
            });
        }
    }
}

</script>

<style scoped>

</style>
