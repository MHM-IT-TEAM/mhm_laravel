<template>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-sm border">
                <thead>
                    <th>Date</th>
                    <th>Diag Code</th>
                    <th>Diagnose</th>
                    <th>Complaint</th>
                    <th>Finding</th>
                    <th>Medication</th>
                    <th>Responsible</th>
                </thead>
                <tbody>
                    <tr v-for="line in medical_history">
                        <td>
                            {{moment(line.created_at).format("DD-MM-YYYY")}}
                        </td>
                        <td>{{line.generalist.diag_code}}</td>
                        <td>{{line.generalist.diagnose}}</td>
                        <td>{{line.generalist.complaint}}</td>
                        <td>{{line.generalist.finding}}</td>
                        <td>
                            <button class="btn btn-sm" @click="showMedication(line.grace_csb_transaction)">
                                <font-awesome-icon icon="eye"/>
                            </button>
                        </td>
                        <td>{{line.generalist.responsible}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <v-dialog
            v-model="medication_dialog"
            max-width="800"
        >
            <v-card>
                <v-card-title class="text-h5">
                   Medications
                </v-card-title>
                <v-card-text>
                    <table class="table">
                        <thead>
                            <th>Drug</th>
                            <th>Morning</th>
                            <th>Noon</th>
                            <th>Evening</th>
                            <th>Given</th>
                        </thead>
                        <tbody>
                            <tr v-for="line in medication">
                                <td>{{line.item.description}}</td>
                                <td>{{line.breakfast}}</td>
                                <td>{{line.lunch}}</td>
                                <td>{{line.dinner}}</td>
                                <td>{{line.to_give}}</td>
                            </tr>
                        </tbody>
                    </table>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import moment from "moment"
export default {
    name: "generalist_overview",
    props:['patient_id'],
    data(){
        return{
            medical_history:[],
            medication:[],
            medication_dialog:false
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get(`/api/v1/patient_system/out_patient/generalist/consultation/${this.patient_id}`).then(response=>this.medical_history=response.data)
        },
        showMedication(medication){
            this.medication_dialog=true
            if(medication !==null){
                this.medication=medication.grace_csb_transaction_detail
            }
        }
    }
}
</script>

<style scoped>

</style>
