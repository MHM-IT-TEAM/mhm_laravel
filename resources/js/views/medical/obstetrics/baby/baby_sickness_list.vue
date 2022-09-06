<template>
    <div class="container">
        <patient_list :service_activity_id="service_activities" :headers="headers" @edit="editItem" title="baby sickness"/>
    </div>
</template>

<script>
import Patient_list from "../../../../components/patient_list";
export default {
    name: "baby_sickness_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            service_activities:[19]
        }
    },
    methods:{
        editItem(item) {
            this.$router.push({
                name: "baby_sickness",
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
