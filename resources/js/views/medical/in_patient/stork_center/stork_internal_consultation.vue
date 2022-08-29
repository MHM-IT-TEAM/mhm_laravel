<template>
    <div class="container">
        <v-card>
            <v-card-title>INTERNAL CONSULTATION</v-card-title>
           <v-card-text>
               <patient_information :patient_id="patient_id"/>
               <internal_consultation :admission="admission"/>
           </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Internal_consultation from "../../../../components/internal_consultation";
import Patient_information from "../../../../components/patient_information";
export default {
    name: "stork_internal_consultation",
    components: {Patient_information, Internal_consultation},
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
