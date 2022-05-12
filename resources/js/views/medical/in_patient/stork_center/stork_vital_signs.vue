<template>
    <vital_signs :patient_id="patient_id" :admission_id="admission_id"/>
</template>

<script>
import Vital_signs from "../../../../components/vital_signs";
export default {
    name: "stork_vital_signs",
    components: {Vital_signs},
    data(){
        return{
            admission_id:'',
            patient_id:''
        }
    },
    created(){
        this.admission_id=this.$route.params.admission_id ?? null
        this.patient_id=this.$route.params.stork_admission.patient_id ?? null
    }
}
</script>

<style scoped>

</style>
