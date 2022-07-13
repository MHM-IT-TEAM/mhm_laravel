<template>
  <div class="container">
    <h2 class="text-center">External referral</h2>
    <div class="card shadow">
        <div class="card-body">
            <div class="card-text">
               <div class="table-responsive">
                   <h5>Information about the patient</h5>
                   <table class="table table-sm">
                       <tr>
                           <td>Id</td>
                           <td>FirstName</td>
                           <td>LastName</td>
                           <td>BirthDate</td>
                           <td>Address</td>
                       </tr>
                       <tr>
                        <td>{{patient.id}}</td>
                        <td>{{patient.firstName}}</td>
                        <td>{{patient.lastName}}</td>
                        <td>{{patient.birthDate}}</td>
                        <td>{{patient.adress}}</td>
                       </tr>
                   </table>
               </div>
                <div class="row mt-2">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Refer to</label>
                            <select class="form-control form-control-sm" v-model="formData.medical_center_id" :class="{'is-invalid':$v.formData.medical_center_id.$error}">
                                <option value=""></option>
                                <option v-for="hosp in hospitals" :value="hosp.id">{{hosp.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Date</label>
                            <date-picker
                                v-model=" formData.departure_date"
                                mode="date"
                                :masks="dateConfig.masks"
                                :max-date="new Date()"
                            >
                                <template
                                    v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                >
                                    <input
                                        class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                        :class="{'is-invalid':$v.formData.departure_date.$error}"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                    />
                                </template>
                            </date-picker>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" class="form-control" v-model="formData.departure_time"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Referral Category</label>
                            <select class="form-control" v-model="formData.category" :class="{'is-invalid':$v.formData.category.$error}">
                                <option value=""></option>
                                <option v-for="cate in categories" >{{cate}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Car</label>
                            <select class="form-control" v-model="formData.car_id" :class="{'is-invalid':$v.formData.car_id.$error}">
                                <option value=""></option>
                                <option v-for="car in cars" :value="car.id">{{car.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <label>Condition of the patient</label>
                        <select class="form-control" v-model="formData.patient_condition" :class="{'is-invalid':$v.formData.patient_condition.$error}">
                            <option value="stable">Stable</option>
                            <option value="critical">Critical</option>
                            <option value="dead">Dead</option>
                        </select>
                    </div>
                    <div class="col-2">
                       <div class="form-group">
                           <label>Oxygen needed</label>
                           <select class="form-control" v-model.number="formData.oxygen_needed" :class="{'is-invalid':$v.formData.oxygen_needed.$error}">
                               <option value=""></option>
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                           </select>
                       </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Medical team</label>
                       <input type="text" class="form-control" v-model="formData.medical_team" :class="{'is-invalid':$v.formData.medical_team.$error}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label>Extra supervision needed</label>
                            <select class="form-control" v-model.number="formData.extra_supervision_needed" :class="{'is-invalid':$v.formData.extra_supervision_needed.$error}">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group" v-if="formData.extra_supervision_needed">
                            <label>Extra supervision Details</label>
                            <input type="text" class="form-control" v-model="formData.extra_supervision_details"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Reason</label>
                            <textarea class="form-control" v-model="formData.reason" :class="{'is-invalid':$v.formData.reason.$error}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Driver</label>
                            <textarea class="form-control" v-model="formData.driver" :class="{'is-invalid':$v.formData.driver.$error}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Remark</label>
                            <textarea class="form-control" v-model="formData.remark"/>
                        </div>
                    </div>
                </div>
                <button class=" btn btn-sm btn-primary" @click="submit">Submit</button>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import Patient_information from "../../../../../components/patient_information";
import { validationMixin } from "vuelidate";
import moment from "moment";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "external_referral",
    props:['patient_id','admission_id'],
    components: {Patient_information},
    mixins: [validationMixin],
    created(){
        this.fetch_data()
    },
    data(){
        return{
            hospitals:['HJRA','PSF','Befelatanana','Anosiala','HOMI','OTHER'],
            dateConfig: {
                type: "string",
                mask: "iso",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
            categories:['General','Dental','Obstetrical','Pediatric','Dermatological','Other'],
            cars:['Ambulance','Sprinter','Starex','Isuzu blue','Isuzu-green','Galloper','Other'],
            patient:{firstName:'',lastName:'',birthDate:'',adress:''},
            formData:{
                admission_id:'',
                departure_date:'',
                departure_time:'',
                medical_center_id:'',
                reason:'',
                category:'',
                car_id:'',
                patient_condition:'',
                oxygen_needed:false,
                extra_supervision_needed:'',
                extra_supervision_details: '',
                events:'',
                remark:'',
                driver:'',
                medical_team:'',
                user_id:''
            }
        }
    },
    validations:{
        formData:{
            departure_date:{required},
            medical_center_id:{required},
            category:{required},
            car_id:{required},
            patient_condition:{required},
            medical_team:{required},
            oxygen_needed:{required},
            reason:{required},
            driver:{required},
            extra_supervision_needed:{required},
        }
    },
    methods:{
        submit(){
            this.$v.$touch();
            if (this.$v.$invalid)return
            this.formData.admission_id=this.admission_id
            axios.post('/api/v1/patient_system/external_referral',this.formData).then(response=>{
                if(response.data.success){
                    this.$toast.open({
                        message:'Data saved',
                        position:"top-right"
                    })
                    this.reset_data()
                    this.$v.$reset()
                    this.$emit('success',response.data)
                }
            })
        },
        fetch_data(){
            axios.get(`/api/v1/patient_system/admission/admission/${this.admission_id}`).then(response=>{
                this.patient=response.data.patient
                this.patient.birthDate=moment(this.patient.birthDate).format("MMM Do YY")
                this.formData.admission_id=response.data.id
                this.formData.patient_id=response.data.patient_id
            })
            axios.get('/api/v1/extra/car').then(response=>this.cars=response.data)
            axios.get('/api/v1/extra/medical_center').then(response=>this.hospitals=response.data)
        },
        reset_data(){
            this.formData={
                admission_id:'',
                departure_date:'',
                departure_time:'',
                medical_center_id:'',
                reason:'',
                category:'',
                car_id:'',
                patient_condition:'',
                oxygen_needed:false,
                extra_supervision_needed:'',
                extra_supervision_details: '',
                events:'',
                remark:'',
                driver:'',
                medical_team:'',
                user_id:''
            }
            this.patient={firstName:'',lastName:'',birthDate:'',adress:''}
        }
    }
}
</script>

<style scoped>

</style>
