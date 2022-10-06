<template>
    <div class="container">
<!--        <patient_list :service_activity_id="service_activities" :headers="headers" @edit="show_modal" title="PRE SURGERY LIST" :refresh="refresh_list" />-->
        <v-app>
            <v-card class="p-2">
                <v-row>
                    <v-container>
                        <h1 class="title">Pre surgery list</h1>
<!--                        Filter by date-->
<!--                        <date-picker-->
<!--                            v-model="today"-->
<!--                            mode="date"-->
<!--                            :model-config="dateConfig"-->
<!--                            :masks="dateConfig.masks"-->
<!--                            @input="fetch"-->
<!--                        >-->
<!--                            <template v-slot="{ inputValue, inputEvents }">-->
<!--                                <input-->
<!--                                    class="bg-white border px-2 py-1 rounded"-->
<!--                                    :value="inputValue"-->
<!--                                    v-on="inputEvents"-->
<!--                                />-->
<!--                            </template>-->
<!--                        </date-picker>-->
                    </v-container>
                </v-row>
                <v-card-title>
                    Patients
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-card-text>
                    <v-data-table :headers="headers" :items="items" :search="search" :loading="loading" items-per-page="50">
                        <template v-slot:item.actions="{ item }">
                            <v-icon small class="mr-2" @click="show_modal(item)" v-if="item.status ==='RUNNING'">
                                mdi-pencil
                            </v-icon>
                        </template>
                        <template v-slot:item.status="{ item }">
                            <v-chip :color="getColor(item.status)" dark x-small>
                                {{ item.status }}
                            </v-chip>
                        </template>
                        <!--                      <template v-slot:item.from_admission="{ item }">{{ item.id }}</template>-->
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-app>
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
import moment from "moment";
export default {
    name: "pre_surgery_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                { text: "Date in JoyCenter", value: "created_at" },
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
            service_activities:[45],
            modal:false,
            refresh_list:false,
            search: '',
            items: [],
            loading: false,
            search_date:'',
            dateConfig: {
                type: "string",
                mask: "YYYY-MM-DD",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
            today:moment().format("YYYY/MM/DD")
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            this.loading = true;

            axios.post(`/api/v1/patient_system/surgery/pre_surgery_list`,{service_id:this.service_id,service_activity_id:this.service_activity_id,date:this.today}).then(response=>{
                this.loading = false;
                this.consultation_id=response.data.id
                response.data.forEach(d=>{
                    d.created_at=moment(d.created_at).format("MMM Do YY")
                })
                this.items=response.data
            })


        },
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
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else if (status === "CANCELLED") return "red";
            else return "green";
        },
    }
}
</script>

<style scoped>

</style>
