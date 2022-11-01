<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-title title">Comments - ({{$route.params.stork_admission.patient_id}})- {{fullName}}</div>
                <div class="card-text">
                    <div class="form-group">
                        <label>Comment:</label>
                        <textarea class="form-control"  :class="{'is-invalid':$v.formData.comment.$error}" v-model="formData.comment"/>
                    </div>
                    <button class="btn btn-primary btn-sm" @click="submit">Submit</button>
                    <hr>
                    <h4 class="title">Data in the system</h4>
                    <div class="table-responsive mt-4">
                        <table class="table table-sm">
                            <tr>
                                <td>*</td>
                                <td>Date</td>
                                <td>Comment</td>
                                <td>User</td>
                            </tr>
                            <tr v-for="(list,i ) in data_in_system">
                                <td>{{i+1}}</td>
                                <td>{{ list.created_at }}</td>
                                <td>{{ list.comment }}</td>
                                <td>{{ list.user.name }}</td>
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
    name: "stork_comment",
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                comment:''
            },
            data_in_system:[]
        }
    },
    validations:{
        formData:{
            comment:{required},
        }
    },
    created(){
        this.load_data_in_system()
    },
    methods:{
        submit(){
            this.$v.$touch();
            if (this.$v.$invalid)return
            this.formData.stork_admission_id= this.$route.params.stork_admission.id
            this.formData.user_id = window.auth.user.id
            axios.post('/api/v1/patient_system/in_patient/stork/comment',this.formData).then(()=>{
                    this.load_data_in_system()
                    this.formData={
                        comment:''
                    }
                    this.$v.$reset()
                }
            )
        },
        load_data_in_system() {
           axios.get(`/api/v1/patient_system/in_patient/stork/comment/${this.$route.params.stork_admission.id}`).then(response=>{
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
</style>
