<template>
<div class="container">
    <v-card>
        <v-card-title>EXTERNAL CONSULTATION</v-card-title>
        <v-card-text>
            <patient_information patient_id="10900"/>
            <external_consultation/>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import External_consultation from "../../../../components/external_consultation";
export default {
    name: "stork_external_consultation",
    components: {External_consultation, Patient_information}
}
</script>

<style scoped>

</style>
