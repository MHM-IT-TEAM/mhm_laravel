<template>
    <div class="container">
        <patient-list :service_activity_id="service_activities" :headers="headers" @edit="editItem" title="baby checkup"></patient-list>
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
                {text:'Time',value:'time'},
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Type of admission", value:"admission_type.code", sortable: false },
                { text: "From", value:"from_admission" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            service_activities:[18]
        }
    },
    methods:{
        editItem(item) {
            this.$router.push({
                name: "baby_checkup",
                params: {
                    patient_id: item.patient_id,
                    fullName:nullToString(item.patient.firstName) +" "+ nullToString(item.patient.lastName),
                    admission_id: item.id,
                    admission:item
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
