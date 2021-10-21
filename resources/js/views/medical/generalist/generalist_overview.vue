<template>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-sm border">
                <thead>
                    <th>Admission Id</th>
                    <th>Date</th>
                    <th>Responsible</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr v-for="line in clean_medical_history_list">
                        <td>{{line.id}}</td>
                        <td>
                            {{moment(line.created_at).format("DD-MM-YYYY")}}
                        </td>
                        <td>{{line.generalist.responsible}}</td>
                        <td>
                            <v-btn x-small @click="process(line.id)">
                                <v-icon>mdi-door-open</v-icon>
                            </v-btn>
                        </td>
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
        },
        process(id){
            window.open(`/generalist/overview/${id}`)
        }
    },
    computed:{
        clean_medical_history_list(){
            return this.medical_history.filter(history=>{
                return history.generalist !==null
            })
        }
    }

}
</script>

<style scoped>

</style>
