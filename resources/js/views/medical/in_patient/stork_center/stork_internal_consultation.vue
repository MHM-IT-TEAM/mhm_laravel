<template>
    <div class="container">
        <v-card>
            <v-card-title>INTERNAL CONSULTATION</v-card-title>
           <v-card-text>
               <patient_information patient_id="10900"/>
               <internal_consultation admission="null"/>
           </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Internal_consultation from "../../../../components/internal_consultation";
import Patient_information from "../../../../components/patient_information";
export default {
    name: "stork_internal_consultation",
    components: {Patient_information, Internal_consultation}
}
</script>

<style scoped>

</style>
