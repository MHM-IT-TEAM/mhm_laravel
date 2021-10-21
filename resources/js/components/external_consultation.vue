<template>
    <div>
        <p class="table-title">D.2. External consultation</p>
        <div v-if="!accessory.form_submitted">
            <div class="destination">
                <h5 class="subtitle pl-2"> 1) Destination and Transportation</h5>
                <div class="row">
                    <div class="form-group col-4">
                        <label>Where?</label>
                        <select class="form-control" :class="{'is-invalid':$v.formData.medical_center_id.$error}" v-model="formData.medical_center_id">
                            <option v-for="medical_center in accessory.medical_centers" :value="medical_center.id">{{medical_center.name}}</option>
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
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Transport needed?</label><br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" :class="{'is-invalid':$v.formData.transport_needed.$error}" name="customRadioInline" value="1" class="custom-control-input" v-model.number="formData.transport_needed">
                                <label class="custom-control-label" for="customRadioInline1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" :class="{'is-invalid':$v.formData.transport_needed.$error}" name="customRadioInline" value="0" class="custom-control-input" v-model.number="formData.transport_needed">
                                <label class="custom-control-label" for="customRadioInline2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4" v-if="formData.transport_needed===1">
                        <div class="form-group">
                            <label>with which car?</label>
                            <select class="form-control" :class="{'is-invalid':$v.formData.car_id.$error}" v-model="formData.car_id">
                                <option v-for="car in accessory.cars" :value="car.id">{{car.name}}</option>
                            </select>
                            <div v-if="$v.formData.car_id.$error" class="invalid-feedback">
                                You must choose a car!
                            </div>
                        </div>
                    </div>

                </div>
                <table class="table table-sm table-borderless" v-if="formData.transport_needed===1">
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
            </div>
            <div class="medical">
                <h5 class="subtitle pl-2"> 2) Medical data</h5>
                <div class="form-group">
                    <label>reason for external consultation</label>
                    <textarea class="form-control" v-model="formData.reason" :class="{'is-invalid':$v.formData.reason.$error}"></textarea>
                    <div v-if="$v.formData.reason.$error" class="invalid-feedback">
                        You must explain the reason for the external consultation !
                    </div>
                </div>
                <div class="form-group">
                    <label>Remark</label>
                    <textarea class="form-control" v-model="formData.remark"></textarea>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-sm submit" @click="submit">Submit</button>
            </div>
        </div>
        <transition nae="fade">
            <div v-if="accessory.form_submitted">
                <div class="card-body" v-if="accessory.form_submitted">
                    <v-row justify="center">
                        <h3>Data submitted</h3>
                    </v-row>
                    <v-row justify="center">
                        <v-icon color="success" large> mdi-check-circle</v-icon>
                    </v-row>
                </div>
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
    name: "external_consultation",
    mixins: [validationMixin],
    props:['admission'],
    data(){
        return{
            formData:{
                medical_center_id:'',
                service:'',
                transport_needed:'',
                car_id:'',
                km_start:'',
                km_end:'',
                reason:'',
                remark:''
            },
            accessory:{
                medical_centers:[],
                cars:[],
                services:['General','Dental','Obstetrical','Pediatric','Dermatological','Emergency','Neurology','Oncology','Cardiology'],
                form_submitted:false

            }
        }
    },
    validations:{
        formData:{
            medical_center_id:{required},
            service:{required},
            car_id:{required:requiredIf((formData)=>formData.transport_needed===1)},
            transport_needed:{required},
            reason:{required}
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            this.formData.admission_id=this.admission.id
            this.formData.user_id= window.auth.user.id
            await axios.get('/api/v1/extra/car').then(response=>this.accessory.cars=response.data)
            axios.get('/api/v1/extra/medical_center').then(response=>this.accessory.medical_centers=response.data)
        },
        async submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            axios.post('/api/v1/patient_system/external_consultation',this.formData).then(response=>this.accessory.form_submitted = response.data.success)
        }
    },
    computed:{
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
</style>
