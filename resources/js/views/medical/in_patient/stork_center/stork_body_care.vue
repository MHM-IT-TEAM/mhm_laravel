<template>
    <div class="container">
        <h2 class="title">Action Form - ({{$route.params.stork_admission.patient_id}})- {{fullName}}</h2>
        <stork_actions_form action_type="body_care" :stork_admission_id="$route.params.stork_admission.id"/>
    </div>
</template>

<script>
import Stork_actions_form from "./stork_actions_form";
export default {
    name: "stork_body_care",
    components: {Stork_actions_form},
    computed:{
        fullName(){
            return this.$route.params.stork_admission.patient.firstName +" "+ this.$route.params.stork_admission.patient.lastName
        }
    }
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
</style>
