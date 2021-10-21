<template>
    <div class="mt-2">
        <p class="table-title">E.2. External referral</p>
        <div v-if="!accessory.form_submitted">
            <h5 class="subtitle pl-2"> 1) Destination and Transportation</h5>
            <div class="transport border p-2">
                <!--            <span class="font-italic">1-a) Destination</span>-->
                <div class="row">
                    <div class="form-group col-4">
                        <label>Where is the patient to be referred?</label>
                        <select class="form-control" :class="{'is-invalid':$v.formData.medical_center_id.$error}" v-model="formData.medical_center_id">
                            <option v-for="medical_center in accessory.medical_centers" :key="medical_center.id">{{medical_center.name}}</option>
                        </select>
                        <div v-if="$v.formData.medical_center_id.$error" class="invalid-feedback">
                            You must choose a destination!
                        </div>
                        <input type="text" class="form-control mt-2" placeholder="write the place here" :class="{'is-invalid':$v.formData.other_medical_center.$error}"  v-if="formData.medical_center==='Other'" v-model="formData.other_medical_center"/>
                    </div>
                    <div class="form-group col-4">
                        <label>In which Service?</label>
                        <select class="form-control" :class="{'is-invalid':$v.formData.service.$error}" v-model="formData.service">
                            <option v-for="service in accessory.services">{{service}}</option>
                        </select>
                        <div v-if="$v.formData.service.$error" class="invalid-feedback">
                            You must choose a service!
                        </div>
                    </div>
                    <div class="form-group col-4">
                        <label>With which car?</label>
                        <select class="form-control" :class="{'is-invalid':$v.formData.car_id.$error}" v-model="formData.car_id">
                            <option v-for="car in accessory.cars" :value="car.id">{{car.name}}</option>
                        </select>
                        <div v-if="$v.formData.car_id.$error" class="invalid-feedback">
                            You must choose a car!
                        </div>
                    </div>
                </div>
                <!--            <span class="font-italic">1-b) Timeframe</span>-->
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Departure MHM</td>
                        <td>Arrival Destination ({{formData.medical_center}})</td>
                    </tr>
                    <tr>
                        <td><input type="time" class="form-control" v-model="formData.departure_mhm"/></td>
                        <td><input type="time" class="form-control" v-model="formData.arrival_destination"/></td>
                    </tr>
                    <tr>
                        <td>Departure Destination ({{formData.medical_center}})</td>
                        <td>Arrival MHM</td>
                    </tr>
                    <tr>
                        <td><input type="time" class="form-control" v-model="formData.departure_destination"/></td>
                        <td><input type="time" class="form-control" v-model="formData.arrival_mhm"/></td>
                    </tr>
                </table>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Km start</td>
                        <td>Km End</td>
                        <td>Sum</td>
                    </tr>
                    <tr>
                       <td>
                           <input class="form-control" type="number" v-model="formData.km_start"/>
                       </td>
                        <td>
                           <input class="form-control" type="number" v-model="formData.km_end"/>
                       </td>
                        <td>
                            {{sum_km}}
                        </td>

                    </tr>
                </table>
                <!--            <span class="font-italic">1-c) Staff</span>-->
                <table class="table table-sm table-borderless staff-table">
                    <tr class="table-header">
                        <td>Driver</td>
                        <td colspan="3" style="text-align: center; border-left:solid black 0.5px">Medical</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <select class="form-control form-control-sm" :class="{'is-invalid':$v.formData.driver.$error}"  v-model="formData.driver">
                                    <option v-for="driver in employee.drivers" :value="driver.id">{{driver.called}}</option>
                                </select>
<!--                                <v-select-->
<!--                                    v-model="formData.driver"-->
<!--                                    :items="employee.drivers"-->
<!--                                    dense-->
<!--                                    small-chips-->
<!--                                    item-text="called"-->
<!--                                    item-value="id"-->
<!--                                    chips-->
<!--                                    label="Driver"-->
<!--                                ></v-select>-->
                                <div class="invalid-feedback" v-if="$v.formData.driver.$error">
                                    you must enter the driver's name
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-inline">
                                Midwife:
                                <select class="form-control form-control-sm midwife" v-model="formData.midwife">
                                    <option v-for="midwife in employee.midwives" :value="midwife.id">{{midwife.called}}</option>
                                </select>
                                &nbsp/ &nbsp
                                <select class="form-control form-control-sm midwife" v-model="formData.midwife_1">
                                    <option v-for="midwife in employee.midwives" :value="midwife.id">{{midwife.called}}</option>
                                </select>
<!--                                <v-select-->
<!--                                    v-model="formData.midwife"-->
<!--                                    :items="employee.midwives"-->
<!--                                    dense-->
<!--                                    small-chips-->
<!--                                    item-text="called"-->
<!--                                    item-value="id"-->
<!--                                    chips-->
<!--                                    label="Midwife"-->
<!--                                    multiple-->
<!--                                ></v-select>-->
                            </div>
                        </td>
                        <td>
                            <div class="form-inline">
                                Anesthetist:
                                <select class="form-control form-control-sm w-75" v-model="formData.anesthetist">
                                    <option v-for="anesthetist in employee.anesthetists" :value="anesthetist.id">{{anesthetist.called}}</option>
                                </select>
<!--                                <v-select-->
<!--                                    v-model="formData.anesthetist"-->
<!--                                    :items="employee.anesthetists"-->
<!--                                    dense-->
<!--                                    small-chips-->
<!--                                    item-text="called"-->
<!--                                    item-value="id"-->
<!--                                    chips-->
<!--                                    label="Anesthetists"-->
<!--                                    multiple-->
<!--                                ></v-select>-->
                            </div>
                        </td>
                        <td>
                            <div class="form-inline">
                                Nurse:
                                <select class="form-control form-control-sm w-75" v-model="formData.nurse">
                                    <option v-for="nurse in employee.nurses" :value="nurse.id">{{nurse.called}}</option>
                                </select>
<!--                                <v-select-->
<!--                                    v-model="formData.nurse"-->
<!--                                    :items="employee.nurses"-->
<!--                                    dense-->
<!--                                    small-chips-->
<!--                                    item-text="called"-->
<!--                                    item-value="id"-->
<!--                                    chips-->
<!--                                    label="Nurse"-->
<!--                                    multiple-->
<!--                                ></v-select>-->
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <h5 class="subtitle pl-2 mt-2">2) Medical Data</h5>
            <div class="medical-data border">
<!--                <div class="p-2">-->
<!--                    <label>Is the patient alive?</label> &nbsp-->
<!--                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                        <input type="radio" id="customRadioInline1" :class="{'is-invalid':$v.formData.patient_alive.$error}" name="customRadioInline" value="1" class="custom-control-input" v-model.number="formData.patient_alive">-->
<!--                        <label class="custom-control-label" for="customRadioInline1">Yes</label>-->
<!--                    </div>-->
<!--                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                        <input type="radio" id="customRadioInline2" :class="{'is-invalid':$v.formData.patient_alive.$error}" name="customRadioInline" value="0" class="custom-control-input" v-model.number="formData.patient_alive">-->
<!--                        <label class="custom-control-label" for="customRadioInline2">No</label>-->
<!--                    </div>-->
<!--                </div>-->
                <div>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Reason for referral</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div class="form-group">
                                    <textarea class="form-control" :class="{'is-invalid':$v.formData.reason.$error}" v-model="formData.reason"></textarea>
                                    <div v-if="$v.formData.reason.$error" class="invalid-feedback">
                                        You must explain the reason for the referral !
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Condition of the patient at departure</td>
                            <td>O2 needed</td>
                            <td>Extra supervision needed</td>
                            <td>Details</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" :class="{'is-invalid':$v.formData.patient_condition.$error}" v-model="formData.patient_condition">
                                        <option v-for="condition in accessory.patient_conditions">{{condition}}</option>
                                    </select>
                                    <div v-if="$v.formData.patient_condition.$error" class="invalid-feedback">
                                        The condition of the patient must be registered!
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="oxigene1" name="oxigene" class="custom-control-input" value="1" v-model.number="formData.oxigen_needed">
                                    <label class="custom-control-label" for="oxigene1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="oxigene2" name="oxigene" class="custom-control-input" value="0" v-model.number="formData.oxigen_needed">
                                    <label class="custom-control-label" for="oxigene2">No</label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="supervision1" name="supervision" value="1" class="custom-control-input" v-model.number="formData.extra_supervision_needed">
                                    <label class="custom-control-label" for="supervision1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="supervision2" name="supervision" value="0" class="custom-control-input" v-model.number="formData.extra_supervision_needed">
                                    <label class="custom-control-label" for="supervision2">No</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="formData.extra_supervision_details" v-if="formData.extra_supervision_needed===1"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Events on the way</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <textarea class="form-control" v-model="formData.events"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Condition of the patient at discharge</td>
                            <td>Remark</td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" v-model="formData.patient_condition_at_discharge">
                                    <option v-for="condition in accessory.patient_conditions">{{condition}}</option>
                                </select>
                            </td>
                            <td colspan="3">
                                <textarea class="form-control" v-model="formData.remark"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
<!--                <transition name="fade">-->
<!--                    <div v-if="formData.patient_alive===0">-->
<!--                        <table class="table table-borderless table-sm">-->
<!--                            <tr>-->
<!--                                <td>Reason for referral</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td colspan="2">-->
<!--                                    <div class="form-group">-->
<!--                                        <textarea class="form-control" v-model="formData.reason" :class="{'is-invalid':$v.formData.reason.$error}"/>-->
<!--                                        <div class="invalid-feedback" v-if="$v.formData.reason.$error">-->
<!--                                            You must explain the reason for referral-->
<!--                                        </div>-->
<!--                                    </div>-->

<!--                                </td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td style="width:20%">-->
<!--                                    Death certificated printed & signed-->
<!--                                </td>-->
<!--                                <td>Certificate reference</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td>-->
<!--                                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                                        <input type="radio" id="death_certificate1" :class="{'is-invalid':$v.formData.death_certificate_signed.$error}" name="death_certificate" value="1" class="custom-control-input" v-model.number="formData.death_certificate">-->
<!--                                        <label class="custom-control-label"  for="death_certificate1">Yes</label>-->
<!--                                    </div>-->
<!--                                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                                        <input type="radio" id="death_certificate2" :class="{'is-invalid':$v.formData.death_certificate_signed.$error}" name="death_certificate" value="0" class="custom-control-input" v-model.number="formData.death_certificate">-->
<!--                                        <label class="custom-control-label"  for="death_certificate2">No</label>-->
<!--                                    </div>-->
<!--                                    <span class="text-danger" v-if="$v.formData.death_certificate_signed.$error">-->
<!--                                    You must give an answer!-->
<!--                                </span>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <input type="text" class="form-control w-25" v-model="formData.death_certificate_id"/>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td>Remark</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td colspan="2">-->
<!--                                    <textarea class="form-control" v-model="formData.remark"/>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                </transition>-->

                <div class="text-right">
                    <button class="btn btn-sm submit" @click="submit">Submit</button>
                </div>
            </div>
        </div>
        <transition name="fade">
            <div class="card-body" v-if="accessory.form_submitted">
                <v-row justify="center">
                    <h3>Data submitted, Ref: {{accessory.response_ref}}</h3>
                </v-row>
                <v-row justify="center">
                    <v-icon color="success" large> mdi-check-circle</v-icon>
                </v-row>
            </div>
        </transition>


    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    requiredIf,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "external_referral",
    mixins: [validationMixin],
    props:['admission'],
    data(){
        return{
            formData:{
                medical_center_id:'',
                other_medical_center:'',
                service:'',
                reason:'',
                patient_condition:'',
                car_id:'',
                departure_mhm:'',
                departure_destination:'',
                arrival_mhm:'',
                arrival_destination:'',
                km_start:'',
                km_end:'',
                driver:'',
                midwife:'',
                midwife_1:'',
                anesthetist:'',
                nurse:'',
                oxigen_needed:'',
                extra_supervision_needed:'',
                extra_supervision_details:'',
                events:'',
                patient_condition_at_discharge:'',
                remark:''

            },
            accessory:{
                medical_centers:[],
                services:['General','Dental','Obstetrical','Pediatric','Dermatological','Emergency','Neurology','Oncology','Cardiology'],
                patient_conditions:['Good','Fair','Serious','Critical','stable','unstable','dead'],
                cars:[],
                temporary_employee_list:[],
                response_ref:'',
                form_submitted:false
            }
        }
    },
    validations:{
        formData:{
            medical_center_id:{required},
            service:{required:requiredIf(function(formData){return formData.medical_center!=='Other'})},
            car_id:{required},
            reason:{required},
            driver:{required},
            patient_condition:{required:requiredIf(function(formData){return formData.patient_alive===1})},
            other_medical_center:{required:requiredIf(function(formData){return formData.medical_center==='Other'})},
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/extra/employee').then(response=>this.accessory.temporary_employee_list=response.data)
            this.formData.admission_id=this.admission.id
            this.formData.user_id= window.auth.user.id
            await axios.get('/api/v1/extra/car').then(response=>this.accessory.cars=response.data)
            axios.get('/api/v1/extra/medical_center').then(response=>this.accessory.medical_centers=response.data)
        },
        submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            axios.post('/api/v1/patient_system/external_referral',this.formData).then(response=>{
                this.accessory.form_submitted=!!response.data.success
                this.accessory.response_ref=response.data.ref
            })
        }
    },
    computed:{
        employee(){
            if(this.accessory.temporary_employee_list.length>0){
                return{
                    midwives: this.accessory.temporary_employee_list.filter(employee=>employee.employee_occupation_id===1),
                    drivers: this.accessory.temporary_employee_list.filter(employee=>employee.employee_occupation_id===9),
                    anesthetists: this.accessory.temporary_employee_list.filter(employee=>employee.employee_occupation_id===3),
                    nurse: this.accessory.temporary_employee_list.filter(employee=>employee.employee_occupation_id===2),
                }
            }else{
                return{
                    midwives:[],
                    drivers:[],
                    anesthetists:[],
                    nurse:[],
                }
            }
        },
        sum_km(){
          return this.formData.km_end-   this.formData.km_start
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
.subtitle{
    color:#1390C6;
}
.table-header{
    background-color:lightgrey;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.midwife{
    width:40% !important;
}
</style>
