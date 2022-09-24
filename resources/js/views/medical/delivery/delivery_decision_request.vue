<template>
    <div class="container">
        <patient-list  :service_activity_id="service_activities" :headers="headers" @edit="editItem" title="decision request" :refresh="refresh"></patient-list>
        <v-dialog
            v-model="dialog"
            max-width="400"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Decision outcome
                </v-card-title>

                <v-card-text>
                    <v-select :items="options" label="Option" v-model="outcome"></v-select>
                    <v-textarea v-model="reason" dense label="Explanation" />
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="dialog = false"
                    >
                        Disagree
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="process"
                    >
                        Agree
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import PatientList from "../../../components/patient_list";
export default {
    name: "delivery_decision_request",
    components: {PatientList},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Type of admission", value:"admission_type.code", sortable: false },
                { text: "From", value:"from_admission" },
                {text:"nature",value:"service_activity.name"},
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            service_activities:[29],
            outcome:'',
            dialog:false,
            reason_dialog:false,
            reason:'',
            admission:'',
            options:["Stay","dismissed","Ultrasound","CPN"],
            formData:{
                category_id:'',
                service_id:'',
                service_activity_id:'',
                reason_for_transfer:''
            },
            refresh:false
        }
    },
    methods:{
        process(){
            this.formData.user= window.auth.user
            this.formData.remark=this.reason
            switch (this.outcome) {
                case "Stay":
                    this.submit_internal_referal(7,14,25)
                    break;
                case "Ultrasound":
                    this.submit_internal_referal(6,8,11)
                    break;
                case "CPN":
                    this.submit_internal_referal(6,8,13)
                    break;
                case "dismissed":
                    this.dialog=false
            }

        },
        submit_internal_referal(category_id,service_id,service_activity_id){
            this.dialog=false
            this.formData.category_id=category_id
            this.formData.service_id=service_id
            this.formData.service_activity_id=service_activity_id
            this.formData.admission=this.admission
            this.formData.reason_for_transfer=this.reason
            axios.post('/api/v1/patient_system/internal_referral',this.formData).then(response=>{
                // this.accessory.data_submitted=!! response.data.success
                this.refresh=true
                this.formData={
                    category_id:'',
                    service_id:'',
                    service_activity_id:'',
                    reason_for_transfer:''
                }
                this.outcome=''
                this.reason=''
            })
            this.refresh=false
            this.$toast.open("task successful")
        },
        editItem(item) {
            // this.$router.push({
            //     name: "stork_admission",
            //     params: {
            //         admission:item
            //     },
            // });
            this.admission=item
            this.dialog=true
        }
    }
}
</script>

<style scoped>

</style>
