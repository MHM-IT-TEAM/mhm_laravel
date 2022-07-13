<template>
    <div class="container-fluid vh-100">
    <div class="d-inline mb-2">
        List of Ultrasound admission:
        <span class="font-weight-bold"> ({{patient.id}})-{{patient.firstName}} {{patient.lastName}}</span>
        <v-btn class="float-right" x-small dark color="purple" @click="dialog=true">New Admission</v-btn>
    </div>
    <div class="table-responsive mt-2">
        <table class="table">
            <thead>
            <th>Year-month</th>
            <th>Ultrasound ID</th>
            <th>Status</th>
            <th>Action</th>
            </thead>
            <tbody>
            <tr v-for="adm in ultrasound_admission_list">
                <td>{{moment(adm.created_at).format("YYYY-MM")}}</td>
                <td>{{adm.id}}</td>
                <td>
                    <v-chip
                        class="ma-2"
                        label
                        color="orange"
                       v-if="adm.status==='open'"
                    >
                        {{adm.status}}
                    </v-chip>
                    <v-chip
                        class="ma-2"
                        label
                        color="grey"
                        v-if="adm.status==='closed'"
                    >
                        {{adm.status}}
                    </v-chip>
                </td>
                <td>
<!--                    <v-btn x-small @click="process(adm)" :disabled="adm.status==='closed'">View/process</v-btn>-->
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" @click="process(adm)" v-if="adm.status==='open'">Process</a>
                            <a class="dropdown-item" href="#" @click="close_exam(adm)" v-if="adm.status==='open'">Close exam</a>
                            <a class="dropdown-item" href="#" @click="view_history(adm)" v-if="adm.status==='closed'">View</a>
                            <a class="dropdown-item" href="#">Delete exam</a>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
        <v-dialog
            v-model="dialog"
        >
            <v-card>
                <v-card-title class="text-h5">
                    ({{patient.id}})-{{patient.firstName}} {{patient.lastName}}
                </v-card-title>

                <v-card-text>
                    <ultrasound_admission_form :admission="$route.params.admission" @success="reload_list"/>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="ultrasound_type_dialog"
            max-width="400"
        >
            <v-card>
                <v-card-title class="text">
                    Type of examination
                </v-card-title>
                <v-card-text>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control form-control-sm" v-model="formData.type_of_ultrasound">
                            <option value="routine">Routine</option>
                            <option value="extra">Extra</option>
                        </select>
                    </div>
                    <div class="form-group mt-2" v-if="formData.type_of_ultrasound==='extra'">
                        <label>Reason for extra checkup</label>
                        <textarea class="form-control form-control-sm" v-model="formData.extra_checkup_reason"/>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2" :disabled="formData.type_of_ultrasound ===''" @click="continue_to_exam">Continue</button>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import moment from 'moment';
import Ultrasound_admission_form from "./ultrasound_admission_form";
export default {
    name: "patient_ultrasound_admission_list",
    components: {Ultrasound_admission_form},
    data(){
        return{
            patient:{},
            ultrasound_admission_list:[],
            dialog:false,
            ultrasound_type_dialog:false,
            closeOnContentClick:true,
            process_options:[
                {title:'process'},
                {title:'Close exam'},
                {title:'Delete exam'},
            ],
            formData:{
                extra_checkup_reason:'',
                type_of_ultrasound:''
            },
            temp_data:null
        }
    },
    created(){
        this.patient=this.$route.params.admission.patient
        this.boot_list()

    },
    methods:{
        process(admission){
            this.ultrasound_type_dialog=true
            this.temp_data=admission
            // this.$router.push({name:'ultrasound_exam_crud',params:{ultrasound_admission:admission,patient:this.patient}})
            // this.continue_to_exam(admission,this.formData)
        },
        continue_to_exam(){
            this.temp_data.type_of_ultrasound_data= this.formData
            this.$router.push({name:'ultrasound_exam_crud',params:{ultrasound_admission:this.temp_data,patient:this.patient,admission_id:this.$route.params.admission.id}})

        },
        boot_list(){
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/admission_list/${this.patient.id}`).then(response=>{
                this.ultrasound_admission_list=response.data
            })
        },
        reload_list(){
            this.dialog=false
            this.boot_list()
        },
        close_exam(admission){
            axios.put(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/close_exam/${admission.id}`).then(response=>{
                if(response.data.success) this.boot_list()
            })
        },
        view_history(admission){
            this.temp_data=admission
            this.$router.push({name:'ultrasound_exam_crud',params:{ultrasound_admission:this.temp_data,patient:this.patient}})
        }

    }
}
</script>

<style scoped>

</style>
