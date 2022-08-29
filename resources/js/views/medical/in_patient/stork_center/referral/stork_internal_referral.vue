<template>
   <div class="container">
       <internal_referral :admission="admission" @form_submitted="update_stork_admission"/>
   </div>
</template>

<script>

import Internal_referral from "../../../../../components/internal_referral";
export default {
    name: "stork_internal_referral",
    components: {Internal_referral},
    data(){
        return{
            admission:null
        }
    },
    created(){
       this.admission=this.$route.params.admission
        this.admission.patient=this.$route.params.stork_admission.patient
    },
    methods:{
        update_stork_admission(admission){
            axios.post(`/api/v1/patient_system/in_patient/stork/update_admission_by_ir`,admission)
            this.$router.push({name:'stork_patient_list'})
        }
    }
}
</script>

<style scoped>


</style>
