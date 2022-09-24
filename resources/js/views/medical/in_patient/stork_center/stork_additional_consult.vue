<template>
    <div class="container">
        <v-card>
            <v-card-title>INTERNAL CONSULTATION</v-card-title>
            <v-card-text>
                <patient_information :patient_id="patient_id"/>
                <additional_consultation :admission="admission"/>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Additional_consultation from "../../../../components/additional_consultation";
import Patient_information from "../../../../components/patient_information";
export default {
    name: "stork_additional_consult",
    components: {Patient_information, Additional_consultation},
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
