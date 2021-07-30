<template>
    <form @submit.prevent="submit">
        <div class="registration-container">
            <div class="p-2 title">
                <h2 style="display: inline-block">Birth Registration</h2>
                <v-btn class="float-right d-print-none"><v-icon>mdi-printer</v-icon></v-btn>
            </div>
            <v-row>
                <v-col>
                    <table class="table mt-2">
                        <tr>General Info</tr>
                        <tr>
                            <td>Date:</td>
                            <td><input v-model="formData.birth_date" type="date" :class="{'error':$v.formData.birth_date.$error}"/></td>
                            <td>Time:</td>
                            <td><input v-model="formData.birth_time" type="time" :class="{'error':$v.formData.birth_time.$error}"/></td>
                            <td>GA:</td>
                            <td><input v-model="formData.GA" type="text" :class="{'error':$v.formData.GA.$error}"/></td>
                            <td colspan="2"><span :class="{'error':$v.formData.external_delivery.$error}">External Delivery:</span> &nbsp

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input v-model="formData.external_delivery"  type="radio" id="external_delivery_1" name="external_delivery" value="yes" class="custom-control-input v-model=">
                                    <label class="custom-control-label" for="external_delivery_1">yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input v-model="formData.external_delivery" type="radio" id="external_delivery_2" name="external_delivery" value="no" class="custom-control-input v-model=">
                                    <label class="custom-control-label" for="external_delivery_2">no</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card>
                        <v-card-title>Mom</v-card-title>
                        <table class="table">
                            <tr>
                                <td>Patient Nr: &nbsp <input type="text" v-model="formData.patient_id" @change="changePat" :class="{'error':$v.formData.patient_id.$error}"/></td>
                                <td colspan="2">Fullname: &nbsp {{patient_fullname}}</td>
                                <td colspan="2">Birthdate: &nbsp {{patient_birthDate}} &nbsp Address: {{patient_adress}}</td>

                            </tr>
                            <tr>
                                <td> cpn ref:</td>
                                <td><a href="#">{{formData.cpn_admission_id}}</a></td>
                                <td>
                                    Twin?
                                    <input type="checkbox" v-model="twin"/> &nbsp &nbsp
                                    <span v-if="twin">count of babies </span>&nbsp
                                    <input type="number" max="3" v-model="count_twin" @change="insert_twin" v-if="twin"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Position Mom &nbsp
                                    <select v-model="formData.position" :class="{'error':$v.formData.position.$error}">
                                        <option v-for="position in position_mom">{{position}}</option>
                                    </select>
                                </td>
                                <td>
                                    CTG
                                    <select v-model="formData.ctg">
                                        <option v-for="i in ctg">{{i}}</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <multiselect :options="birth_complications"

                                                 v-model="formData.complications"
                                                 :multiple="true"
                                                 placeholder="Complications"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Placenta Time &nbsp
                                    <input type="time" v-model="formData.placenta_time" :class="{'error':$v.formData.placenta_time.$error}" />
                                </td>

                                <td>
                                    <span :class="{'error':$v.formData.placenta_complete.$error}">Placenta Complete</span> &nbsp
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_complete_1" name="placenta_complete" value="yes" class="custom-control-input" v-model="formData.placenta_complete">
                                        <label class="custom-control-label" for="placenta_complete_1">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_complete_2" name="placenta_complete" value="no" class="custom-control-input" v-model="formData.placenta_complete">
                                        <label class="custom-control-label" for="placenta_complete_2">no</label>
                                    </div>
                                </td>
                                <td>
                                    <span :class="{'error':$v.formData.placenta_spontaneous.$error}">Placenta Spontaneous</span> &nbsp
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_spontaneous_1" name="placenta_spontaneous" value="yes" class="custom-control-input" v-model="formData.placenta_spontaneous">
                                        <label class="custom-control-label" for="placenta_spontaneous_1">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_spontaneous_2" name="placenta_spontaneous" value="no" class="custom-control-input" v-model="formData.placenta_spontaneous">
                                        <label class="custom-control-label" for="placenta_spontaneous_2">no</label>
                                    </div>
                                </td>
                                <td>
                                    <span :class="{'error':$v.formData.placenta_manual_delivery.$error}">Placenta Manual Delivery</span> &nbsp
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_manual_del_1" name="placenta_manual_del" value="yes" class="custom-control-input" v-model="formData.placenta_manual_delivery">
                                        <label class="custom-control-label" for="placenta_manual_del_1">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_manual_del_2" name="placenta_manual_del" value="no" class="custom-control-input" v-model="formData.placenta_manual_delivery">
                                        <label class="custom-control-label" for="placenta_manual_del_2">no</label>
                                    </div>
                                </td>
                                <td>
                                    <span :class="{'error':$v.formData.placenta_curetage.$error}">Placenta Curetage</span> &nbsp
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_curetage_1" name="placenta_curetage" value="yes" class="custom-control-input" v-model="formData.placenta_curetage">
                                        <label class="custom-control-label" for="placenta_curetage_1">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" id="placenta_curetage_2" name="placenta_curetage" value="no" class="custom-control-input" v-model="formData.placenta_curetage">
                                        <label class="custom-control-label" for="placenta_curetage_2">no</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                   Injuries: &nbsp <input type="text" v-model="formData.injuries" style="width:80%" class="text-danger"/>
                                </td>
                                <td>
                                    Blood Loss &nbsp
                                    <select v-model="formData.blood_loss">
                                        <option v-for="b in blood_loss">{{b}}</option>
                                    </select>
                                </td>
                                <td>
                                    Stiches &nbsp
                                    <input type="text" v-model="formData.stiches" class="text-danger"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Sterlisation package Nr &nbsp
                                    <input type="text" v-model="formData.sterilisation_package"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Medicines used &nbsp
                                    <v-btn
                                        class="mx-2"
                                        fab
                                        dark
                                        color="indigo"
                                        x-small
                                        @click="accessory.add_med= !accessory.add_med"
                                    >
                                        <v-icon dark v-if="!accessory.add_med">
                                            mdi-plus
                                        </v-icon>
                                        <v-icon dark v-if="accessory.add_med">
                                            mdi-minus
                                        </v-icon>
                                    </v-btn>
                                </td>
                            </tr>
                            <tr v-if="accessory.add_med">
                                <td colspan="2">

                                    <multiselect
                                        v-model="accessory.search.item"
                                        label="description"
                                        track-by="description"
                                        :id="'multiSelect'"
                                        placeholder="Type to search"
                                        open-direction="bottom"
                                        :options="accessory.temp_list"
                                        :searchable="true"
                                        :internal-search="false"
                                        :clear-on-select="true"
                                        :close-on-select="true"
                                        :show-no-results="false"
                                        :hide-selected="true"
                                        @search-change="fetchItem"
                                        class="form-control-sm"
                                    >
                                    </multiselect>
                                </td>
                                <td colspan="2">
                                    <input type="number" class="form-control mt-2" placeholder=" quantity" style="width:40%" @keydown.enter.prevent="add_medicine" v-model="accessory.search.quantity"/>
                                </td>
                            </tr>
                            <tr v-for="row in formData.medicines_used">
                                <td>{{row.item.description}}</td>
                                <td>{{row.quantity}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <textarea class="form-control" placeholder="Remark and particularities" v-model="formData.remarks"/>
                                </td>
                            </tr>
                        </table>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col v-for="(baby,index) in formData.babies" :key="index" :set="v = $v.formData.babies.$each[index]">
                    <v-card>
                        <v-card-title>Baby-{{index}}</v-card-title>
                        <v-card-subtitle>
                            <v-row justify="space-around">
                                <v-col>
                                    Firstname
                                    <input type="text" style="width:350px" v-model="baby.firstName" :class="{ 'error': v.firstName.$error }"/>
                                </v-col>
                                <v-col>
                                    Lastname
                                    <input type="text" v-model="baby.lastName" style="width:350px" :class="{ 'error': v.lastName.$error }"/>
                                </v-col>



                            </v-row>
                        </v-card-subtitle>
                        <v-card-text>
                            <table class="table">
                                <tr>
                                    <td>
                                        <span :class="{ 'error': v.alive.$error }">Alive?</span> &nbsp
                                    </td>
                                    <td colspan="2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'alive_1_'+index" name="alive" value="yes" class="custom-control-input" v-model="baby.alive">
                                            <label class="custom-control-label" :for="'alive_1_'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'alive_2_'+index" name="alive" value="no" class="custom-control-input" v-model="baby.alive">
                                            <label class="custom-control-label" :for="'alive_2_'+index">no</label>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group form-row">
                                            Gender: &nbsp
                                            <select v-model="baby.gender" :class="{ 'error': v.gender.$error }">
                                                <option v-for="g in gender">{{g}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="baby.alive==='no'">
                                    <td>
                                        Death explanation
                                    </td>
                                    <td colspan="4">
                                        <input type="text" style="width:100%" v-model="baby.death_explanation"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Modus &nbsp
                                        <select  v-model="baby.modus" :class="{ 'error': v.modus.$error }">
                                            <option v-for="type in modus">{{type.name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        Position of the baby &nbsp
                                        <select v-model="baby.position" :class="{ 'error': v.position.$error }">
                                            <option v-for="pb in position_baby">{{pb}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        Correlation
                                        <select v-model="baby.correlation" :class="{ 'error': v.correlation.$error }">
                                            <option v-for="c in correlation">{{c}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        Maturity
                                        <select v-model="baby.maturity" :class="{ 'error': v.maturity.$error }">
                                            <option v-for="m in maturity">{{m}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        Vit K
                                        <select v-model="baby.vit_k" :class="{ 'error': v.vit_k.$error }">
                                            <option>Choose</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Weight:
                                        <input type="number" v-model="baby.weight" :class="{ 'error': v.weight.$error }"/>
                                    </td>
                                    <td>
                                        Length:
                                        <input type="number" v-model="baby.length" :class="{ 'error': v.length.$error }"/>
                                    </td>
                                    <td>
                                        Head:
                                        <input type="number" v-model="baby.head" :class="{ 'error': v.head.$error }"/>
                                    </td>
                                    <td>
                                        Arm:
                                        <input type="number" v-model="baby.arm" :class="{ 'error': v.arm.$error }"/>
                                    </td>
                                    <td>
                                        Chest:
                                        <input type="number" v-model="baby.chest" :class="{ 'error': v.chest.$error }"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Apgar
                                        <input type="text" style="width:60px" v-model="baby.apgar" :class="{ 'error': v.apgar.$error }"/>
                                    </td>
                                    <td colspan="3">
                                        Malformation
                                        <input type="text"  style="width:80%" v-model="baby.malformation" class="text-danger"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <span :class="{ 'error': v.baby_not_crying.$error }">Did the baby cry?</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'new_born_crying_1'+index" name="'new_born_crying" value="yes" class="custom-control-input" v-model="baby.baby_not_crying">
                                            <label class="custom-control-label" :for="'new_born_crying_1'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'new_born_crying_2'+index" name="'new_born_crying" value="no" class="custom-control-input" v-model="baby.baby_not_crying">
                                            <label class="custom-control-label" :for="'new_born_crying_2'+index">no</label>
                                        </div>
                                        <span :class="{ 'error': v.risk_of_cerebral_palsy.$error }">Risk of cerebral palsy and/or jaundice?</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'new_bron_risk_1'+index" name="new_bron_risk" value="yes" class="custom-control-input" v-model="baby.risk_of_cerebral_palsy">
                                            <label class="custom-control-label" :for="'new_bron_risk_1'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'new_bron_risk_2'+index" name="new_bron_risk" value="no" class="custom-control-input" v-model="baby.risk_of_cerebral_palsy">
                                            <label class="custom-control-label" :for="'new_bron_risk_2'+index">no</label>
                                        </div>
                                        &nbsp infection:
                                        <input type="text" style="width:350px" v-model="baby.infection" class="text-danger"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <span :class="{ 'error': v.cpa_needed.$error }">CPA needed?</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'cpa_needed_1'+index" name="cpa_needed" value="yes" class="custom-control-input" v-model="baby.cpa_needed">
                                            <label class="custom-control-label" :for="'cpa_needed_1'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'cpa_needed_2'+index" name="cpa_needed" value="no" class="custom-control-input" v-model="baby.cpa_needed">
                                            <label class="custom-control-label" :for="'cpa_needed_2'+index">no</label>
                                        </div> &nbsp &nbsp
                                        <span :class="{ 'error': v.extra_supervision_needed.$error }">Extra supervision needed?</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'extra_supervision_1'+index" name="extra_supervision" value="yes" class="custom-control-input" v-model="baby.extra_supervision_needed">
                                            <label class="custom-control-label" :for="'extra_supervision_1'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'extra_supervision_2'+index" name="extra_supervision" value="no" class="custom-control-input" v-model="baby.extra_supervision_needed">
                                            <label class="custom-control-label" :for="'extra_supervision_2'+index">no</label>
                                        </div> &nbsp &nbsp
                                        <span :class="{ 'error': v.swobs_taken.$error }">Swobs taken?</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'swobs_taken_1'+index" name="swobs_taken" value="yes" class="custom-control-input" v-model="baby.swobs_taken">
                                            <label class="custom-control-label" :for="'swobs_taken_1'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'swobs_taken_2'+index" name="swobs_taken" value="no" class="custom-control-input" v-model="baby.swobs_taken">
                                            <label class="custom-control-label" :for="'swobs_taken_2'+index">no</label>
                                        </div>


                                    </td>
                                </tr>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <v-card  class="pa-2">
                        <v-card-title>Medical Team</v-card-title>
                        <table class="table medical-team">
                            <tr>
                                <td>Midwvives</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.midwives" :class="{ 'error': $v.formData.midwives.$error }"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Nurse</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.nurses"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Anesthetist</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.anesthetists"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Surgeon</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.surgeons"/>
                                </td>
                            </tr>
                        </table>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="2">
                    <button type="submit" class="btn" id="submit">Submit</button>
                </v-col>
            </v-row>
        </div>
    </form>

</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "delivery_registration",
    data(){
        return{
            formData:{
                code:'',
                patient_id:'',
                cpn_admission_id:'',
                birth_date:'',
                birth_time:'',
                GA:'',
                external_delivery:'',
                babies:[
                    {   id:'',
                        firstName:'',
                        lastName:'',
                        alive:'',
                        gender:'',
                        death_explanation:'',
                        death_type:'',
                        modus:'',
                        position:'',
                        correlation:'',
                        maturity:'',
                        vit_k:'',
                        E1:'Done',
                        weight:'',
                        length:'',
                        head:'',
                        arm:'',
                        chest:'',
                        apgar:'',
                        malformation:'',
                        infection:'',
                        baby_not_crying:'',
                        risk_of_cerebral_palsy:'',
                        cpa_needed:'',
                        extra_supervision_needed:'',
                        swobs_taken:''
                    }
                ],
                position:'',
                ctg:'',
                complications:[],
                placenta_time:'',
                placenta_complete:'',
                placenta_spontaneous:'',
                placenta_manual_delivery:'',
                placenta_curetage:'',
                injuries:'',
                injuries_description:'',
                blood_loss:'',
                stiches:'',
                sterilisation_package:'',
                medicines_used:[],
                remarks:'',
                midwives:'',
                nurses:'',
                surgeons:'',
                anesthetists:''
            },
            birth_complications:[
                'Long labour',
                'eclampsia',
                'Bad CTG',
                'High Blood pressure',
                'Long Pushing'
            ],
            position_mom:['laying on her back','laying on her side','sitting','standing','4 paws'],
            position_baby:['occiput anterior left','occiput anterior right','occiput posterior left','occiput posterior right','face presentation','cheen anterior','brrech','full knee','one foot','full feet','Oblic'],
            ctg:['twin','induction','cross rightline','bad BDCF with doppler','long pushing'],
            blood_loss:['<250','250-500','500-750','750-1000','1000-1500','1500-2000','2000-2500','>2500'],
            correlation:['<','=','>'],
            maturity:['premature','mature','post DPA'],
            gender:['M','F'],
            modus:[],
            patient_fullname:'',patient_adress:'',patient_birthDate:'',
            twin:false,count_twin:1,
            baby_element:{
                id:'',
                firstName:'',
                lastName:'',
                alive:'',
                gender:'',
                death_explanation:'',
                death_type:'',
                modus:'',
                position:'',
                correlation:'',
                maturity:'',
                vit_k:'',
                E1:'Done',
                weight:'',
                length:'',
                head:'',
                arm:'',
                chest:'',
                apgar:'',
                malformation:'',
                infection:'',
                baby_not_crying:'',
                risk_of_cerebral_palsy:'',
                cpa_needed:'',
                extra_supervision:'',
                swobs_taken:''
            },
            accessory:{
                search:{
                    item:'',
                    quantity:''
                },
                temp_list:[],
                add_med:false
            }

        }
    },
    validations:{
        formData:{
            patient_id:{required},
            GA:{required},
            birth_date:{required},
            birth_time:{required},
            position:{required},
            external_delivery:{required},
            placenta_time:{required},
            placenta_complete:{required},
            placenta_spontaneous:{required},
            placenta_manual_delivery:{required},
            placenta_curetage:{required},
            babies:{
                $each:{
                    firstName:{required},
                    lastName:{required},
                    alive:{required},
                    gender:{required},
                    modus:{required},
                    position:{required},
                    correlation:{required},
                    maturity:{required},
                    vit_k:{required},
                    weight:{required},
                    length:{required},
                    head:{required},
                    arm:{required},
                    chest:{required},
                    apgar:{required},
                    baby_not_crying:{required},
                    risk_of_cerebral_palsy:{required},
                    cpa_needed:{required},
                    extra_supervision_needed:{required},
                    swobs_taken:{required},
                }
            },
            midwives:{required}
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/birth_type').then(response=>this.modus=response.data)
            this.fetch_last_code()
        },
        async fetch_last_code(){
            await axios.get('/api/maternity/last_birth_code').then(response=>this.formData.code=response.data)
        },
        async changePat(){
            await axios.get(`/api/maternity/fetch_patient_data/${this.formData.patient_id}`).then(response=>{
                this.patient_fullname= response.data.patient_data.firstName + ' '+ response.data.patient_data.lastName
                this.patient_adress=response.data.patient_data.adress
                this.patient_birthDate=response.data.patient_data.birthDate
                this.formData.cpn_admission_id= response.data.patient_data.cpn_admissions[0]?.id
                this.formData.GA=response.data.ga

            })
        },
        insert_twin(){
            this.formData.babies=[]
            for(let i=1;i<=this.count_twin;i++){
                this.formData.babies.push({...this.baby_element})
            }
        },
        async submit(){
            this.$v.$touch()
            if(!this.$v.$invalid){
                this.formData.code= this.new_code
                await axios.post('/api/maternity/delivery_registration',this.formData).then(response=>{
                    if(response.data.success){
                        this.$router.push({name:'birth_certificate',code:response.data.id})
                    }
                })
            }

        },
        async fetchItem(code){
            this.accessory.search.temp_list = [];
            await axios({
                method:'GET',
                url:'http://127.0.0.1:8000/api/item',
                params:{ search_text: code },
            }).then((response) => {
                    let data = response.data.data;
                    this.accessory.temp_list=data
                });
        },
        add_medicine(){
            if (
                this.accessory.search.item !== "" &&
                this.accessory.search.quantity !== ""
            ) {
                this.formData.medicines_used.push({
                    item: {
                        id: this.accessory.search.item.id,
                        code: this.accessory.search.item.code,
                        description: this.accessory.search.item.description,
                    },
                    quantity: this.accessory.search.quantity,
                });
                this.accessory.search.item = "";
                this.accessory.search.quantity = "";
                this.accessory.edit = true;
            }
        }
    },
    computed:{
        new_code(){
            let date =new Date()
            let intPart= parseInt(this.formData.code.split('-')[1])
            intPart++
            let zero=''
            let intPart_length= intPart.toString().length
            for(let i=0;i<3-intPart_length;i++){
                zero+='0'
            }
            return date.getFullYear()+'-'+zero+intPart
        }
    }
}
</script>

<style scoped>
.title{
    background-color: #1A417E;
    color:whitesmoke;
}
input, select{
    border:0.5px  solid lightgrey;
}
input[type=number]{
    width:50px;
}
.medical-team input{
    width:100%;
}
#submit{
    background-color:#bc51cf;
    color:white;
}
@media print{
    .registration-container{
        margin-left: -250px !important;
        /*width: 210mm;*/
        /*height: 297mm;*/
        size:A4;
        padding: 50px;
    }
}
@media screen and (max-width: 1480px){
    .registration-container{
        transform: scale(0.9);
    }
}
</style>
