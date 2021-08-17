<template>
    <div class="container">
        <patient-list :headers="headers" @edit="editItem" :type_consult="5" />
    </div>
</template>

<script>
import patientList from "../../../../components/patient_list.vue";

export default {
    name: "ultrasound_list",
    components: { patientList },
    data() {
        return {
            search: "",
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: 'Ref',value:"patient.ultra_sound_admissions[0].id"},
                { text: "Actions", value: "actions", sortable: false },
            ]
        };
    },
    methods: {
        editItem(item) {
            let ref=item.patient.ultra_sound_admissions.length>0?item.patient.ultra_sound_admissions[0].id:''
            this.$router.push({
                name: "ultrasound_form",
                params: {
                    patient_id: item.patient_id,
                    fullName:item.patient.firstName +" "+ item.patient.lastName,
                    consultation_id: item.id,
                    ref:ref
                },
            });
        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else return "green";
        },
    },
};
</script>
<style scoped>
</style>
