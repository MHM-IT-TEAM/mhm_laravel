<template>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title title">
                History of Wound care - ({{$route.params.stork_admission.patient_id}})- {{fullName}}
            </div>
            <div class="card-text">
                <div class="form-group">
                    <label>Write here</label>
                    <textarea class="form-control" :class="{'is-invalid':$v.formData.$error}" v-model="formData.description"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="submit">Submit</button>
                <h4 class="title">Data in the system</h4>
                <div class="table-responsive mt-4">
                    <table class="table table-sm">
                        <tr>
                            <td>Date</td>
                            <td>Description</td>
                        </tr>
                        <tr v-for="list in data_in_system">
                            <td>{{ list.created_at }}</td>
                            <td>{{ list.description }}</td>
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
    name: "stork_wound_care",
    mixins: [validationMixin],
    data(){
        return{
            data_in_system:[],
            formData:{
                stork_admission_id:'',
                description:""
            }
        }
    },
    validations:{
        formData:{
            description:{required}
        }
    },
    created(){
        this.load_data_in_system()
    },
    methods:{
        load_data_in_system() {
            axios.get(`/api/v1/patient_system/in_patient/stork/show_wound_care/${this.$route.params.admission_id}`).then(response=>{
                this.data_in_system=response.data
                this.data_in_system.forEach(data=>{
                    data.created_at= this.date_format(data.created_at)
                })
            })
        },
        submit(){
            this.$v.$touch();
            if (this.$v.$invalid)return
            this.formData.stork_admission_id= this.$route.params.admission_id
            axios.post('/api/v1/patient_system/in_patient/stork/store_wound_care',this.formData).then(()=>{
                    this.load_data_in_system()
                    this.formData={
                        stork_admission_id:'',
                        description:""
                    }
                    this.$v.$reset()
                }
            )
        },
        date_format(date){
            return moment(date).format("MMM Do YY");
        }
    },
    computed:{
        fullName(){
            return this.$route.params.stork_admission.patient.firstName +" "+ this.$route.params.stork_admission.patient.lastName
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
