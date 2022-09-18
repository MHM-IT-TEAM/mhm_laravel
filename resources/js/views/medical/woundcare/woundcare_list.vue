<template>
    <div class="container">
        <patient_list :service_activity_id="service_activities" :headers="headers" @edit="editItem" title="Wound care"/>
    </div>
</template>

<script>
import Patient_list from "../../../components/patient_list";
export default {
    name: "woundcare_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                {text:'Time',value:'time'},
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            service_activities:[8]
        }
    },
    methods:{
        editItem(item) {
            this.$router.push({
                name: "wound_care_form",
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
