<template>
    <div class="container-fluid">
        <v-card>
            <v-card-title>SURGERY FORM</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="10">
                        <patient_information :patient_id="formData.patient_id "  v-if="formData.patient_id !==''"/>
                    </v-col>
                    <v-col cols="2">
                        <v-img
                            max-height="150"
                            max-width="250"
                            v-if="avatar!=='' && avatar!== null"
                            :src="'/storage/assets/media/images/patients/avatar/'+avatar"
                            lazy-src="https://i.pravatar.cc/300"
                        ></v-img>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card class="mt-2">
            <v-card-text>
                <p class="title">
                    <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B)
                    <span style="font-size: 15px; font-weight: bold">Medical Data</span>
                </p>
                <v-row>
                    <v-col cols="2">
                        <v-text-field
                            label="Time of admission in JoyCenter"
                            :value="moment(formData.created_at).format(' h:mm:ss a')"
                            readonly
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            label=" Reason for Surgery"
                            v-model="formData.reason_for_surgery"
                            :error="$v.formData.reason_for_surgery.$error"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select :items="type_of_surgery"  :error="$v.formData.type_of_surgery.$error" v-model="formData.type_of_surgery" label="Type of Surgery"></v-select>
                    </v-col>
                </v-row>
                <v-expansion-panels accordion>
                    <v-expansion-panel
                    >
                        <v-expansion-panel-header expand-icon="mdi-plus" class="bg-info text-white font-weight-bold">
                            Pre Surgery data
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <span class="badge badge-warning">Vital signs</span>
                            <v-row>
                                <v-col>
                                    <v-simple-table>
                                        <template v-slot:default>
                                            <thead>
                                            <tr>
                                                <th class="text-left">Temp </th>
                                                <th class="text-left">Weight</th>
                                                <th class="text-left">Blood pressure</th>
                                                <th class="text-left">Pulse</th>
                                                <th class="text-left">SPO2</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr
                                            >
                                                <td>{{formData.temp}}</td>
                                                <td>{{formData.weight}}</td>
                                                <td>{{formData.taSysto+"/"+formData.taDia }}</td>
                                                <td>{{formData.pulse}}</td>
                                                <td>{{formData.spo2}}</td>
                                            </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col >
                                    <div class="form-group">
                                        <label>Date of Surgery</label>
                                        <date-picker v-model="formData.date_of_surgery"
                                                     name="dob"
                                                     id="dob"
                                                     :input-debounce="500" mode="date"
                                                     :model-config="dateConfig" :masks="dateConfig.masks"
                                                     :min-date="new Date()">
                                            <template v-slot="{ inputValue, inputEvents }">
                                                <input
                                                    class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                                    :class="{'border border-danger':$v.formData.date_of_surgery.$error}"
                                                    :value="inputValue"
                                                    v-on="inputEvents"
                                                />
                                            </template>
                                        </date-picker>
                                    </div>
                                </v-col>
                                <v-col >
                                    <div class="form-group">
                                        <label>Start time of no food</label>
                                        <input type="time" class="form-control form-control-sm" v-model="formData.start_time_no_food"/>
                                    </div>
                                </v-col>
                                <v-col >
                                    <div class="form-group">
                                        <label>EMLA Time ON</label>
                                        <input type="time" class="form-control form-control-sm" v-model="formData.emla_on"/>
                                    </div>
                                </v-col>
                                <v-col >
                                    <div class="form-group">
                                        <label>EMLA Time OFF</label>
                                        <input type="time" class="form-control form-control-sm" v-model="formData.emla_off"/>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-textarea
                                        name="input-7-1"
                                        label="Notes/comments (FROM PRE SURGERY FORM)"
                                        rows="2"
                                        v-model="formData.comment"
                                        readonly
                                    ></v-textarea>
                                </v-col>
                            </v-row>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>

                <span class="badge badge-warning mt-4">Timeframe</span>
                <v-row>
                    <v-col>
                        <div class="form-group">
                            Time beginning of Anesthesia
                            <input type="time" class="form-control" v-model="formData.time_anesthesia" />
                        </div>
                    </v-col>
                    <v-col>
                        <div class="form-group">
                            Time End of Anesthesia
                            <input type="time" class="form-control" v-model="formData.time_is_anesthesia_finished" />
                        </div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <div class="form-group">
                            Time beginning of Surgery
                            <input type="time" class="form-control" v-model="formData.time_surgery" :class="{'is-invalid':$v.formData.time_surgery.$error}"/>
                        </div>
                    </v-col>
                    <v-col>
                        <div class="form-group">
                            Time End of Surgery
                            <input type="time" class="form-control" v-model="formData.time_is_surgery_finished" :class="{'is-invalid':$v.formData.time_is_surgery_finished.$error}"/>
                        </div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-textarea
                            name="input-7-1"
                            label="Surgery report"
                            rows="2"
                            v-model="formData.surgery_report"
                            :error="$v.formData.surgery_report.$error"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row>
                   <v-col>
                       <div class="table-responsive">
                           <table class="table table-sm">
                               <tr>
                                   <td>Medicament</td>
                                   <td>Time</td>
                                   <td>Dosage</td>
                                   <td></td>
                               </tr>
                               <tr>
                                   <td>
                                       <input type="text" class="form-control" v-model="temp_med.medicine"/>
                                   </td>
                                   <td>
                                       <input type="time" class="form-control" v-model="temp_med.time"/>
                                   </td>
                                   <td>
                                       <input type="text" class="form-control" v-model="temp_med.dosage" @keypress.enter="push_row"/>
                                   </td>
                               </tr>
                               <tr v-for="(row,i) in formData.surgery_used_medicines">
                                   <td>{{row.medicine}}</td>
                                   <td>{{row.time}}</td>
                                   <td>{{row.dosage}}</td>
                                   <td>
                                       <v-btn x-small  @click="remove_row(i)">
                                           <v-icon >mdi-trash-can</v-icon>
                                       </v-btn>
                                   </td>
                               </tr>
                           </table>
                       </div>
                   </v-col>
                </v-row>
                <v-row>
                    <v-col >
                        Dismissal Outcome
                        <v-radio-group
                            v-model="formData.dismissal_outcome"
                            :error="$v.formData.dismissal_outcome.$error"
                            :readonly="formData.is_edit"
                            row
                        >
                            <v-radio
                                label="Stay"
                                value="stay"
                            ></v-radio>
                            <v-radio
                                label="Go Home"
                                value="go-home"
                            ></v-radio>
                        </v-radio-group>
                    </v-col >
                    <v-col >
                        Wound care
                        <v-radio-group
                            v-model="formData.wound_care"
                            row
                            :error="$v.formData.wound_care.$error"
                        >
                            <v-radio
                                label="yes"
                                value="yes"
                            ></v-radio>
                            <v-radio
                                label="no"
                                value="no"
                            ></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col  v-if="formData.wound_care==='yes'">
                        Date of wound care
                        <date-picker v-model="formData.wound_care_date"
                                     name="wound_care_date"
                                     :input-debounce="500" mode="date"
                                     :model-config="dateConfig" :masks="dateConfig.masks"
                                     :min-date="new Date()"
                        >
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="bg-white form-control form-control-sm px-2 py-1 rounded mt-4"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                    </v-col>
                    <v-col >
                        Next surgery
                        <v-radio-group
                            v-model="formData.next_surgery"
                            row
                            :error="$v.formData.next_surgery.$error"
                        >
                            <v-radio
                                label="yes"
                                value="yes"
                            ></v-radio>
                            <v-radio
                                label="no"
                                value="no"
                            ></v-radio>
                        </v-radio-group>
                    </v-col >
                    <v-col  v-if="formData.next_surgery==='yes'">
                        Date of next Surgery
                        <date-picker v-model="formData.next_surgery_date"
                                     name="wound_care_date"
                                     :input-debounce="500" mode="date"
                                     :model-config="dateConfig" :masks="dateConfig.masks"
                                     :min-date="new Date()"
                        >
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="bg-white form-control form-control-sm px-2 py-1 rounded mt-4"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        Appointment for followup
                        <date-picker v-model="formData.appointment_for_followup"
                                     name="wound_care_date"
                                     :input-debounce="500" mode="date"
                                     :model-config="dateConfig" :masks="dateConfig.masks"
                                     :min-date="new Date()"
                        >
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="bg-white form-control form-control-sm px-2 py-1 rounded mt-4"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                    </v-col>
                </v-row>
                <span class="badge badge-pill badge-info mt-2">Medical team</span>
                <v-row class="mt-2">
                    <v-col>
                        <v-text-field label="Surgeons"  v-model="formData.surgeons"/>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        <v-text-field label="Doctors"  v-model="formData.doctors"/>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        <v-text-field label="Anesthetists"  v-model="formData.anesthetists"/>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        <v-text-field label="Nurses"  v-model="formData.nurses"/>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        <v-text-field label="midwives"  v-model="formData.midwives"/>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        <v-text-field label="Other people present"  v-model="formData.other_people"/>
                    </v-col>
                </v-row>
                <v-btn depressed color="primary" @click="submit" class="mt-2" :loading="loading">Submit</v-btn>
            </v-card-text>
        </v-card>
        <v-dialog
            v-model="show_internal_referral"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Refer to Stork Center
                </v-card-title>

                <v-card-text>
                  <internal_referral :admission="$route.params.surgery.admission" @form_submitted="form_is_submitted"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import Patient_information from "../../../components/patient_information";
import { validationMixin } from "vuelidate";
import moment from "moment"
import _ from "lodash"
import Internal_referral from "../../../components/internal_referral";
const {
    required,
    requiredIf,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "surgery_form",
    components: {Internal_referral, Patient_information},
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                admission_id:'',
                patient_id:'',
                date_of_surgery:'',
                time_surgery:'',
                time_is_surgery_finished:'',
                time_anesthesia:'',
                time_is_anesthesia_finished:'',
                reason_for_surgery:'',
                type_of_surgery:'',
                comment:'',
                emla_on:'',
                start_time_no_food:'',
                emla_off:'',
                surgery_report:'',
                dismissal_outcome:'',
                wound_care:'',
                next_surgery:'',
                next_surgery_date:'',
                wound_care_date:'',
                appointment_for_followup:'',
                surgeons:'',
                doctors:'',
                anesthetists:'',
                midwives:'',
                other_people:'',
                surgery_used_medicines:[],
            },
            is_edit:false,
            dateConfig: {
                type: 'string',
                mask:'iso',
                masks: {
                    input: 'DD/MMM/YYYY',
                },
            },
            type_of_surgery:['plastic'],
            temp_med:{medicine:'', dosage:'',time:''},
            loading:false,
            avatar:'',
            show_internal_referral:false
        }
    },
    validations:{
        formData:{
            type_of_surgery:{required},
            date_of_surgery:{required},
            time_surgery:{required},
            time_is_surgery_finished:{required},
            reason_for_surgery:{required},
            surgery_report:{required},
            dismissal_outcome:{required},
            wound_care:{required},
            next_surgery:{required},
        }
    },
    async created(){
        const SRC=this.$route.params.surgery
        if(SRC){
            this.formData= _.omit(SRC,['admission'])
        }
        if(this.$route.params.id){
           await this.fetch_surgery(this.$route.params.id)
            this.is_edit=true

        }
    },
    watch:{
        formData:{
            handler(val){
                if(val.dismissal_outcome==='stay')this.show_internal_referral=true
            },
            deep:true
        }
    },
    methods:{
       async submit(){
           this.$v.formData.$touch();
           if (this.$v.$invalid) {
                return true;
            }
           this.formData.status='DONE'
           this.formData.is_edit=this.is_edit
            await axios.put(`/api/v1/patient_system/surgery/resource/${this.formData.id}`,this.formData).then(response=>{
                this.loading=true
                this.$toast.open('Data saved')
                this.$router.push({name:'surgery_list'})
            })
           this.loading=false
        },
        form_is_submitted(){
           this.show_internal_referral=false
            this.$toast.open({position: 'top-right', type: 'success', message: 'the patient is referred to Stork center'})
        },
        fetch_surgery(id){
            axios.get(`/api/v1/patient_system/surgery/resource/${id}`).then(
                response=>{
                    this.avatar=response.data.admission.patient.avatar
                    this.formData=_.omit(response.data,['admission'])
                }
            )
        },
        push_row(){
            if(this.temp_med.medicine!=='' && this.temp_med.dosage!==''){
                this.formData.surgery_used_medicines.push(this.temp_med)
                this.temp_med={medicine:'', dosage:''}
            }
        },
        remove_row(i){
           this.formData.surgery_used_medicines.splice(i,1)
        }
    }
}
</script>

<style scoped>
.title{
    background-color: #1390C6;
    color:white;
}
.table{
    background-color: lightgray;
}
</style>
