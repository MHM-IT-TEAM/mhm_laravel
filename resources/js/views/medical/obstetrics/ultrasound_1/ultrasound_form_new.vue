<template>
    <div class="container-fluid vh-100">
        <v-card>
            <v-card-text>
                <p class="title"><v-icon class="text-white">mdi-stethoscope</v-icon> B) Medical Data</p>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label>Date of last period</label>
                       {{moment(admission.last_period_date).format("DD/MMM/YYYY")}}
                    </div>
                </div>
                <h6>Gestational age</h6>
                <table class="table table-sm">
                    <tr>
                        <td>Calculated</td>
                        <td>Ultrasound</td>
                        <td>Corrected</td>
                    </tr>
                    <tr>
                        <td>
                            <gestational-age v-model="accessory.calculated_ga"/>
                        </td>
                        <td>
                            <gestational-age v-model="accessory.ultrasound_ga"/>
                        </td>
                        <td>
                            <gestational-age v-model="accessory.corrected_ga"/>
                        </td>
                    </tr>
                </table>
                <v-tabs
                    v-model="accessory.tab"
                    background-color="primary"
                    dark
                    height="25"
                >
                    <v-tab
                        v-for="item in admission.fetuses"
                        :key="item.id"
                    >
                        F-{{ item.id }}
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="accessory.tab">
                    <v-tab-item
                        v-for="(item,i) in admission.fetuses"
                        :key="item.id"
                    >
                        <v-card flat>
                            <v-card-text>
                                <section>
                                    <div class="form-row">
                                        <div class="col">
                                            Intra uterine
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'intra_uterine'+i" :name="'intra_uterine'+i" class="custom-control-input" value="1" v-model.number="formData[i].intra_uterine">
                                                <label class="custom-control-label" :for="'intra_uterine'+i">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'intra_uterine'+i+1" :name="'intra_uterine'+i" class="custom-control-input" value="0" v-model.number="formData[i].intra_uterine">
                                                <label class="custom-control-label" :for="'intra_uterine'+i+1">No</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Embryo visible
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'embryo'+i" :name="'embryo'+i" class="custom-control-input" value="1" v-model.number="formData[i].embryo_visible">
                                                <label class="custom-control-label" :for="'embryo'+i">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'embryo'+i+1" :name="'embryo'+i" class="custom-control-input" value="0" v-model.number="formData[i].embryo_visible">
                                                <label class="custom-control-label" :for="'embryo'+i+1">No</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Heart beat
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'heart_beat'+i" :name="'heart_beat'+i" class="custom-control-input" value="1" v-model.number="formData[i].heart_beat">
                                                <label class="custom-control-label" :for="'heart_beat'+i">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'heart_beat'+i+1" :name="'heart_beat'+i" class="custom-control-input" value="0" v-model.number="formData[i].heart_beat">
                                                <label class="custom-control-label" :for="'heart_beat'+i+1">No</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Proportional growth
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'prop_growth'+i" :name="'prop_growth'+i" class="custom-control-input" value="1" v-model.number="formData[i].proportional_growth">
                                                <label class="custom-control-label" :for="'prop_growth'+i">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'prop_growth'+i+1" :name="'prop_growth'+i" class="custom-control-input" value="0" v-model.number="formData[i].proportional_growth">
                                                <label class="custom-control-label" :for="'prop_growth'+i+1">No</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Susp. for malformation
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'malformation1'+i" :name="'malformation1'+i" class="custom-control-input" value="1" v-model.number="formData[i].suspicion_for_malformation">
                                                <label class="custom-control-label" :for="'malformation1'+i">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" :id="'malformation1'+i+1" :name="'malformation1'+i" class="custom-control-input" value="0" v-model.number="formData[i].suspicion_for_malformation">
                                                <label class="custom-control-label" :for="'malformation1'+i+1">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            Placenta type
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <select v-model="formData[i].placenta_type">
                                                    <option value="" selected>choose</option>
                                                    <option v-for="type in accessory.placenta_type" :value="type.name">{{type.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Amniotic liquid
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <select v-model="formData[i].amniotic_liquid">
                                                    <option selected value="">choose</option>
                                                    <option v-for="liquid in accessory.amniotic_liquid">{{liquid}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Position of baby
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <select v-model="formData[i].position_of_baby">
                                                    <option value="" selected>choose</option>
                                                    <option v-for="pos in accessory.position_of_baby" :value="pos.name">{{pos.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            Presentation of baby
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <select v-model="formData[i].presentation_of_baby">
                                                    <option value="" selected>choose</option>
                                                    <option v-for="presentation in accessory.presentation_of_baby" :value="presentation.name">{{presentation.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            GA equality
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <select v-model="formData[i].ga_equality">
                                                    <option value="" selected>choose</option>
                                                    <option v-for="ga in accessory.ga_equality">{{ga}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-sm table-borderless mt-2">
                                        <tr>
                                            <td>HC</td>
                                            <td>AC</td>
                                            <td>FL</td>
                                            <td>GS</td>
                                            <td>CRL</td>
                                            <td>BPD</td>
                                            <td>EWB</td>
                                            <td>FHR</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].hc"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].ac"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].fl"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].gs"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].crl"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].bpd"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].ewb"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="number" v-model="formData[i].fhr"/>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea class="form-control form-control-sm" v-model="formData[i].remark"></textarea>
                                    </div>
                                </section>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
                <v-autocomplete
                    v-model="medical_staff"
                    :items="accessory.medical_staff"
                    outlined
                    dense
                    chips
                    small-chips
                    class="mt-4"
                    label="Medical Staff"
                    multiple
                ></v-autocomplete>
            </v-card-text>
        </v-card>
        <button
            class="btn btn-primary mt-12 float-right d-print-none"
            @click="submit"
        >
            Submit
        </button>
    </div>
</template>

<script>
import GestationalAge from "../../../../components/gestational_age_control";
import moment from 'moment'
export default {
    name: "ultrasound_form_new",
    components: {GestationalAge},
    props:['admission','admission_id'],
    data(){
        return{
            formData:[],
            medical_staff:'',
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
                    "Sitraka",
                    "Mihanta",
                    "Marlies",
                    "Dr Martin",
                    "Dr Petra",
                    "Hobilalaina",
                    "Ando",
                ],
                position_of_baby:[],
                presentation_of_baby:[],
                placenta_type:[],
                ga_equality:["<","=",">"],
                amniotic_liquid:["5","[5-20]","20",">20"],
                count_of_fetus:'',
                tab:null,
                calculated_ga:'',
                ultrasound_ga:'',
                corrected_ga:''
            },
        }
    },
    created(){
        this.init()
        this.get_calculated_ga()
    },
    methods:{
        init(){

            axios.get("/api/v1/extra/position_of_baby").then(response=>this.accessory.position_of_baby=response.data)
            axios.get("/api/v1/extra/presentation_of_baby").then(response=>this.accessory.presentation_of_baby=response.data)
            axios.get("/api/v1/extra/placenta_type").then(response=>this.accessory.placenta_type=response.data)
            this.accessory.count_of_fetus=this.admission.fetuses.length
            for(let i=0; i<this.accessory.count_of_fetus;i++){
                this.formData.push({
                    fetus_id:this.admission.fetuses[i].id,
                    ultrasound_admission_id:'',
                    hc:'',
                    ac:'',
                    fl:'',
                    gs:'',
                    crl:'',
                    bpd:'',
                    ewb:'',
                    fhr:'',
                    // last_period_date:'',
                    // unknown_lpd:'',
                    // edd_calculated:'',
                    // edd_ultrasound:'',
                    // edd_corrected:'',
                    // edd_method:'',
                    medical_staff:[],
                    calculated_ga:'',
                    ultrasound_ga:'',
                    corrected_ga:'',
                    placenta_type:'',
                    position_of_baby:'',
                    presentation_of_baby:'',
                    amniotic_liquid:'',
                    intra_uterine:'',
                    embryo_visible:'',
                    heart_beat:'',
                    proportional_growth:'',
                    suspicion_for_malformation:'',
                    ga_equality:'',
                    remark:'',
                    user_id:''
                })
            }
            this.formData.forEach(data=>{
                data.user_id=window.auth.user.id
                data.ultrasound_admission_id=this.admission.id
                data.ultrasound_type=this.admission.type_of_ultrasound_data.type_of_ultrasound
                data.extra_checkup_reason=this.admission.type_of_ultrasound_data.extra_checkup_reason
            })
        },
        get_calculated_ga() {
            if (this.admission.last_period_date) {
                const diff = new Date() -new Date(this.admission.last_period_date);
                const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);
                const ga_weeks = Math.floor(diff_in_days / 7);
                const ga_days = diff_in_days % 7;

                this.accessory.calculated_ga = ga_weeks + "+" + ga_days;
            } else {
                this.accessory.calculated_ga = null;
            }
        },
        submit(){
            this.formData.forEach(data=>{
                data.medical_staff=this.medical_staff_str
                data.calculated_ga=this.accessory.calculated_ga
                data.ultrasound_ga=this.accessory.ultrasound_ga
                data.corrected_ga=this.accessory.corrected_ga
                data.admission_id=this.admission_id
            })

            axios.post("/api/v1/patient_system/out_patient/obstetrical/ultrasound/details",this.formData).then(response=>{
                if(response.data.success) {
                    this.$emit("success")
                }
            })
        }
    },
    computed:{
        medical_staff_str(){
            let result=""
            if(this.medical_staff.length>0){
                for(const staff of this.medical_staff){
                    result+=staff+","
                }
                result=result.slice(0,-1)
            }
            return result
        }
    }
}
</script>

<style scoped>

</style>
