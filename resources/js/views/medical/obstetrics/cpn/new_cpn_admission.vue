<template>
<div class="container-fluid">
<v-app>
    <div class="d-flex flex-row justify-content-between">
        <h1 id="title">PRENATAL CARE FIRST CHECKUP</h1>
        <p>
            <i>Date: {{ today }}</i>

        </p>
    </div>
    <table class="table table-sm" id="patient_details_table">
        <tbody>
            <tr>
                <td colspan="9" class="table_title">
                    Patient's Details
                </td>
            </tr>
            <tr>
                <td style="width: 12% !important">
                    Id {{ formData.patient_id }}
                </td>
                <td colspan="4">Name: {{ fullName }}</td>
                <td style="width: 10% !important">D.O.B:</td>
                <td>
                    {{
                        $route.params.admission.patient.birthDate
                    }}
                </td>
                <td>
                    <span
                        class="text-nowrap"
                        :class="{ 'text-danger': parseInt(age) < 18 }"
                    >Age: {{ age }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 30% ">Address: {{ $route.params.admission.patient.adress }}</td>
                <td> Tel: {{ $route.params.admission.patient.tel }}</td>
                <td colspan="2">Height: <span
                    :class="{ 'text-danger': $route.params.admission.patient.height <= 150 }">
                        {{ $route.params.admission.patient.height }}
                    </span>
                </td>
                <td>
                    Weight:
                    <span
                        :class="{'text-success': bmi === 'normal', 'text-danger': bmi !== 'normal', }">
                      {{bmi}}
                    </span>
                    <span v-if="$v.formData.weight.$error" class="text-danger">
                      weight is required.
                    </span>
                </td>
                <td>
                    <input
                        type="number"
                        v-model="formData.weight"
                        style="width:70px"
                        class="border"
                        :class="{ 'border border-danger': $v.formData.weight.$error }"
                    />
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table  table-sm" id="pregnancy_details_table">
        <tbody>
            <tr>
                <td colspan="11" class="table_title">
                    Pregnancy General Information
                    <span class="text-danger">{{ gravida_check }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 15% !important" >LPD</td>
                <td class="narrow">GA</td>
                <td class="narrow" >EDD Method</td>
                <td class="narrow" >EDD Calc</td>
                <td class="narrow" >EDD US</td>
                <td class="narrow" >EDD Corrected</td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col" v-if="ultrasound_data.last_period_date===''">
                            <div class="form-check" >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    v-model="ultrasound_data.unknown_lpd"
                                />
                                <label class="form-check-label">unknown</label>
                            </div>
                        </div>
                        <div class="col">
                            <date-picker
                                v-model="ultrasound_data.last_period_date"
                                v-if="!ultrasound_data.unknown_lpd"
                                :input-debounce="500"
                                mode="date"
                                :model-config="dateConfig"
                                :masks="dateConfig.masks"

                            >
                                <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                        class="bg-white border px-2 py-1 rounded"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                        readonly
                                        style="max-width: 100px"
                                    />
                                </template>
                            </date-picker>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="text-center" v-if="!is_field_edited" @click="is_field_edited = ! is_field_edited">{{current_gestational_age}}</span>
                    <div class="form-check-inline" v-if="is_field_edited">
                        <gestational-age v-model="new_gestational_age"  />
                        <v-btn
                            class="mx-2"
                            fab
                            dark
                            x-small
                            color="primary"
                            @click="update_gestational_age"
                            v-if="!is_ga_updated && new_gestational_age!==''"
                        >
                            <v-icon dark>
                                mdi-cached
                            </v-icon>
                        </v-btn>
                    </div>
                </td>
                <td>
                    <select v-model="ultrasound_data.edd_method" class="border" @change="update_ultrasound_edd('edd_method')">
                        <option value="calc">calc</option>
                        <option value="us">US</option>
                        <option value="corrected">corrected</option>
                    </select>
                </td>
                <td>
                    <date-picker
                        v-model="ultrasound_data.edd_calculated"
                        :input-debounce="500"
                        mode="date"
                        :model-config="dateConfig"
                        :masks="dateConfig.masks"
                        @input="update_ultrasound_edd('edd_calculated')"
                    >
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="
                              bg-white
                              form-control form-control-sm
                              px-2
                              py-1
                              rounded
                            "
                                :value="inputValue"
                                v-on="inputEvents"
                                :class="{
                              'text-success': formData.edd_method === 'calc',
                            }"
                            />
                        </template>
                    </date-picker>
                </td>
                <td>
                    <date-picker
                        v-model="ultrasound_data.edd_ultrasound"
                        :input-debounce="500"
                        mode="date"
                        :model-config="dateConfig"
                        :masks="dateConfig.masks"
                        @input="update_ultrasound_edd('edd_ultrasound')"
                    >
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="
                              bg-white
                              form-control form-control-sm
                              px-2
                              py-1
                              rounded
                            "
                                :value="inputValue"
                                v-on="inputEvents"
                                :class="{
                              'text-success': formData.edd_method === 'calc',
                            }"
                            />
                        </template>
                    </date-picker>
                </td>
                <td>
                    <date-picker
                        v-model="ultrasound_data.edd_corrected"
                        :input-debounce="500"
                        mode="date"
                        :model-config="dateConfig"
                        :masks="dateConfig.masks"
                        @input="update_ultrasound_edd('edd_corrected')"
                    >
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="
                              bg-white
                              form-control form-control-sm
                              px-2
                              py-1
                              rounded
                            "
                                :value="inputValue"
                                v-on="inputEvents"
                                :class="{
                              'text-success': formData.edd_method === 'calc',
                            }"
                            />
                        </template>
                    </date-picker>
                </td>
            </tr>
            <tr>
                <td class="narrow">G</td>
                <td class="narrow">P</td>
                <td class="narrow">A</td>
                <td class="narrow">M</td>
                <td class="narrow">LC<small>(EV)</small></td>
                <td class="narrow">LD<small>(DDA)</small></td>
            </tr>
            <tr>
               <td>
                   <input
                       type="number"
                       v-model="formData.gravida"
                       :class="{ 'text-danger': formData.gravida > 4 }"
                       class="form-control form-control-sm"
                       min="1"
                       @input="gravida_input"
                   />
               </td>
                <td>
                    <input
                        type="number"
                        v-model="formData.parity"
                        class="form-control form-control-sm"
                        min="0"
                    />
                </td>
                <td class="border">
                    <input
                        type="number"
                        v-model="formData.abortion"
                        :class="{ 'text-danger': formData.abortion > 0 }"
                        class="form-control form-control-sm"
                        min="0"
                    />
                </td>
                <td class="border">
                    <input
                        type="number"
                        v-model="formData.miscarriage"
                        :class="{ 'text-danger': formData.miscarriage > 0 }"
                        class="form-control form-control-sm"
                        min="0"
                    />
                </td>
                <td class="border">
                    <input
                        type="number"
                        v-model="formData.ev"
                        class="form-control form-control-sm"
                    />
                </td>
                <td class="border">
                    <input
                        type="number"
                        class="form-control form-control-sm"
                        v-model="formData.dda"
                        :class="{
                    'text-danger font-weight-bold error':
                      $v.formData.dda.$error,
                  }"
                        min="1980"
                        :max="new Date().getFullYear()"
                        @blur="validate_dda($event.target.value)"
                    />
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-6 col-md-4   col-lg-3">
            Based on the data above, is the patient at risk?
        </div>
        <div class="col">
            <select class="border" style="width:50px" v-model.number="formData.patient_at_risk">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>
    <textarea class="border"
        v-if="formData.patient_at_risk"
        v-model="formData.risk_description"
        placeholder="Write here the reason"
        :class="{'text-danger font-weight-bold error mt-2':$v.formData.risk_description.$error}"
    ></textarea>
    <table class="table-sm table mt-2">
        <tr>
            <td>Preeclampsia prevention</td>
            <td>High frequency prenatal care</td>
            <td>OGTT needed</td>
            <td>Planned C-section</td>
            <td>Date</td>
            <td>Planned induction</td>
        </tr>
        <tr>
            <td>
                <yes-or-no  v-model.number="formData.preeclampsia_needed" :value="formData.preeclampsia_needed"/>
            </td>
            <td>
                <yes-or-no  v-model.number="formData.high_frequency_prenatal_care" :value="formData.high_frequency_prenatal_care"/>
            </td>
            <td>
                <yes-or-no  v-model.number="formData.ogtt_needed" :value="formData.ogtt_needed"/>
            </td>
            <td>
                <yes-or-no  v-model.number="formData.planned_oc" :value="formData.planned_oc"/>
            </td>
            <td style="width:16%">
                <date-picker
                    v-model="formData.planned_oc_date"
                    class="d-block"
                    v-if="formData.planned_oc"
                    :input-debounce="500"
                    mode="date"
                    :model-config="dateConfig"
                    :masks="dateConfig.masks"
                >
                    <template v-slot="{ inputValue, inputEvents }">
                        <input
                            class="
                              bg-white
                              form-control form-control-sm
                              px-2
                              py-1
                              rounded
                            "
                            :value="inputValue"
                            v-on="inputEvents"
                            readonly
                        />
                    </template>
                </date-picker>
            </td>
            <td>
                <yes-or-no  v-model.number="formData.planned_induction"/>
            </td>
        </tr>
        <tr>
            <td>Take blood pressure medication</td>
            <td>
                <date-picker
                    v-model="formData.blood_pressure_medication_start_date"
                    class="d-block"
                    :input-debounce="500"
                    mode="date"
                    :model-config="dateConfig"
                    :masks="dateConfig.masks"
                    :max-date="new Date()"
                >
                    <template v-slot="{ inputValue, inputEvents }">
                        <input
                            class="
                                bg-white
                                form-control form-control-sm
                                px-2
                                py-1
                                rounded
                              "
                            :value="inputValue"
                            v-on="inputEvents"
                            readonly
                        />
                    </template>
                </date-picker>
            </td>
        </tr>
    </table>
  <div class="d-flex">
      <v-chip class="ma-2" color="red" label text-color="white">
          Blood test result
         <v-icon>mdi-blood-bag</v-icon>
      </v-chip>
  </div>
    <table class="table table-sm">
        <tr>
            <td>Blood Group</td>
            <td>Rhesus</td>
            <td> [HIV]</td>
            <td> [Syphilis]</td>
            <td> [HB]</td>
        </tr>
        <tr>
            <td>
                <select v-model="formData.blood_group" class="form-control form-control-sm">
                    <option v-for="bg in blood_group" :value="bg.name">{{ bg.name }}</option>
                </select>
            </td>
            <td>
                <select v-model="formData.rhesus" class="form-control form-control-sm" >
                    <option value="+">+</option>
                    <option value="-">-</option>
                </select>
            </td>
            <td>
                <select
                    v-model="formData.hiv"
                    :class="{ 'text-danger': formData.hiv === 'Positive' }" class="form-control form-control-sm"
                >
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>
                </select>
            </td>
            <td>
                <select
                    v-model="formData.syphilis"
                    :class="{ 'text-danger': formData.syphilis === 'Positive' }" class="form-control form-control-sm"
                >
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>
                </select>
            </td>
            <td>
                <input type="text" v-model="formData.hb" class="form-control form-control-sm" />
            </td>
        </tr>
    </table>
    <p class="table_title p-1" >
        Pregnancy history
        <v-btn
            class="mx-2 d-print-none"
            fab
            dark
            color="indigo"
            x-small
            @click="add_row"
        >
            <v-icon dark> mdi-plus </v-icon>
        </v-btn>
    </p>
    <div class="p-2" v-for="(row,i) in formData.pregnancy_history ">
        <pregnancy_history_form v-model="formData.pregnancy_history[i]" :value="formData.pregnancy_history[i]" @delete_row="delete_pregnancy_row(i)"/>
    </div>

    <div class="border border-primary p-1">
        <div class="d-flex">
            <v-chip  color="cyan darken-2" label text-color="white">
                More info about the patient
                <v-icon>mdi-account</v-icon>
            </v-chip>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Any presence of disabilities</label>
                    <input type="text" v-model="formData.preg_wom_disability" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Chronical diseases (diabetes,hypertension...)</label>
                    <input type="text" v-model="formData.preg_wom_chronical_disease" class="form-control form-control-sm"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Former serious illness</label>
                    <input type="text" v-model="formData.preg_wom_former_illness" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Bleeding</label>
                    <input type="text" v-model="formData.preg_wom_bleeding" class="form-control form-control-sm"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Permanent</label>
                    <input type="text" v-model="formData.preg_wom_medication" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Allergies</label>
                    <input type="text" v-model="formData.preg_wom_allergie" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Hematoma
                    <yes-or-no  class="mt-2" v-model="formData.preg_wom_haematoma"/>
                </div>
            </div>
        </div>
    </div>
    <div class="border border-primary p-1 mt-2">
        <div class="d-flex">
            <v-chip  color="cyan darken-2" label text-color="white">
                Info about the patient's close family
                <v-icon>mdi-account-multiple</v-icon>
            </v-chip>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Is there a twins?</label>
                    <input type="text" v-model="formData.close_family_twins" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Any c-section case</label>
                    <input type="text" v-model="formData.close_family_oc" class="form-control form-control-sm"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Chronical disease (diabetes,hypertension...)</label>
                    <input type="text" v-model="formData.close_family_disease" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Malformation</label>
                    <input type="text" v-model="formData.close_family_malformation" class="form-control form-control-sm"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Dead baby</label>
                    <yes-or-no v-model="formData.close_family_dead_baby"/>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Miscarriage</label>
                    <yes-or-no v-model="formData.close_family_miscarriage"/>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Problems in the pregnancy</label>
                    <input type="text" v-model="formData.close_family_prob_in_preg" class="form-control form-control-sm"/>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered mt-2">
        <tr>
            <td colspan="7" class="table_title">Pelvimetrie</td>
        </tr>
        <tr>
            <td>Dist.Spin[cm]</td>
            <td>Dist.Christ[cm]</td>
            <td>Dist.Troch[cm]</td>
            <td>Dist.Obst[cm]</td>
            <td>Michaelis rhombus</td>
            <td>Baum-HG</td>
            <td>Problem for delivery</td>
        </tr>
        <tr>
            <td>
                <input type="number" v-model="formData.spin" :class="{ 'text-danger error': $v.formData.spin.$error }" class="form-control form-control-sm" />
            </td>
            <td>
                <input type="number" v-model="formData.christ" :class="{ 'text-danger error': $v.formData.christ.$error }" class="form-control form-control-sm" />
            </td>
            <td>
                <input type="number" v-model="formData.troch" :class="{ 'text-danger error': $v.formData.troch.$error }" class="form-control form-control-sm" />
            </td>
            <td>
                <input type="number" v-model="formData.obst" :class="{ 'text-danger error': $v.formData.obst.$error }" class="form-control form-control-sm" />
            </td>
            <td>
                <select
                    v-model="formData.michaelis" class="form-control form-control-sm"
                    :class="{'text-danger': formData.michaelis !== 'Equal','text-danger error': $v.formData.michaelis.$error, }"
                >
                    <option class="text-dark bg-light" value="Equal">Equal</option>
                    <option class="text-dark bg-light" value="Narrow">   Narrow  </option>
                    <option class="text-dark bg-light" value="Symmetric">  Symmetric </option>
                    <option class="text-dark bg-light" value="Asymmetric">    Asymmetric                    </option>
                </select>
            </td>
            <td>
                <select
                    v-model="formData.baum_hg" class="form-control form-control-sm"
                    :class="{'text-danger': formData.baum_hg === 'Negative', 'text-danger error': $v.formData.baum_hg.$error,}"
                >
                    <option class="text-dark bg-light" value="Positive"> Positive</option>
                    <option class="text-dark bg-light" value="Negative">  Negative</option>
                </select>
            </td>
            <td>
                <yes-or-no v-model="formData.problem_for_delivery"/>
            </td>
        </tr>
    </table>
   <div class="d-flex">
       <v-btn small color="purple" class="mt-2" @click="submit" :loading="form_is_submitting" v-if=" ! $route.params.cpn_admission">Submit</v-btn>
   </div>
</v-app>
</div>
</template>

<script>
import { validationMixin } from "vuelidate";
import moment from "moment"
import Pregnancy_history_form from "./pregnancy_history_form";
import GestationalAge from "../../../../components/gestational_age_control";
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
    name: "new_cpn_admission",
    components: {GestationalAge, Pregnancy_history_form},
    props: ["is_overview", "reference"],
    mixins: [validationMixin],
    data(){
        return{
            formData: {
                created_at: new Date(),
                patient_id: "",
                admission_id: "",
                ultrasound_admission_id: null,
                weight: "",
                hydrodramnion: false,
                oligodramnion: false,
                ddr: "",
                unknown_lpd: false,
                edd_calc: "",
                edd_ultrasound: "",
                edd_corrected: "",
                edd_method: "",
                gestational_age: null,
                gravida: "",
                parity: "",
                abortion: "",
                miscarriage: "",
                ev: "",
                dda: "",
                patient_at_risk: null,
                risk_description: "",
                preeclampsia_needed: null,
                high_frequency_prenatal_care: null,
                ogtt_needed: null,
                planned_oc: null,
                planned_oc_date: "",
                planned_induction: null,
                takes_blood_pressure_medication: null,
                blood_pressure_medication_start_date: null,
                blood_group: "",
                rhesus: "",
                hiv: "",
                syphilis: "",
                other_test: "",
                other_test_descr: "",
                hb: "",
                close_family_twins: "",
                close_family_oc: "",
                close_family_disease: "",
                close_family_malformation: null,
                close_family_dead_baby: null,
                close_family_prob_in_preg: "",
                close_family_miscarriage: null,
                preg_wom_bleeding: null,
                preg_wom_haematoma: null,
                preg_wom_medication: "",
                preg_wom_chronical_disease: "",
                preg_wom_allergie: "",
                preg_wom_former_illness: "",
                preg_wom_disability: "",
                updated_at: "",
                pregnancy_history: [],
                spin: "",
                christ: "",
                troch: "",
                obst: "",
                michaelis: "",
                baum_hg: "",
                problem_for_delivery: null,
                responsible: "",
            },
            current_gestational_age:'',
            blood_group:[],
            birth_problems:[],
            ultrasound_data:{
                unknown_lpd: false,
                last_period_date:'',
                edd_calculated:'',
                edd_ultrasound: '',
                edd_corrected: '',
                edd_method:''
            },
            dateConfig: {
                type: "string",
                mask: "iso",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
            is_field_edited:false,
            new_gestational_age:'',
            is_ga_updated:false,
            form_is_submitting:false,
            form_is_new:true
        }
    },
    validations: {
        formData: {
            patient_id: { required },
            dda: { between: between(1980, new Date().getFullYear()) },
            weight: { required },
            pregnancy_history: {
                $each: {
                    nr_year: {
                        required,
                        between: between(1980, new Date().getFullYear()),
                    },
                },
            },
            risk_description: {
                required: requiredIf((formData) => formData.patient_at_risk),
            },
            spin: { required },
            christ: { required },
            troch: { required },
            obst: { required },
            michaelis: { required },
            baum_hg: { required },
        },
    },
    created(){
        this.init()
    },
    methods:{
        calculateAge(birthDate) {
            if (birthDate !== "") {
                var difference = Date.now() - new Date(birthDate).getTime();
                var age = new Date(difference);
                return Math.abs(age.getUTCFullYear() - 1970);
            }
        },
        nullToString(txt){
            return txt===null ? '' : txt
        },
        async init(){
            if(this.$route.params.cpn_admission){
                this.formData= {...this.$route.params.cpn_admission}
                axios.get(`/api/v1/patient_system/out_patient/obstetrical/cpn/pregnancy_history/${this.$route.params.cpn_admission.patient_id}`).then(
                    response=>{this.formData.pregnancy_history=response.data.pregnancy_histories}
                )
            }
            this.formData.admission_id=this.$route.params.admission.id
            this.formData.patient_id=this.$route.params.admission.patient.id
            axios.get("/api/v1/extra/blood_group").then((response) => (this.blood_group = response.data))
            axios.get("/api/v1/extra/pregnancy_problem").then((response) => (this.birth_problems = response.data))
            this.get_ultrasound_data()


        },
        async get_ultrasound_data(){
        axios.get("/api/v1/patient_system/out_patient/obstetrical/cpn/get_ultrasound_admission_data/" + this.formData.patient_id).then(
            response=>{
                console.log(response.data)
                this.ultrasound_data=response.data
               this.current_gestational_age = this.calculate_ga(response.data.edd_method,response.data)
            }
        )
        },
        validate_dda() {
            if (
                this.formData.dda < 1980 ||
                this.formData.dda > new Date().getFullYear()
            )
                this.formData.dda = "";
        },
        gravida_input() {
            if (this.formData.gravida == 1) this.formData.parity = this.formData.miscarriage = this.formData.abortion = this.formData.ev = 0;

        },
        toNull(val) {
            return val === "" ? 0 : val;
        },
        add_row() {
            this.formData.pregnancy_history.push({
                nr_year: "",
                pregnancy: "",
                birth_type: "",
                birth_place: "",
                birth_problems: "",
                baby_gender: "",
                infection: null,
                malformation: null,
                baby_condition: "",
                pueperium: "",
                sa: null,
                baby_weight: "",
                ourPatient: null,
            });
        },
        calculate_ga(method,src){
            let gestational_age
            // let src_date
            switch(method){
                case 'calc':
                   gestational_age= src['calculated_ga']
                break;
                case 'us':
                    gestational_age= src['ultrasound_ga']

                break;
                case 'corrected':
                    gestational_age= src['corrected_ga']
                break;
            }
            let src_date= src.updated_at
            const diff = new Date()- new Date(src_date);
            const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);
            const ga_weeks = Math.floor(diff_in_days / 7);
            let ga_days = diff_in_days % 7; // %
            console.log(gestational_age,ga_days)
            // splitting gestational age src
            let [left_ga,right_ga]= [parseInt(gestational_age.split('+')[0]),parseInt(gestational_age.split('+')[1])]
            // summing the right part
            let ga_in_days= ga_days+ right_ga
            let ga_in_week= ga_weeks+ left_ga
            console.log(ga_in_days)
            if(ga_in_days===7){
                ga_in_week++
                ga_in_days=0
            }else if(ga_in_days >= 8){
                // let check
                // if(ga_in_days===8) check=1
                ga_in_week++
                ga_in_days=Math.abs(6-ga_in_days)
            }
            // console.log(ga_in_week + "+"+ ga_in_days)
            console.log(ga_in_days)

            return ga_in_week + "+"+ ga_in_days
        },
        update_ultrasound_edd(edd){
            let formData={
                column:edd,
                new_val:this.ultrasound_data[edd]
            }
            axios.put("/api/v1/patient_system/out_patient/obstetrical/cpn/update_ultrasound_edd/" + this.ultrasound_data.id,formData).then(
                response=>{
                    if(response.data.success) this.$toast.open({
                        message:'data updated',
                        position:'top-right'
                    })
                }
            )
        },
        update_gestational_age(){
            let column
            switch(this.ultrasound_data.edd_method){
                case 'calc':
                column= 'calculated_ga'
                break;
                case 'us':
                    column= 'ultrasound_ga'
                break;
                case 'corrected':
                    column='corrected_ga'
                break;
            }
            let formData={
                column,
                new_val:this.new_gestational_age
            }
            axios.put("/api/v1/patient_system/out_patient/obstetrical/cpn/update_ultrasound_edd/" + this.ultrasound_data.id,formData).then(
                response=>{
                    if(response.data.success){
                        this.is_ga_updated=true
                    }
                }
            )

        },
        delete_pregnancy_row(i){
            this.formData.pregnancy_history.splice(i,1)
        },
        async submit() {
            this.$v.$touch();
            this.formData.responsible = window.auth.user.name;
            if (!this.$v.$invalid) {
                if (this.form_is_new) {
                    this.formData.ultrasound_data=this.ultrasound_data
                    this.formData.ultrasound_data.gestational_age=this.current_gestational_age
                    this.formData.ultrasound_admission_id=this.ultrasound_data.id
                    let response = await axios.post("/api/v1/patient_system/out_patient/obstetrical/cpn/admission", this.formData);
                    if (response.data.success) {
                        this.$toast.open({
                            message: `Reference: ${response.data.cpn_admission.id} `,
                            position: "top-right",
                            duration: 0,
                        });
                        this.$router.push({
                            name: "cpn_followup",
                            params: {
                                cpn_admission: response.data.cpn_admission,
                                admission:this.$route.params.admission
                            },
                        });
                    }
                }
                // else {
                //     let response = await axios.put(
                //         `/api/v1/patient_system/out_patient/obstetrical/cpn_admission/${this.accessory.reference}`,
                //         this.formData
                //     );
                //     if (response.data.success === true) {
                //         this.reset_form();
                //         this.$toast.open({
                //             message: `data successfully saved `,
                //             position: "top-right",
                //             type: "info",
                //         });
                //     }
                // }
            }
        },
    },
    computed:{
        today() {return new Date().toLocaleString();},
        fullName() {
            return  this.nullToString(this.$route.params.admission.patient.firstName) + " " + this.nullToString(this.$route.params.admission.patient.lastName)
        },
        age() {
            return this.calculateAge(this.$route.params.admission.patient.birthDate);
        },
        quick_birth() {
            let output = [];
            let diffArr = [];
            if (this.formData.pregnancy_history.length > 0) {
                for (let i = 0; i < this.formData.pregnancy_history.length; i++) {
                    output.push(this.formData.pregnancy_history[i].nr_year);
                }
                output.reverse();
                for (let i = 0; i < output.length; i++) {
                    diffArr.push(output[i] - output[i - 1]);
                }
                if (diffArr.indexOf(1) !== -1 || diffArr.indexOf(0) !== -1) return true;
            }
        },
        bmi() {
            if (!this.formData.weight || !this.$route.params.admission.patient.height) return null;

            let bmi =
                this.formData.weight / Math.pow(this.$route.params.admission.patient.height / 100, 2);
            switch (true) {
                default:
                    return "";
                    break;
                case bmi < 18.5:
                    return "underweight";
                    break;
                case bmi > 18.5 && bmi < 24.9:
                    return "normal";
                    break;
                case bmi > 25 && bmi < 29.9:
                    return "overweight";
                    break;
                case bmi > 30 && bmi < 34.9:
                    return "obesity class 1";
                    break;
                case bmi > 35 && bmi < 39.9:
                    return "obesity class 2";
                    break;
                case bmi > 40:
                    return "obesity class 3";
            }
        },
        gravida_check() {
            let total =
                parseInt(this.toNull(this.formData.parity)) +
                parseInt(this.toNull(this.formData.abortion)) +
                parseInt(this.toNull(this.formData.miscarriage));
            if (this.formData.gravida) {
                if (total > this.formData.gravida - 1) {
                    return "(P+A+M) should be less than G";
                }
            }
        },



    }
}
</script>

<style scoped>
.table_title {
    background-color: #1390c6 !important;
    color: white;
    font-weight: bold;
    /*-webkit-print-color-adjust: exact;*/
}
#title {
    margin-top: 10px;
    font-weight: bold;
    color:#FF80AB;
}

</style>
