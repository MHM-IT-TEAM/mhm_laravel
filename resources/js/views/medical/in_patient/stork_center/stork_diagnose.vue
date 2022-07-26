<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-title title">History of Diagnose - ({{$route.params.stork_admission.patient_id}})- {{fullName}}</div>
                <div class="card-text">
                    <div class="form-group diagnose">
                        <label>Type of the diagnose:</label>
                       <select class="form-control form-control-sm" :class="{'is-invalid':$v.formData.type.$error}" v-model="formData.type">
                           <option value="suspicion">Suspicion</option>
                           <option value="Confirmed">Confirmed</option>
                           <option value="Exclusion">Exclusion</option>
                       </select>
                    </div>
                    <div class="form-group">
                        <label>Diagnose:</label>
                        <textarea class="form-control"  :class="{'is-invalid':$v.formData.diagnose.$error}" v-model="formData.diagnose"/>
                    </div>
                    <button class="btn btn-primary btn-sm" @click="submit">Submit</button>
                    <hr>
                    <h4 class="title">Data in the system</h4>
                    <div class="table-responsive mt-4">
                        <table class="table table-sm">
                            <tr>
                                <td>Date</td>
                                <td>Diagnose</td>
                                <td>Type</td>
                            </tr>
                            <tr v-for="list in data_in_system">
                                <td>{{ list.created_at }}</td>
                                <td>{{ list.diagnose }}</td>
                                <td>{{ list.type }}</td>
                            </tr>
                        </table>
                    </div>
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
    name: "stork_diagnose",
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                type:'',
                diagnose:''
            },
            data_in_system:[]
        }
    },
    validations:{
        formData:{
            type:{required},
            diagnose:{required},
        }
    },
    created(){
        this.load_data_in_system()
    },
    methods:{
        submit(){
            this.$v.$touch();
            if (this.$v.$invalid)return
            this.formData.stork_admission_id= this.$route.params.admission_id
            axios.post('/api/v1/patient_system/in_patient/stork/store_diagnose',this.formData).then(()=>{
                    this.load_data_in_system()
                    this.formData={
                        type:'',
                        diagnose:''
                    }
                    this.$v.$reset()
                }
            )
        },
        load_data_in_system() {
           axios.get(`/api/v1/patient_system/in_patient/stork/show_diagnose/${this.$route.params.admission_id}`).then(response=>{
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
.title{
    font-weight: bold;
    color:#1390c6;
}
.diagnose{
    width: 30%;
}
</style>
