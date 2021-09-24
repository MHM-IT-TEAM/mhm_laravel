<template>
    <div class="container border">
        <v-app>
            <div class="row p-2">
                <div class="col-2 border">
                    <v-list >
                        <v-list-item-group v-model="accessory.selectedItem"
                        >
                            <v-list-item v-for="item in accessory.items_simple" :key="item.title">
                                <v-list-item-icon >
                                    <v-icon v-text="item.icon"></v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>

                </div>
                <div class="col-10 border">
                    <div class="table-responsive" v-if="accessory.selectedItem===0">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="3"><v-icon>mdi-account-circle</v-icon> Personal information </th>
                            </tr>
                            <tr>
                                <td style="width:20%"><span class="text-danger">*</span>Id</td>
                                <td style="width:40%">First name</td>
                                <td style="width:40%">Last name</td>
                            </tr>
                            <tr>
                                <td>
                                    {{formData.admission.patient_id}}
                                </td>
                                <td class="required">
                                    {{formData.admission.patient.firstName}}
                                </td>
                                <td class="required">
                                    {{formData.admission.patient.lastName}}
                                </td>
                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>Address</td>
                                <td>Tel</td>
                            </tr>
                            <tr>
                                <td class="required">
                                    {{moment(formData.admission.patient.birthDate).format("DD/MM/YYYY")}}
                                </td>
                                <td class="required">
                                    {{formData.admission.patient.adress}}
                                </td>
                                <td class="required">
                                    {{formData.admission.patient.tel}}
                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="5"> <v-icon>mdi-stethoscope</v-icon>Medical data</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="text-danger">*</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="admission_type1" name="admission_type1" value="1" class="custom-control-input" v-model="formData.new_case">
                                        <label class="custom-control-label" for="admission_type1">New case</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="admission_type2" name="admission_type1" value="0" class="custom-control-input" v-model="formData.new_case">
                                        <label class="custom-control-label" for="admission_type2">Followup</label>
                                    </div>
                                    <span class="text-white bg-danger" v-if="$v.formData.new_case.$error">You must choose one between new case or followup</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%">Complaint</td>
                                <td><textarea  class="form-control form-control-sm" placeholder="write here the complaint" v-model="formData.complaint"></textarea></td>
                            </tr>
                            <tr>
                                <td>Finding</td>
                                <td><textarea  class="form-control form-control-sm" placeholder="write here the findings " v-model="formData.finding"></textarea></td>
                            </tr>
                            <tr>
                                <td>Test</td>
                                <td>
                                    <strong>Malaria (RDT)</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="malaria1" value="positive" name="malaria1" class="custom-control-input" v-model="formData.malaria">
                                        <label class="custom-control-label" for="malaria1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="malaria2" value="negative" name="malaria1" class="custom-control-input" v-model="formData.malaria">
                                        <label class="custom-control-label" for="malaria2">Negative</label>
                                    </div>
                                    | &nbsp
                                    <strong>Syphilis</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="syphilis1" name="syphilis1" class="custom-control-input" value="positive" v-model="formData.syphilis">
                                        <label class="custom-control-label" for="syphilis1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="syphilis2" name="syphilis1" class="custom-control-input" value="negative" v-model="formData.syphilis">
                                        <label class="custom-control-label" for="syphilis2">Negative</label>
                                    </div>
                                    |&nbsp
                                    <strong>HIV AIDS</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="hiv1" name="hiv1" class="custom-control-input" value="positive" v-model="formData.hiv">
                                        <label class="custom-control-label" for="hiv1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="hiv2" name="hiv1" class="custom-control-input" value="negative" v-model="formData.hiv">
                                        <label class="custom-control-label" for="hiv2">Negative</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Medical care needed (soin)<span class="text-danger">*</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="care1" name="care1" class="custom-control-input" value="1" v-model="formData.medical_care_needed">
                                        <label class="custom-control-label" for="care1">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="care2" name="care1" class="custom-control-input" value="0" v-model="formData.medical_care_needed">
                                        <label class="custom-control-label" for="care2">No</label>
                                    </div>
                                    <span class="text-white bg-danger" v-if="$v.formData.medical_care_needed.$error">
                                        <= This field is required
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Diagnoses<span class="text-danger">*</span></td>
                                <td>
                                    <input type="text" placeholder="type here the diagnose" :class="{'is-invalid':$v.formData.diagnose.$error}" class="form-control form-control-sm" v-model="formData.diagnose"/>
                                    <span class="invalid-feedback" v-if="$v.formData.diagnose.$error">
                                        You must write a diagnose
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Diagnose code<span class="text-danger">*</span></td>
                                <td>
                                    <select class="form-control form-control-sm" v-model="formData.diag_code" :class="{'is-invalid':$v.formData.diag_code.$error}">
                                        <option v-for="item in accessory.diag_code_list" :value="item.code">{{'['+ item.code +']'+" "  + item.description}}</option>
                                    </select>
                                    <span class="invalid-feedback" v-if="$v.formData.diag_code.$error">
                                        The Diagnostic code is required
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Details<span class="text-danger">*</span></td>
                                <td><textarea class="form-control"  v-model="formData.details"></textarea></td>
                            </tr>
                            <tr>
                                <td>
                                    Appointment
                                </td>
                                <td>
                                    <date-picker v-model="formData.appointment"
                                                 :input-debounce="500" mode="date"
                                                 :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                                 :min-date="new Date()">
                                        <template v-slot="{ inputValue, inputEvents }">
                                            <input
                                                class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                                :value="inputValue"
                                                v-on="inputEvents"
                                            />
                                        </template>
                                    </date-picker>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="5"><v-icon>mdi-pill</v-icon> Medication </th>
                            </tr>
                            <tr>
                                <td>
<!--                                    <select class="form-control form-control-sm">-->
<!--                                        <option>Choose</option>-->
<!--                                    </select>-->
                                    <multiselect
                                        v-model="accessory.medication.item"
                                        label="description"
                                        track-by="description"
                                        :id="'multiSelect'"
                                        placeholder="Type to search"
                                        open-direction="bottom"
                                        :options="accessory.medicines_temp_list"
                                        :searchable="true"
                                        :internal-search="false"
                                        :clear-on-select="true"
                                        :close-on-select="true"
                                        :show-no-results="false"
                                        :hide-selected="true"
                                        @search-change="fetchItem"
                                        class="multiSelect"
                                    >
                                    </multiselect>
                                </td>
                                <td>
                                    <input type="number" placeholder="Breakfast" class=" form-control " v-model="accessory.medication.breakfast"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="Lunch" class=" form-control " v-model="accessory.medication.lunch"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="Dinner" class=" form-control " v-model="accessory.medication.dinner"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="To give" class=" form-control " v-model="accessory.medication.to_give" @keydown.enter="add_medication"/>
                                </td>
                            </tr>
                            <tr v-for="(item,i) in formData.medication">
                                <td>{{item.item.description}}</td>
                                <td>{{item.breakfast}}</td>
                                <td>{{item.lunch}}</td>
                                <td>{{item.dinner}}</td>
                                <td>
                                    {{item.to_give}} &nbsp
                                    <v-btn
                                        x-small
                                        icon
                                        @click="delete_medication_line(i)"
                                    >
                                        <v-icon> mdi-delete</v-icon>
                                    </v-btn>

                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td colspan="2" class="text-right">
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="submit"
                                    >
                                        Submit
                                    </v-btn>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div v-if="accessory.selectedItem===1">
                        <generalist_overview :patient_id="formData.admission.patient_id"/>
                    </div>
                    <div v-if="accessory.selectedItem===2">
                        <lab-work/>
                    </div>
                    <div v-if="accessory.selectedItem===3">
                        <internal_referral :admission="formData.admission"/>
                    </div>
                    <div v-if="accessory.selectedItem===4">
                        <external_referral/>
                    </div>
                </div>
            </div>


        </v-app>
    </div>
</template>

<script>
import LabWork from "../nurseStation/LabWork";
import External_referral from "../maternity/referral/external_referral";
import { validationMixin } from "vuelidate";
import Generalist_overview from "./generalist_overview";
import moment from "moment"
import Internal_referral from "../../../components/internal_referral";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "generalist_admission",
    components: {Internal_referral, Generalist_overview, External_referral, LabWork},
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                id:'',
                new_case:'',
                admission:{
                    patient:{
                        firstName:'',
                        lastName:'',
                        tel:'',
                        birthDate:'',
                        adress:''
                    }
                },
                admission_id:'',
                complaint:'',
                finding:'',
                malaria:'',
                syphilis:'',
                hiv:'',
                medical_care_needed:'',
                diagnose:'',
                diag_code:'',
                details:'',
                appointment:'',
                medication:[]
            },
            accessory:{
                selectedItem: 0,
                items_simple: [
                    { title: 'Main', icon: 'mdi-book' },
                    { title: 'Overview', icon: 'mdi-magnify' },
                    { title: 'Labwork', icon: 'mdi-chemical-weapon' },
                    { title: 'Internal referral', icon: 'mdi-account-reactivate-outline' },
                    { title: 'External Referral', icon: 'mdi-truck' },
                ],
                dateConfig: {
                    type: 'string',
                    mask:'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                },
                diag_code_list:[],
                medicines_temp_list:[],
                medication:{
                    item:null,
                    breakfast:'',
                    lunch:'',
                    dinner:'',
                    to_give:''
                }

            }
        }
    },
    validations:{
        formData:{
            new_case:{required},
            diagnose:{required},
            medical_care_needed:{required},
            diag_code:{required},
        }
    },
    created(){
        if(Object.keys(this.$route.params).length>0 )this.formData.admission= this.$route.params.admission
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/patient_system/out_patient/generalist/diag_codes').then(response=>this.accessory.diag_code_list=response.data)
        },
        async fetchItem(code){
            this.accessory.medicines_temp_list = [];
            if(code.length>4){
                await axios({
                    method:'GET',
                    url:'/api/v1/inventory_system/item',
                    params:{ search_text: code },
                }).then((response) => {
                    this.accessory.medicines_temp_list=response.data.data
                });
            }
        },
        add_medication(){
            this.formData.medication.push(this.accessory.medication)
            this.accessory.medication={
                item:null,
                breakfast:'',
                lunch:'',
                dinner:'',
                to_give:''
            }
        },
        delete_medication_line(i){
            this.formData.medication.splice(i,1)
        },
        async submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.responsible= window.auth.user.name
            await axios.post('/api/v1/patient_system/out_patient/generalist/consultation',this.formData).then(response=>{
                if(response.data.success){
                    this.$toast.open({position:'top-right',type:'success',message:response.data.msg})
                    this.reset_form()
                    this.$v.$reset()
                }
            })
        },
        reset_form(){
          this.formData={
              id:'',
              new_case:'',
              admission:{
                  patient:{
                      firstName:'',
                      lastName:'',
                      tel:'',
                      birthDate:'',
                      adress:''
                  }
              },
              admission_id:'',
              complaint:'',
              finding:'',
              malaria:'',
              syphilis:'',
              hiv:'',
              medical_care_needed:'',
              diagnose:'',
              diag_code:'',
              details:'',
              appointment:'',
              medication:[]
          }
        }
    }
}
</script>

<style scoped>
.form-title {
    font-size: 3rem;
    letter-spacing: 5px;
}
.table-title{
    background-color: #cceff0;
}
.main-container{
    margin-top:5px;
}
.multiselect__tags{
    height: 10px;
}
</style>
