<template>
    <div class="container w-75">
        <patient_list :service_id="34" :service_activity_id="45" :headers="headers" @edit="show_modal" title="PRE SURGERY LIST" :refresh="refresh_list" />
        <v-dialog
            v-model="modal"
            max-width="500"
        >
            <v-card>
                <v-card-title class="text-h5">
                   Is the patient good for surgery?
                </v-card-title>
                    <div class="form-group p-4">
                        <select class="form-control form-control-sm" v-model.number="good_for_surgery">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group p-4" v-if="!good_for_surgery">
                        <v-textarea label="Reason for Cancellation" v-model="formData.reason_for_cancellation"/>
                    </div>
                <v-card-text>

                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="modal=false"
                    >
                        Disagree
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="process_option"
                    >
                        Agree
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import Patient_list from "../../../components/patient_list";
export default {
    name: "pre_surgery_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text:"Diagnostic", value: "remark" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            good_for_surgery:true,
            chosen_patient:null,
            formData:{
                reason_for_cancellation:'',
                admission_id:'',
                patient_id:''
            },
            modal:false,
            refresh_list:false
        }
    },
    methods:{
        show_modal(item){
            this.modal=true
            this.chosen_patient=item
        },
        async process_option() {
            if(this.good_for_surgery){
                this.$router.push({
                    name: "pre_surgery_form",
                    params: {
                        admission:this.chosen_patient
                    },
                });
            }else{
                this.formData.admission_id=this.chosen_patient.id
                this.formData.patient_id=this.chosen_patient.patient_id
                await axios.post('/api/v1/patient_system/surgery/cancel',this.formData).then(response=>{
                    this.$toast.success("the patient is cancelled")
                })
                this.refresh_list=true
            }

        },
    }
}
</script>

<style scoped>

</style>
