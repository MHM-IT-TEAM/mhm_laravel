<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title title">Weekly measurments - ({{$route.params.stork_admission.patient_id}})- {{fullName}}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Head</label>
                            <input type="number" class="form-control form-control-sm" v-model="formData.head">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Arm</label>
                            <input type="number" class="form-control form-control-sm" v-model="formData.arm">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Chest</label>
                            <input type="number" class="form-control form-control-sm" v-model="formData.chest">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Length</label>
                            <input type="number" class="form-control form-control-sm" v-model="formData.length">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Ear to ear</label>
                            <input type="number" class="form-control form-control-sm" v-model="formData.ear_to_ear">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-sm" @click="submit">Submit</button>
                    </div>
                </div>
                <hr>
                <h4 class="title">Data in the system</h4>
                <div class="table-responsive mt-4">
                    <table class="table table-sm">
                        <tr>
                            <td>Date</td>
                            <td>Head</td>
                            <td>Arm</td>
                            <td>Chest</td>
                            <td>Length</td>
                            <td>Ear to ear</td>
                            <td>User</td>
                        </tr>
                        <tr v-for="(list,i ) in data_in_system">
                            <td>{{ list.created_at }}</td>
                            <td>{{ list.head }}</td>
                            <td>{{ list.arm }}</td>
                            <td>{{ list.chest }}</td>
                            <td>{{ list.length }}</td>
                            <td>{{ list.ear_to_ear }}</td>
                            <td>{{list.user}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import moment from "moment";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "stork_weekly_measurments",
    mixins: [validationMixin],
    data(){
        return{
            formData:{
               head:'',
                arm:'',
                chest:'',
                length:'',
                ear_to_ear:''
            },
            data_in_system:[]
        }
    },
    created(){
        this.load_data_in_system()
    },
    methods:{
        submit(){
            this.formData.stork_admission_id= this.$route.params.admission_id
            this.formData.user = window.auth.user.name
            axios.post('/api/v1/patient_system/in_patient/stork/weekly_measurments',this.formData).then(()=>{
                    this.load_data_in_system()
                    this.formData={
                        head:'',
                        arm:'',
                        chest:'',
                        length:'',
                        ear_to_ear:''
                    }
                }
            )
        },
        load_data_in_system() {
            axios.get(`/api/v1/patient_system/in_patient/stork/weekly_measurments/show_list/${this.$route.params.admission_id}`).then(response=>{
                this.data_in_system=response.data
                this.data_in_system.forEach(data=>{
                    data.created_at= this.date_format(data.created_at)
                })
            })
        },
        date_format(date){
            return moment(date).format("MMM Do YY");
        },
        null_to_str(str){
            return str?str:""
        }
    },
    computed:{
        fullName(){
            return this.null_to_str(this.$route.params.stork_admission.patient.firstName) +" "+ this.null_to_str(this.$route.params.stork_admission.patient.lastName)
        }
    }
}
</script>

<style scoped>

</style>
