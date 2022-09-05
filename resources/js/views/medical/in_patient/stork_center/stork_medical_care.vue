<template>
    <div class="container">
        <h2 class="title">Action Form - ({{$route.params.stork_admission.patient_id}})- {{fullName}}</h2>
        <stork_actions_form action_type="medical_care" :stork_admission_id="$route.params.stork_admission.id" :category="patient_adult_or_baby"/>

    </div>
</template>

<script>
import Stork_actions_form from "./stork_actions_form";
import moment from "moment";
export default {
    name: "stork_medical_care",
    components: {Stork_actions_form},
    computed:{
        fullName(){
            return this.$route.params.stork_admission.patient.firstName +" "+ this.$route.params.stork_admission.patient.lastName
        },
        patient_adult_or_baby(){
            let birthday= moment(this.$route.params.stork_admission.patient.birthDate)
            return moment().diff(birthday,"year")<14? "adult":"baby"//it is reversed
        },
    }
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
</style>
