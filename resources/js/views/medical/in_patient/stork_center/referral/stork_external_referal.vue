<template>
    <div class="container">
        <external_referral :patient_id="$route.params.stork_admission.patient_id" :admission_id="$route.params.stork_admission.admission_id" @success="update_stork_admission"/>
    </div>
</template>

<script>
import External_referral from "./external_referral";
export default {
    name: "stork_external_referal",
    components: {External_referral},
    created(){
    },
    methods:{
        update_stork_admission(src){
            axios.post('/api/v1/patient_system/in_patient/stork/ext_ref_update_stork_admission',src.data)
        }
    }
}
</script>

<style scoped>

</style>
