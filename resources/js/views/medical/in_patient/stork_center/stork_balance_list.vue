<template>
    <div class="container-fluid">
        <div class="d-inline mb-2">
            List of Balance:
            <span class="font-weight-bold"> ({{$route.params.stork_admission.patient.id}})-{{$route.params.stork_admission.patient.firstName}} {{$route.params.stork_admission.patient.lastName}}</span>
            <v-btn class="float-right" x-small dark color="purple" @click="dialog=true">New Balance</v-btn>
        </div>
        <div class="table-responsive">
            <table class="table table-sm">
                <tr>
                    <td>Date</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
                <tr v-for="row in balance_list">
                    <td>{{row.created_at}}</td>
                    <td>{{row.status}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" @click="process(row)" v-if="row.status==='RUNNING'">Process</a>
<!--                                <a class="dropdown-item" href="#" @click="close_exam(adm)" v-if="adm.status==='open'">Close exam</a>-->
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <v-dialog
            v-model="dialog"
        >
            <v-card>
                <v-card-title class="text-h5">
                   Balance Sheet
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control-sm" v-model="formData.date_start"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Start Time</label>
                                <input type="time" class="form-control-sm" v-model="formData.time_start"/>
                            </div>
                        </div>
                    </div>
                    <v-btn class="mb-2" x-small dark color="purple" @click="create_balance">Create</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: "stork_balance_list",
    data(){
        return{
            stork_admission:null,
            dialog:false,
            balance_list:[],
            formData:{
                stork_admission_id:'',
                date_start:'',
                time_start:'',
                status:'RUNNING'
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            //get all previous data
            axios.get(`/api/v1/patient_system/in_patient/stork/balance/stork_admission_id/${this.$route.params.stork_admission.id}`).then(response=>{
                this.balance_list=response.data
            })
        },
        create_balance(){
            this.formData.stork_admission_id=this.$route.params.stork_admission.id
            axios.post("/api/v1/patient_system/in_patient/stork/balance",this.formData).then(response=>{
                this.balance_list=response.data
            })
        },
        process(item){
            console.log(item)
            this.$router.push({name:'stork_diagnostic_balance',params:{balance_sheet:item}})
        }
    }
}
</script>

<style scoped>

</style>
