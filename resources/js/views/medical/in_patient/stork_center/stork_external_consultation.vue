<template>
<div class="container">
    <v-card>
        <v-card-title>EXTERNAL CONSULTATION</v-card-title>
        <v-card-text>
            <patient_information :patient_id="patient_id"/>
            <external_consultation :admission="admission"/>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import External_consultation from "../../../../components/external_consultation";
export default {
    name: "stork_external_consultation",
    components: {External_consultation, Patient_information},
    data(){
        return{
            patient_id:'',
            admission:null
        }
    },
    created(){
        this.patient_id=this.$route.params.stork_admission.patient_id
        this.admission=this.$route.params.stork_admission.admission
    }
}
</script>

<style scoped>

</style>
