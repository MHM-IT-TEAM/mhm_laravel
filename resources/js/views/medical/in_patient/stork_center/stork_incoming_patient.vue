<template>
    <div class="container">
        <patient-list  :service_activity_id="service_activities" :headers="headers" @edit="editItem" title="admission request"></patient-list>
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
                { text: "Type of admission", value:"admission_type.code", sortable: false },
                {text:"nature",value:"service_activity.name"},
                {text:"remark",value:"remark"},
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },

            ],
            service_activities:[23,24,25,26,27,28,45]
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
