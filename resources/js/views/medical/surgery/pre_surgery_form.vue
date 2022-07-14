<template>
    <div class="container-fluid">
        <v-card>
            <v-card-title>PRE SURGERY FORM</v-card-title>
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
                <span class="badge badge-warning">Timeframe</span>
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
                            label="Notes/comments"
                            v-model="formData.comment"
                            hint="Write any comments here"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-btn depressed color="primary" @click="submit" :loading="loading">Submit</v-btn>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Patient_information from "../../../components/patient_information";
import { validationMixin } from "vuelidate";
import moment from "moment"
const {
    required,
    requiredIf,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "pre_surgery_form",
    components: {Patient_information},
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                admission_id:'',
                patient_id:'',
                date_of_surgery:'',
                reason_for_surgery:'',
                type_of_surgery:'',
                comment:'',
                emla_on:'',
                start_time_no_food:'',
                emla_off:'',
            },
            dateConfig: {
                type: 'string',
                mask:'iso',
                masks: {
                    input: 'DD/MMM/YYYY',
                },
            },
            type_of_surgery:['plastic'],
            loading:false,
            avatar:''
        }
    },
    validations:{
        formData:{
            type_of_surgery:{required},
            date_of_surgery:{required},
            reason_for_surgery:{required},
        }
    },
    created(){
        const SRC=this.$route.params.admission
        if(SRC){
            this.avatar=SRC.patient.avatar
            this.formData.patient_id= SRC.patient_id
            this.formData.admission_id= SRC.id
            this.formData.temp=SRC.temp
            this.formData.weight=SRC.weight
            this.formData.taDia=SRC.taDia
            this.formData.taSysto=SRC.taSysto
            this.formData.spo2=SRC.spo2
            this.formData.pulse=SRC.pulse
            this.formData.reason_for_surgery=SRC.remark
            this.formData.created_at=SRC.created_at
        }
    },
    methods:{
        async submit(){
            this.$v.formData.$touch();
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.status='CONFIRMED'
            this.loading=true
            await axios.post('/api/v1/patient_system/surgery/resource',this.formData).then(response=>{
                this.$toast.open('Data saved')
                this.$router.push({name:'pre_surgery_list'})
            })
            this.loading=false
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
