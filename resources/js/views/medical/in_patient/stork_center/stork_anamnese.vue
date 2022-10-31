<template>
    <anamnese :patient_id="patient_id" :admission_id="admission_id"/>
</template>

<script>
import Anamnese from "../../../../components/anamnese";
export default {
    name: "stork_anamnese",
    components: {Anamnese},
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
