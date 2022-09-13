<template>
    <div class="container border">
       <v-app>
           <div class="table-responsive">
               <patient_information :patient_id="formData.admission.patient_id"/>
               <table class="table table-sm table-borderless">
                   <tr>
                       <th class="table-title" colspan="13"> <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B) Today's actions</th>
                   </tr>
                   <tr>
                       <td colspan="3">
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
                       <td>
                           <v-btn  small color="light-blue darken-1" dark @click="accessory.show_overview=true"> show overview</v-btn>
                       </td>
                   </tr>
                   <tr>
                       <th style="width:10%" colspan="2"> B.1. Symptoms:</th>
                       <td colspan="12">
                           <textarea  class="form-control form-control-sm" :class="{'is-invalid':$v.formData.symptoms.$error}" placeholder="write here the symptoms" v-model="formData.symptoms"></textarea>
                           <div class="invalid-feedback">
                               The symptoms are required
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <th colspan="2">B.2. Diagnostics</th>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">2.1. Vital signs</td>
                   </tr>
                   <tr>
                       <td class="pl-6" colspan="2">From JC</td>
                       <td colspan="9">

                           <div class="form-inline vt">
                               BP:
                               <input type="number" readonly class="form-control form-control-sm vital-signs ml-2" v-model="formData.admission.taSysto"> /
                               <input type="number" readonly class="form-control form-control-sm vital-signs" v-model="formData.admission.taDia">
                               &nbsp Pulse: <input type="number" readonly class="form-control form-control-sm vital-signs ml-2" v-model="formData.admission.pulse">
                               &nbsp Temp: <input type="number" readonly class="form-control form-control-sm vital-signs ml-2" v-model="formData.admission.temp">
                               &nbsp Weight:<input type="number" readonly class="form-control form-control-sm vital-signs ml-2" v-model="formData.admission.weight">
                               &nbsp Spo2:<input type="number" readonly class="form-control form-control-sm vital-signs ml-2" v-model="formData.admission.spo2">
                           </div>

                       </td>
                   </tr>
                   <tr>
                       <td class="pl-6" colspan="2">
                           <div class="form-check">
                               <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" v-model="formData.vital_sign_update_required">
                               <label class="form-check-label" for="flexCheckDefault">
                                   Update required
                               </label>
                           </div>
                       </td>
                       <td colspan="9" v-if="formData.vital_sign_update_required">
                           <div class="form-inline">
                               BP:
                               <input type="number" class="form-control form-control-sm vital-signs ml-2" v-model="formData.taDia"> /
                               <input type="number" class="form-control form-control-sm vital-signs" v-model="formData.taSysto">
                               &nbsp Pulse:<input type="number" class="form-control form-control-sm vital-signs ml-2" v-model="formData.pulse">
                               &nbsp Temp: <input type="number" class="form-control form-control-sm vital-signs ml-2" v-model="formData.temp">
                               &nbsp Weight:<input type="number" class="form-control form-control-sm vital-signs ml-2" v-model="formData.weight">
                               &nbsp Spo2:<input type="number" class="form-control form-control-sm vital-signs ml-2" v-model="formData.spo2">
                           </div>
                       </td>
                   </tr>
                   <tr v-if="formData.vital_sign_update_required">
                       <td class="pl-6" colspan="2">Cause:</td>
                       <td colspan="12">
                           <textarea class="form-control" v-model="formData.vital_sign_update_cause"></textarea>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">2.2. Body Check:</td>
                       <td colspan="12">
                           <textarea class="form-control" v-model="formData.body_check"></textarea>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">2.3. Lab-work</td>
                       <td colspan="12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" v-model.number="formData.internal_lab"/>
                                <label class="form-check-label">Internal</label>
                            </div>
                           <div class="form-check form-check-inline">
                               <input type="checkbox" class="form-check-input" v-model="accessory.show_external_lab"/>
                               <label class="form-check-label">External</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline"colspan="2" >2.4. Consultation</td>
                       <td colspan="12">
                           <div class="form-check form-check-inline">
                               <input type="checkbox" class="form-check-input" v-model.number="accessory.show_internal_consultation"/>
                               <label class="form-check-label">Internal</label>
                           </div>
                           <div class="form-check form-check-inline">
                               <input type="checkbox" class="form-check-input" v-model.number="accessory.show_external_consultation"/>
                               <label class="form-check-label">External</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <th colspan="2">B.3. Diagnose: <span class="text-danger" v-if="$v.formData.diag_codes.$error">You must add at least a diagnosic code</span></th>
                   </tr>
                   <tr>
                       <td class="pl-4" >Diagnose code:</td>
                       <td colspan="2">
                           <v-select :items="accessory.diag_code_list"
                                     label="Code"
                                     dense
                                     v-model="accessory.temporary_diag_code.code"
                           >
                               <template v-slot:selection="{ item, index }">
                                   <v-chip  small
                                   >{{ item.code }}</v-chip>
                               </template>
                               <template v-slot:item="{ active, item, attrs, on }">
                                   <v-list-item v-on="on" v-bind="attrs" #default="{ active }">
                                       <v-list-item-action>
                                           <v-checkbox :input-value="active"></v-checkbox>
                                       </v-list-item-action>
                                       <v-list-item-content>
                                           <v-list-item-title>
                                               <v-row no-gutters align="center">
                                                   <span>{{ "[" + item.code+ "]"+ item.description }}</span>
                                               </v-row>
                                           </v-list-item-title>
                                       </v-list-item-content>
                                   </v-list-item>
                               </template>
                           </v-select>
                       </td>
                       <td colspan="2">
                           <v-select dense v-model="accessory.temporary_diag_code.status" :items="accessory.status_list" label="status"></v-select>
                       </td>
                       <td colspan="5">
                        <textarea class="form-control form-control-sm"
                                  placeholder="Details"
                                  v-model="accessory.temporary_diag_code.details">

                        </textarea>
                       </td>
                       <td>
                           <v-btn x-small text @click="add_diagCode" class="table-title">Add</v-btn>
                       </td>
                   </tr>
                   <tr v-for="(diag,i) in formData.diag_codes" class="diag-code-list" v-if="formData.diag_codes.length>0">
                       <td style="background-color: white"></td>
                       <td colspan="2">{{diag.code.code}}</td>
                       <td colspan="2">{{diag.status}}</td>
                       <td colspan="4">
                           {{diag.details}}
                           <v-btn
                               x-small
                               icon
                               @click="delete_diag_code(i)"
                               class="float-right"
                           >
                               <v-icon> mdi-delete</v-icon>
                           </v-btn>
                       </td>
                   </tr>
                   <tr>
                       <th colspan="2">B.4. Treatment:</th>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline"  colspan="2">4.1. Medication:</td>
                       <td colspan="4">
<!--                           <multiselect-->
<!--                               v-model="accessory.medication.item"-->
<!--                               label="description"-->
<!--                               track-by="description"-->
<!--                               :id="'multiSelect'"-->
<!--                               open-direction="above"-->
<!--                               :options="accessory.medicines_temp_list"-->
<!--                               :searchable="true"-->
<!--                               :internal-search="false"-->
<!--                               :clear-on-select="true"-->
<!--                               :close-on-select="true"-->
<!--                               :show-no-results="false"-->
<!--                               :hide-selected="true"-->
<!--                               @search-change="fetchItem"-->
<!--                               class="multiSelect"-->
<!--                               autocomplete="off"-->
<!--                           >-->
<!--                           </multiselect>-->
                           <multiselect
                               v-model="accessory.medication.item"
                               :custom-label="nameWithCode"
                               track-by="description"
                               :id="'multiSelect'"
                               placeholder="search medicines here"
                               :options="accessory.avalaible_medicines"
                               :clear-on-select="true"
                               :close-on-select="true"
                               :hide-selected="true"
                               class="multiSelect"
                               autocomplete="off"
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
                           <input type="number" placeholder="Nb of days" class=" form-control " v-model="accessory.medication.nb_of_day"/>
                       </td>
<!--                       <td>-->

<!--                           <input type="number" readonly class="form-control" value="(parseInt(accessory.medication.breakfast) + parseInt(accessory.medication.lunch) + parseInt(accessory.medication.dinner))* accessory.medication.to_give" v-model="accessory.medication.to_give"/>-->
<!--                       </td>-->
                       <td>
                           <v-btn x-small text @click="add_medication" class="table-title">Add</v-btn>
                       </td>
                   </tr>
                   <tr v-for="(item,i) in formData.medication" class="diag-code-list">
                       <td style="background-color: white"></td>
                       <td colspan="4">{{item.item.description}}</td>
                       <td class="text-center">{{item.breakfast}}</td>
                       <td class="text-center">{{item.lunch}}</td>
                       <td class="text-center">{{item.dinner}}</td>
                       <td class="text-center">
                           {{item.nb_of_day}} &nbsp

                           <v-btn
                               class="float-right"
                               x-small
                               icon
                               @click="delete_medication_line(i)"
                           >
                               <v-icon> mdi-delete</v-icon>
                           </v-btn>

                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">4.2. Wound care</td>
                       <td>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="woundcare" id="woundcare1" value="1" v-model="formData.wound_care">
                               <label class="form-check-label" for="woundcare1">Yes</label>
                           </div>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="woundcare" id="woundcare2" value="0" v-model="formData.wound_care">
                               <label class="form-check-label" for="woundcare2">No</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">4.3. Stitches</td>
                       <td>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="stitches" id="stitches1" value="1" v-model.number="formData.stitches">
                               <label class="form-check-label" for="stitches1">Yes</label>
                           </div>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="stitches" id="stitches2" value="0" v-model.number="formData.stitches">
                               <label class="form-check-label" for="stitches2">No</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">4.4. Nebulizer</td>
                       <td>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="nebulizer" id="nebulizer1" value="1" v-model.number="formData.nebulizer">
                               <label class="form-check-label" for="nebulizer1">Yes</label>
                           </div>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="nebulizer" id="nebulizer2" value="0" v-model.number="formData.nebulizer">
                               <label class="form-check-label" for="nebulizer2">No</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <td class="pl-4 text-decoration-underline" colspan="2">4.5. Vaccination:</td>
                       <td>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="nebulizer" id="vaccination1" value="1" v-model.number="formData.vaccination">
                               <label class="form-check-label" for="vaccination1">Yes</label>
                           </div>
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="vaccination" id="vaccination2" value="0" v-model.number="formData.vaccination">
                               <label class="form-check-label" for="nebulizer2">No</label>
                           </div>
                       </td>
                   </tr>
                   <tr>
                       <th class="pt-6" colspan="2">B.5. Outcome:</th>
                       <td colspan="4">
                           <v-select :items="accessory.outcome_list" dense chips v-model="formData.outcome"></v-select>
                       </td>
                   </tr>
               </table>
               <v-dialog
                   v-model="formData.internal_lab"
               >
                   <v-card>

                       <v-card-text class="p-2">
<!--                           <internal_lab :form_type="'request'" :admission="formData.admission"/>-->
                           <internal_lab :form_type="'request'" :admission="formData.admission"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog
                   v-model="accessory.show_overview"
               >
                   <v-card>

                       <v-card-text class="p-2">
                          <generalist_overview :patient_id="formData.admission.patient_id"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog
                   v-model="formData.outcome==='internal referral'"
               >
                   <v-card>
                       <v-card-text class="p-2">
<!--                           <internal_consultation  :admission="formData.admission"/>-->
                           <internal_referral :admission="formData.admission"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog
                   v-model="accessory.show_internal_consultation"
               >
                   <v-card>
                       <v-card-text class="p-2">
                          <internal_consultation  :admission="formData.admission"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog v-model="formData.outcome==='external referral'">
                   <v-card>
                       <v-card-text class="p-2">
                           <external_referral :admission="formData.admission"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog v-model="accessory.show_external_consultation">
                   <v-card>
                       <v-card-text class="p-2">
                           <external_consultation :admission="formData.admission"/>
                       </v-card-text>
                   </v-card>
               </v-dialog>
               <v-dialog v-model="accessory.show_external_lab">
                   <v-card>
                       <v-card-text class="p-2">
                           <external_lab  :admission="formData.admission"></external_lab>
                       </v-card-text>
                   </v-card>
               </v-dialog>

<!--               <v-expansion-panels>-->
<!--                   <v-expansion-panel v-if="formData.internal_lab" inset>-->
<!--                       <v-expansion-panel-header class="table-title">-->
<!--                           C.1.  Internal Lab-work-->
<!--                       </v-expansion-panel-header>-->
<!--                       <v-expansion-panel-content>-->
<!--                          <internal_lab :form_type="'request'"/>-->
<!--                       </v-expansion-panel-content>-->
<!--                   </v-expansion-panel>-->
<!--                   <v-expansion-panel v-if="formData.external_lab" inset>-->
<!--                       <v-expansion-panel-header class="table-title">-->
<!--                           C.2. External Lab-work-->
<!--                       </v-expansion-panel-header>-->
<!--                       <v-expansion-panel-content>-->
<!--                           <external_lab/>-->
<!--                       </v-expansion-panel-content>-->
<!--                   </v-expansion-panel>-->
<!--                   <v-expansion-panel v-if="formData.internal_consultation" inset>-->
<!--                       <v-expansion-panel-header class="table-title">-->
<!--                           D.1. Internal Consultation-->
<!--                       </v-expansion-panel-header>-->
<!--                       <v-expansion-panel-content>-->
<!--                           <internal_consultation  :admission="formData.admission"/>-->
<!--                       </v-expansion-panel-content>-->
<!--                   </v-expansion-panel>-->
<!--                   <v-expansion-panel v-if="formData.outcome==='internal referral'" inset>-->
<!--                       <v-expansion-panel-header class="table-title">-->
<!--                           E.1. Internal Referral-->
<!--                       </v-expansion-panel-header>-->
<!--                       <v-expansion-panel-content>-->
<!--                           <internal_referral :admission="formData.admission" />-->
<!--                       </v-expansion-panel-content>-->
<!--                   </v-expansion-panel>-->
<!--               </v-expansion-panels>-->
           </div>
           <div class="text-right mt-6">
               <v-btn color="info"  @click="submit">submit</v-btn>
           </div>
       </v-app>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import Generalist_overview from "./generalist_overview";
import moment from "moment"
import Patient_information from "../../../components/patient_information";
import Internal_lab from "../labwork/internal/internal_lab";
import External_lab from "../labwork/external/external_lab";
import Internal_referral from "../../../components/internal_referral";
import Internal_consultation from "../../../components/internal_consultation";
import External_referral from "../../../components/external_referral";
import External_consultation from "../../../components/external_consultation";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "generalist_admission",
    props: ['admission'],
    components: {
        External_consultation,
        External_referral,
        Generalist_overview,
        Internal_lab, Internal_consultation, Internal_referral, External_lab, Patient_information},
    mixins: [validationMixin],
    data() {
        return {
            formData: {
                id: '',
                new_case: '',
                admission: {
                    patient: {
                        firstName: '',
                        lastName: '',
                        tel: '',
                        birthDate: '',
                        adress: ''
                    }
                },
                admission_id: '',
                symptoms: '',
                body_check: '',
                appointment: '',
                medication: [],
                taDia: '',
                taSysto: '',
                temp: '',
                weight: '',
                spo2: '',
                vital_sign_update_required: false,
                vital_sign_update_cause: '',
                diag_codes: [],
                vaccination: false,
                internal_lab:false,
                external_lab:false,
                internal_consultation:false,
                external_consultation:false,
                wound_care: '',
                stitches: '',
                nebulizer: '',
                outcome:''
            },
            accessory: {
                dateConfig: {
                    type: 'string',
                    mask: 'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                },
                diag_code_list: [],
                medicines_temp_list: [],
                additional_consultation: ['Anesthetist', 'Senior'],
                status_list: ['Confirmed', 'Suspicion','Exclusion'],
                outcome_list:['treated','internal referral','external referral','continuous treatment','death'],
                medication: {
                    item: null,
                    breakfast: null,
                    lunch: null,
                    dinner: null,
                    to_give: null,
                    nb_of_day:null
                },
                temporary_diag_code: {
                    code: null, status: null, details: null
                },
                show_overview:false,
                show_internal_consultation:false,
                show_external_consultation:false,
                show_internal_referral:false,
                show_external_referral:false,
                show_external_lab:false,
                avalaible_medicines:[]
            }
        }
    },
    validations: {
        formData: {
            new_case: {required},
            symptoms: {required},
            diag_codes:minLength(1)
        }
    },
    created() {
        if (Object.keys(this.$route.params).length > 0) this.formData.admission = this.$route.params.admission
        this.init()
    },
    methods: {
        async init() {
            await axios.get('/api/v1/patient_system/out_patient/generalist/diag_codes').then(response => this.accessory.diag_code_list = response.data)
            await this.load_medicines()
        },
        async fetchItem(code) {
            this.accessory.medicines_temp_list = [];
            if (code.length > 2) {
                await axios({
                    method: 'GET',
                    url: '/api/v1/inventory_system/item',
                    params: {search_text: code},
                }).then((response) => {
                    this.accessory.medicines_temp_list = response.data.data
                });
            }
        },
        async load_medicines(){
            await axios.get('/api/v1/inventory_system/item/authorized_service/graceCenter').then(response=>{
                this.accessory.avalaible_medicines=response.data
            })
        },
        add_medication() {
            let valid=false
            let arr=(Object.values(this.accessory.medicines_temp_list))
            valid = arr.indexOf(null) === -1;
            if(valid){
                this.accessory.medication.to_give=(parseFloat(this.accessory.medication.breakfast) + parseFloat(this.accessory.medication.lunch) + parseFloat(this.accessory.medication.dinner))* this.accessory.medication.nb_of_day
                this.formData.medication.push(this.accessory.medication)
                this.accessory.medication = {
                    item: null,
                    breakfast: '',
                    lunch: '',
                    dinner: '',
                    to_give: ''
                }
            }
        },
        delete_medication_line(i) {
            this.formData.medication.splice(i, 1)
        },
        async submit() {
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.responsible = window.auth.user.name
            await axios.post('/api/v1/patient_system/out_patient/generalist/consultation', this.formData).then(response => {
                if (response.data.success) {
                    this.$toast.open({position: 'top-right', type: 'success', message: response.data.msg})
                    this.reset_form()
                    this.$v.$reset()
                }
            })
        },
        reset_form() {
            this.formData =  {
                id: '',
                new_case: '',
                admission: {
                    patient: {
                        firstName: '',
                        lastName: '',
                        tel: '',
                        birthDate: '',
                        adress: ''
                    }
                },
                admission_id: '',
                symptoms: '',
                medical_care_needed: '',
                details: '',
                appointment: '',
                medication: [],
                taDia: '',
                taSysto: '',
                temp: '',
                weight: '',
                spo2: '',
                vital_sign_update_required: false,
                vital_sign_update_cause: '',
                body_check: '',
                diag_codes: [],
                wound_care: '',
                stitches: '',
                nebulizer: '',
                outcome:'',
                vaccination: false,
                internal_lab:false,
                external_lab:false,
                internal_consultation:false,
                external_consultation:false
            }
        },
        add_diagCode() {
            let valid=false
            let arr=(Object.values(this.accessory.temporary_diag_code))
            valid = arr.indexOf(null) === -1;
            if (valid) {
                this.formData.diag_codes.push(this.accessory.temporary_diag_code)
                this.accessory.temporary_diag_code = {
                    code: null, status: null, details: null
                }
            }

        },
        delete_diag_code(i){
            this.formData.diag_codes.splice(i,1)
        },
        nameWithCode ({ code, description }) {
            return `${code} — [${description}]`
        },
    }
}
</script>

<style scoped>
.form-title {
    font-size: 3rem;
    letter-spacing: 5px;
}
.table-title{
    background-color: #1390C6;
    color:white;
}
.main-container{
    margin-top:5px;
}
.multiSelect >>>.multiselect__tags{
    height: 10px;
    padding-top:0px !important;
    padding-bottom:0px !important;
}
.vital-signs{
    width:65px;
}
.diag-code-list{
    background-color: lightgray;
}
.vt{
   min-width: 100% !important;
}
</style>
