<template>
    <div class="container-fluid vh-100">
        <patient_list :service_id="8" :service_activity_id="11" :headers="headers" @edit="process_consultation" title="ultrasound"/>
    </div>
</template>

<script>
import Patient_list from "../../../../components/patient_list";
export default {
    name: "ultrasound_queue",
    components: {Patient_list},
    data() {
        return {
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Type", value: "admission_type.code" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
        };
    },
    methods:{
        process_consultation(consultation) {
            this.$router.push({
                name: "patient_ultrasound_admission_list",
                params: { admission: consultation },
            });
        },
    }
}
</script>

<style scoped>

</style>
