<template>
<div class="container">
    <v-card>
        <v-card-text>
            <h1 class="title">VITAL SIGNS</h1>
            <patient_information patient_id="10900"/>
            <p class="table-title"><v-icon class="text-blue">mdi-account-circle</v-icon>  &nbsp B) Today's diagnostic</p>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import Patient_information from "./patient_information";
export default {
    name: "vital_signs",
    components: {Patient_information},
    props:['patient_id'],
    data(){
        return{

        }
    }
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
.table-title{
    background-color: #1390C6;
    color:white;
}
</style>
