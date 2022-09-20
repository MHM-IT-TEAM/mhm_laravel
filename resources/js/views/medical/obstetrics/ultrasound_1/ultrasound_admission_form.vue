<template>
    <v-app>
        <div class="container-fluid vh-100">
            <v-card>
                <v-card-title>
                    Ultrasound Admission
                </v-card-title>
                <v-card-text>
                    <patient_information :patient_id="$route.params.admission.patient_id"/>
                    <p class="title"><v-icon class="text-white">mdi-stethoscope</v-icon> B) Medical Data</p>
                    <div class="form-group w-25">
                        <label>Is the patient pregnant</label>
                        <select class="form-control form-control-sm" v-model.number="formData.is_patient_pregnant">
                            <option value="0">Negativ</option>
                            <option value="1">positiv</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="formData.is_patient_pregnant===0">
                        <label>Remark:</label>
                        <textarea class="form-control" v-model="formData.remark_when_patient_not_pregnant">

                    </textarea>
                    </div>
                    <div v-if="formData.is_patient_pregnant">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Date of last period</label>
                                <date-picker
                                    v-model=" formData.last_period_date"
                                    mode="date"
                                    :masks="accessory.dateConfig.masks"
                                    :max-date="new Date()"
                                    @input="get_calculated_ga(formData.last_period_date)"
                                    v-if="!formData.unknown_lpd"
                                    ref="last_period_date"
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
                                            :class="{'is-invalid':$v.formData.last_period_date.$error}"
                                            :value="inputValue"
                                            v-on="inputEvents"
                                        />
                                    </template>
                                </date-picker>
                            </div>
                            <div class="form-group col-6 mt-8">
                                <label>
                                    Check here if the date of last period is unknown
                                </label>
                                <input  type="checkbox" v-model="formData.unknown_lpd">
                            </div>
                        </div>
                        <h6>Gestational age</h6>
                        <table class="table table-sm">
                            <tr>
                                <td :class="{'bg-success':formData.edd_method==='calc'}">Calculated</td>
                                <td :class="{'bg-success':formData.edd_method==='us'}">Ultrasound</td>
                                <td :class="{'bg-success':formData.edd_method==='corrected'}">Corrected</td>
                            </tr>
                            <tr>
                                <td>
                                    <gestational-age v-model="formData.calculated_ga"/>
                                </td>
                                <td>
                                    <gestational-age v-model="formData.ultrasound_ga"/>
                                    <span v-if="$v.formData.ultrasound_ga.$error" class="text-danger"><small> required</small></span>
                                </td>
                                <td>
                                    <gestational-age v-model="formData.corrected_ga"/>
                                </td>
                            </tr>
                        </table>
                        <div class="form-group w-25">
                            <label>EDD method</label>
                            <select class="form-control form-control-sm" v-model="formData.edd_method" :class="{'form-control is-invalid':$v.formData.edd_method.$error}">
                                <option value="calc">calculated</option>
                                <option value="us">Ultrasound</option>
                                <option value="corrected">Corrected</option>
                            </select>
                            <div class="invalid-feedback" v-if="{'form-control is-invalid':$v.formData.edd_method.$error}">
                                You have to choose the EDD method
                            </div>
                        </div>
                        <h6>Estimated date of delivery</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Calculated</td>
                                <td>Ultrasound</td>
                                <td>Corrected</td>
                            </tr>
                            <tr>
                                <td>
                                    <date-picker
                                        v-model=" formData.edd_calculated"
                                        mode="date"
                                        :model-config="accessory.dateConfig"
                                        :masks="accessory.dateConfig.masks"
                                        :min-date="new Date()"
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
                                                :value="inputValue"
                                                v-on="inputEvents"
                                            />
                                        </template>
                                    </date-picker>
                                </td>
                                <td>
                                    <date-picker
                                        v-model=" formData.edd_ultrasound"
                                        mode="date"
                                        :model-config="accessory.dateConfig"
                                        :masks="accessory.dateConfig.masks"
                                        :min-date="new Date()"
                                        ref="edd_ultrasound"
                                        @popoverWillShow="move_ultrasound_date_picker('edd_ultrasound')"
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
                                                :class="{'is-invalid':$v.formData.edd_ultrasound.$error}"
                                                :value="inputValue"
                                                v-on="inputEvents"
                                            />
                                        </template>
                                    </date-picker>
                                </td>
                                <td>
                                    <date-picker
                                        v-model=" formData.edd_corrected"
                                        mode="date"
                                        :model-config="accessory.dateConfig"
                                        :masks="accessory.dateConfig.masks"
                                        :min-date="new Date()"
                                        ref="edd_corrected"
                                        @popoverWillShow="move_ultrasound_date_picker('edd_corrected')"
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
                                                :value="inputValue"
                                                v-on="inputEvents"
                                            />
                                        </template>
                                    </date-picker>
                                </td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" v-model="formData.multiple_pregnancy">
                                    <label class="form-check-label">Multiple pregnancy</label>
                                </div>
                            </div>
                            <div class="col-8">
                                <label>Count of fetus</label>
                                <select class="form-control form-control-sm"
                                        v-model.number="formData.count_of_fetus"
                                        v-if="formData.multiple_pregnancy">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <v-btn class=" float-right mt-6 btn " small :loading="form_is_submitting" @click="submit" color="primary">Submit</v-btn>
                </v-card-text>
            </v-card>
        </div>
    </v-app>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import GestationalAge from "../../../../components/gestational_age_control";
import { validationMixin } from "vuelidate";
const {
    required,
    minValue,
    minLength,
    email,
    url,
    maxLength,
    between,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "ultrasound_admission_form",
    components: {GestationalAge, Patient_information},
    props:['admission'],
    mixins: [validationMixin],
    data(){
        return{
           formData:{
               last_period_date:'',
               edd_calculated:'',
               edd_ultrasound:'',
               edd_corrected:'',
               edd_method:'',
               unknown_lpd:'',
               is_patient_pregnant:'',
               remark_when_patient_not_pregnant:'',
               multiple_pregnancy:false,
               count_of_fetus:1,
               calculated_ga:'',
               ultrasound_ga:'',
               corrected_ga:'',
               user_id:'',
               status:'open',
               patient_id:''

           },
            default_data:{
               last_period_date:'',
                edd_calculated:'',
                edd_ultrasound:'',
                edd_corrected:'',
                edd_method:'',
                unknown_lpd:'',
                is_patient_pregnant:'',
                remark_when_patient_not_pregnant:'',
                multiple_pregnancy:false,
                count_of_fetus:1,
                calculated_ga:'',
                ultrasound_ga:'',
                corrected_ga:'',
                user_id:'',
                status:'open',
                patient_id:''
            },
            accessory: {
                dateConfig: {
                    type: "string",
                    mask: "iso",
                    masks: {
                        input: "DD/MMM/YYYY",
                    },
                },
                edd_method:['calculated','ultrasound','corrected'],
                medical_staff:[
                    "Tanja",
                    "Tianasoa",
                    "Manitra",
                    "Finaritra",
                    "Dr Martin",
                    "Dr Petra",
                    "Hobilalaina",
                    "Ando",
                ],
            },
            form_is_submitting:false
        }
    },
    validations:{
        formData:{
            edd_method:{required:requiredIf((formData)=>{ return formData.is_patient_pregnant===1})},
            edd_ultrasound:{required:requiredIf((formData)=>{ return formData.is_patient_pregnant===1})},
            ultrasound_ga:{required:requiredIf((formData)=>{ return formData.is_patient_pregnant===1})},
            last_period_date:{required:requiredIf((formData)=>{ return formData.is_patient_pregnant===1 && !formData.unknown_lpd})},

        }
    },
    created(){
        this.formData.user_id=window.auth.user.id
    },
    methods:{
        submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.admission_id= this.admission.id
            this.formData.patient_id= this.admission.patient_id
            this.form_is_submitting=true
            axios.post('/api/v1/patient_system/out_patient/obstetrical/ultrasound/admission',this.formData).then(
                response=>{
                   if(response.data.success){
                       // this.$router.push({name:'ultrasound_exam_crud',params:{admission:this.admission}})
                       this.formData=Object.assign({},this.default_data)
                       this.$emit('success')
                       this.form_is_submitting=false
                   }

                }
            )
        },
        get_calculated_ga(lp) {
            if (!this.formData.unknown_lpd) {
                if (this.formData.last_period_date) {
                    let date = new Date(lp);
                    date.setDate(date.getDate() + 7);
                    date.setMonth(date.getMonth() - 3);
                    date.setFullYear(date.getFullYear() + 1);

                    this.formData.edd_calculated = new Date(date);

                    if (!this.formData.edd_method) this.formData.edd_method = "calc";
                }
            } else {
                if (!this.formData.accessory) this.formData.accessory = {};
                if (this.formData.last_period_date) this.formData.accessory.previous_last_period_date = this.formData.last_period_date;

                this.formData.last_period_date = null;
                this.formData.edd_calculated = null;

                if (this.formData.edd_method === "calc") {
                    if (this.formData.edd_ultrasound) this.formData.edd_method = "echo";
                    else if (this.formData.edd_corrected) this.formData.edd_method = "corrected";
                    else this.formData.edd_method = null;
                }
            }
            if (lp) {
                // console.log(new Date(lp))
                const diff = new Date() -new Date(lp);

                const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);
                // const ga_in_days = 40 * 7 - diff_in_days;
                // console.log(ga_in_days)

                const ga_weeks = Math.floor(diff_in_days / 7);
                const ga_days = diff_in_days % 7;

                this.formData.calculated_ga = ga_weeks + "+" + ga_days;
            } else {
                this.formData.calculated_ga = null;
            }
        },
        move_ultrasound_date_picker(ref) {
            let date_picker = this.$refs[ref];
            date_picker.move(this.formData.edd_calculated);
        },

    }
}
</script>

<style scoped>
.title{
    background-color: #1390C6;
    color:white;
}
</style>
