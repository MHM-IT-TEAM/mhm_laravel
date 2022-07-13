<template>
   <div class="container">
       <internal_referral :admission="admission"/>
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
        this.get_admission()
    },
    methods:{
        get_admission(){
            axios.get(`/api/v1/patient_system/admission/admission/${this.$route.params.admission_id}`).then(response=>this.admission=response.data)
        }
    }
}
</script>

<style scoped>


</style>
