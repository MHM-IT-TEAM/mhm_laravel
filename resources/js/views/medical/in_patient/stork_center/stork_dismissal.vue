<template>
    <div class="container">
        <patient_information :patient_id="$route.params.stork_admission.patient_id"/>
        <h5>Quick overview</h5>
        <div class="table-responsive">
            <table class="table table-sm">
                <tr>
                    <th>Date of Entry</th>
                    <th>Time of Entry</th>
                    <th>Level of Care</th>
                    <th>Mobilisation Status</th>
                    <th>Diagnostic of entry</th>
                </tr>
                <tr>
                    <td>{{moment(stork_admission.admission_date).format("MMM Do YY")}}</td>
                    <td>{{stork_admission.admission_time}}</td>
                    <td>{{stork_admission.level_of_care}}</td>
                    <td>{{stork_admission.mobilisation_status}}</td>
                    <td>{{stork_admission.admission_diagnosis}}</td>
                </tr>
            </table>
            <h5>Form</h5>
            <table class="table table-sm mt-2">
                <tr>
                    <td>Date of Dismissal</td>
                    <td>Time of Dismissal</td>
                </tr>
                <tr>
                    <td>
                        <date-picker
                            v-model=" formData.dismissal_date"
                            mode="date"
                            :masks="dateConfig.masks"
                            :max-date="new Date()"
                            :min-date="stork_admission.admission_date"
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
                                    :class="{'is-invalid':$v.formData.dismissal_date.$error}"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                    </td>
                    <td>
                        <div class="form-group">
                            <input class="form-control" :class="{'is-invalid':$v.formData.dismissal_time.$error}" type="time" v-model="formData.dismissal_time"/>
                            <div class="invalid-feedback" v-if="$v.formData.dismissal_time.$error">
                                Please provide a time
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="form-group">
                            <label>Dismissal diagnosis</label>
                            <textarea class="form-control" :class="{'is-invalid':$v.formData.dismissal_date.$error}" v-model="formData.dismissal_diagnosis"/>
                            <div class="invalid-feedback" v-if="$v.formData.dismissal_date.$error">
                                Please provide a valid diagnosis.
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table table-sm">
                <tr>
                    <td>BP.L</td>
                    <td>BP.R</td>
                    <td>pulse</td>
                    <td>Spo2</td>
                    <td>Temp</td>
                    <td>Weight</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control form-control-sm" v-model="formData.bp_l">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" v-model="formData.bp_r">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" v-model="formData.pulse">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" v-model="formData.spo2">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" v-model="formData.temp">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" v-model="formData.weight">
                    </td>
                </tr>
            </table>
            <button class="btn btn-sm btn-primary" @click="submit">Submit</button>
        </div>
    </div>
</template>

<script>
import moment from "moment"
import Patient_information from "../../../../components/patient_information";
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "stork_dismissal",
    components: {Patient_information},
    mixins: [validationMixin],
    created(){
        this.stork_admission= this.$route.params.stork_admission
    },
    data(){
        return{
            stork_admission:{},
            formData:{
                dismissal_date:'',
                dismissal_time:'',
                dismissal_diagnosis:'',
                bp_l:'',
                bp_r:'',
                pulse:'',
                weight:'',
                temp:'',
                spo2:''
            },
            dateConfig: {
                type: "string",
                mask: "iso",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
        }
    },
    validations:{
        formData:{
            dismissal_date:{required},
            dismissal_time:{required},
            dismissal_diagnosis:{required}
        }
    },
    methods:{
        submit(){
            this.$v.$touch();
            if (this.$v.$invalid)return
            this.formData.stork_admission_id= this.stork_admission.id
            this.formData.bed_id =this.stork_admission.bed_id
            this.formData.user_id=window.auth.user.id
            axios.post('/api/v1/patient_system/in_patient/stork/dismissal',this.formData).then(response=>{
                if(response.data.success){
                    this.$router.push('patient_list')
                }
            })

        }
    }
}
</script>

<style scoped>

</style>
