<template>
<div class="container">
    <patient-list :headers="headers" @edit="editItem" :service_activity_id="service_activities" title="milk program"></patient-list>
</div>
</template>

<script>
import PatientList from "../../../../components/patient_list.vue";
export default {
    name: "baby_milk_pro_list",
    components: { PatientList },
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
            service_activities:[59]
        }
    },
    methods:{
        editItem(item) {
            //check if the patient is already register in the milk program table
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/milkPro/patient/${item.patient_id}`).then(response=>{
                if(response.data.milk_program_admission===null){
                    this.$router.push({
                        name: "milk_pro_admission",
                        params: {
                            patient_id: item.patient_id,
                            admission_id:item.id
                        },
                    });

                }
                else{
                    this.$router.push({
                        name: "milk_pro_followup",
                        params: {
                            patient_id: item.patient_id,
                            milk_pro_admission:response.data.milk_program_admission
                        },
                    });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
