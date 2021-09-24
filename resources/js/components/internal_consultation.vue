<template>
    <div class="mt-2">
<!--        <p class="table-title pl-6">D.1. Internal consultation</p>-->
        <div class="card">
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>
                            <select class="form-control form-control-sm" @change="changeCategory" v-model="formData.category_id">
                                <option value="">Category</option>
                                <option v-for="item in accessory.categories" :value="item.id" >{{item.name}}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm" v-model="formData.service_id" @change="changeService" :disabled="formData.category_id===''">
                                <option value="">Service</option>
                                <option v-for="item in accessory.services" :value="item.id">{{item.name}}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm" v-model="formData.service_activity_id" @change="changeActivity" :disabled="formData.service_id===''">
                                <option value="">Activity</option>
                                <option v-for="item in accessory.service_activities" :value="item.id" :disabled="admission.service_activity_id===item.id">{{item.name}}</option>
                            </select>
                            <span v-if="$v.formData.service_activity_id.$error" class="text-white bg-danger">you have to choose here</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <textarea class="form-control" v-model="formData.reason_for_consultation" placeholder="reason for the consultation"></textarea>
                            <span v-if="$v.formData.reason_for_consultation.$error" class="text-white bg-danger">you have to explain why you needed additional consultation</span>
                        </td>
                    </tr>
                </table>
                <div class="text-right">
                    <button class="btn btn-sm submit" @click="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "internal_consultation",
    props:['admission'],
    mixins: [validationMixin],
    data(){
        return{
            admission_id:'',
            formData:{
                admission:null,
                category_id:'',
                service_id:'',
                service_activity_id:'',
                reason_for_consultation:''
            },
            accessory:{
                categories:[],
                services:[],
                service_activities: []
            }
        }
    },
    validations:{
        formData:{
            service_activity_id:{required},
            reason_for_consultation:{required}
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            axios.get('/api/v1/patient_system/system/category').then(response=>this.accessory.categories=response.data)
            this.formData.admission=this.admission
        },
        async changeCategory(){
            this.accessory.service_activities=[]
            this.accessory.services=[]
            if(this.formData.category_id!==""){
                await axios.get(`/api/v1/patient_system/system/service/category/${this.formData.category_id}`).then(response=>this.accessory.services=response.data)
            }
        },
        async changeService() {
            this.accessory.service_activities=[]
            if(this.formData.service_id!==""){
                axios.get(`/api/v1/patient_system/system/serviceActivity/service/${this.formData.service_id}`).then(response=>{
                    this.accessory.service_activities=response.data
                })
            }
        },
        async changeActivity(){
            let patient_category
            if(this.admission.patient.patient_category_id===null){
                patient_category= this.admission.patient.sector===false?0:1
            }else patient_category=this.admission.patient.patient_category_id
            await axios.get(`/api/v1/patient_system/admission/activity_price/${this.formData.service_activity_id}/${patient_category}`).then(response=>{
                if(response.data.length>0){
                    this.formData.admission_care_details=response.data[0]
                }
            })
        },
        submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            axios.post('/api/v1/patient_system/internal_referral',this.formData).then(response=>{
                console.log(response.data)
            })
        }
    }

}
</script>

<style scoped>
.table-title{
    background-color: #1390C6;
    color:white;
    font-size: 14px !important;
    font-weight:bold;
}
.submit{
    background-color: #e47911;
    position: relative;
    color: white;
    width: 55px;
    height: 30px;
    text-align: center !important;
    vertical-align: middle !important;
    padding: 0;
}
</style>
