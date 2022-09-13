<template>
    <div class="container bg-light" >
        <div class="row">
            <div class="p-2 col-4"><h1 id="title">Stork Center Admission</h1></div>
            <div class="p-2 col " ><img id="logo"   src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg" alt="MHM logo" class="img-fluid rounded float-right"/></div>
        </div>
            <form>
                <section id="notice">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="newRequest" v-model="formData.new_request" :disabled="formData.changes_made">
                        <label class="form-check-label" for="newRequest">New Request</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="updateRequest" v-model="formData.changes_made" :disabled="formData.new_request">
                        <label class="form-check-label" for="updateRequest">Changes Made</label>
                    </div>
<!--                    <p class="text-justify"><span class="font-weight-bold">Notice:</span>-->
<!--                        this form is the standard admission form for all elective medical, surgical and procedural-->
<!--                        patients. All patient requiring immediate admission must be discussed with the Bed Manager-->
<!--                    </p>-->
                </section>
                <div class="table-responsive">
                    <table class="table table-sm" id="details_table">
                        <tr >
                            <td colspan="8" class="table_title">Patient's Details</td>
                        </tr>
                        <tr>
                            <td style="width:5%">Id:</td>
                            <td ><input type="text" v-model="formData.patient.id" style="width: 75px !important"/></td>
                            <td>Full Name:</td>
                            <td style="width:25%">{{nullToString(formData.patient.firstName)+nullToString(formData.patient.lastName)}}</td>
                            <td style="width: 10% !important">Date of birth</td>
                            <td>{{formData.patient.birthDate}}</td>
                        </tr>
                        <tr>
                            <td >Adress:</td>
                            <td colspan="">{{formData.patient.adress}}</td>
                            <td>Tel:</td>
                            <td>{{formData.patient.tel}}</td>
                        </tr>
                    </table>
                    <table class="table table-sm" id="admission_details">
                        <tr >
                            <td colspan="11" class="table_title">Admission's Details</td>
                        </tr>
                        <tr>
                            <td >
                                Admission Date
                                <date-picker
                                    v-model=" formData.admission_date"
                                    mode="date"
                                    :masks="dateConfig.masks"
                                    :max-date="new Date()"
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
                                            :class="{'is-invalid':$v.formData.admission_date.$error}"
                                            :value="inputValue"
                                            v-on="inputEvents"
                                        />
                                    </template>
                                </date-picker>
                            </td>
                            <td>
                                Time: &nbsp
                                <input type="time" v-model="formData.admission_time" :class="{'text-danger':$v.formData.admission_time.$error}" />
                            </td>
                            <td>
                                Service: &nbsp
                                <select v-model="formData.service_id" class="border" :class="{'text-danger':$v.formData.service_id.$error}">
                                    <option v-for="services in accessories.services" :value="services.id">{{services.name}}</option>
                                </select>
                            </td>
                            <td>
                                Type: &nbsp
                                <select v-model="formData.type" class="border" :disabled="formData.service_id!==14">
                                    <option v-for="type in accessories.in_patient_service_type" >{{type}}</option>
                                </select>
                            </td>
                            <td>
                                Reason :&nbsp
                                <select v-model="formData.reason" class="border" :disabled="formData.service_id!==14">
                                    <option v-for="reason in accessories.in_patient_mom_baby" >{{reason}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="2" :class="{'text-danger':$v.formData.type_of_stay.$error}">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="type_of_stay" id="type_of_stay_1"  value="day" class="custom-control-input" v-model="formData.type_of_stay"/>
                                    <label class="custom-control-label" for="type_of_stay_1" >Day patient</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="type_of_stay" id="type_of_stay_2"  value="overnight" class="custom-control-input" v-model="formData.type_of_stay"/>
                                    <label class="custom-control-label"  for="type_of_stay_2" >Overnight Patient</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="type_of_stay" id="type_of_stay_3"  value="overnight" class="custom-control-input" v-model="formData.type_of_stay"/>
                                    <label class="custom-control-label"  for="type_of_stay_3" >Permanent Patient</label>
                                </div>
                            </td>
<!--                            <td  colspan="2">-->
<!--                                Estimated length of stay: <br>-->
<!--                                <input type="number" style="width: 45px" class="border"  v-model="formData.estimated_stay_length"/>-->
<!--                                <select v-model="formData.estimated_stay_length_type" class="border">-->
<!--                                    <option value="">Choose</option>-->
<!--                                    <option v-for="day in accessories.date_range" :value="day.id">{{day.text}}</option>-->
<!--                                </select>-->
<!--                            </td>-->
<!--                            <td :class="{'text-danger':$v.formData.mobilisation_status.$error}">Mobilisation Status</td>-->
                            <td>
                                Mobilisation Status:
                                <select class="border" v-model="formData.mobilisation_status" :class="{'text-danger':$v.formData.mobilisation_status.$error}">
                                    <option v-for="mob in accessories.mobilisation_status">{{mob}}</option>
                                </select>
                            </td>
<!--                            <td :class="{'text-danger':$v.formData.level_of_care.$error}">Level of care</td>-->
                            <td>
                                Level of care:
                                <select class="border" v-model="formData.level_of_care" :class="{'text-danger':$v.formData.level_of_care.$error}">
                                    <option v-for="level in accessories.level_of_care">{{level}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" :class="{'text-danger':$v.formData.bed_id.$error}">
                                <div class="form-group">
                                    Consigned Bed

                                    <select v-model="formData.bed_id" class="border" :class="{'text-danger':$v.formData.bed_id.$error}">
                                        <option v-for="beds in accessories.beds" :value="beds.id">{{beds.description}}</option>
                                    </select>
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="form-group">
                                    Category
                                    <select v-model="formData.category" class="border" :class="{'text-danger':$v.formData.category.$error}">
                                        <option value=""></option>
                                        <option value="patient">Patient</option>
                                        <option value="follower">Follower</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-sm">
                        <tr>
                            <td colspan="8":class="{'text-danger':$v.formData.admission_diagnosis.$error}">Admission Diagnosis /indication of procedure:

                                <textarea class="form-control" v-model="formData.admission_diagnosis"></textarea>
                            </td>
                        </tr>
<!--                        <tr>-->
<!--                            <td colspan="8"> Medical Antecedents-->
<!--                                <textarea class="form-control" v-model="formData.medical_history.medical_antecedents"></textarea>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td colspan="8">-->
<!--                                Other significant medical issues:-->
<!--                                <textarea class="form-control" v-model="formData.medical_history.other_issues"></textarea>-->
<!--                            </td>-->
<!--                        </tr>-->
                        <tr>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="anesthesiaRequired" v-model="formData.anesthesia_required">
                                    <label class="form-check-label" for="newRequest">Surgery Required</label>
                                </div>
                            </td>
                            <td :class="{'d-none':!formData.anesthesia_required}" colspan="4">
                                Anesthesia Type:
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type2" name="anesthesia_type" value="general" v-model="formData.anesthesia_type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type2">General</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type3" name="anesthesia_type" value="Sedation" v-model="formData.anesthesia_type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type3">Sedation</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type4" name="anesthesia_type" value="regional" v-model="formData.anesthesia_type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type4">Regional</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type1" name="anesthesia_type" value="local" v-model="formData.anesthesia_type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type1">Local</label>
                                </div>



                            </td>
                        </tr>
                    </table>
                   <div class="table-responsive">
                       <table id="parameters_table" class="table table-sm">
                           <tbody>
                           <tr>
                               <td class="border">vital Signs:</td>
                               <td class="border">Temp:</td>
                               <td class="border"><input type="number" v-model="formData.temp"/></td>
                               <td class="border">weight:</td>
                               <td class="border"><input type="number" v-model="formData.weight"/></td>
                               <td class="border">B.P</td>
                               <td class="border"><input type="text" v-model="formData.bp"/></td>
                               <td class="border">Pulse</td>
                               <td class="border"><input type="number" v-model="formData.pulse"/></td>
                               <td class="border">spo2</td>
                               <td class="border"><input type="number" v-model="formData.spo2"/></td>
                           </tr>
                           <td></td>
                           <tr>
                               <td class="table_title" colspan="11"  >Infection Control</td>
                           </tr>
                           <tr>
                               <td colspan="4">Has the patient been an inpatient in another facility within the last seven days? </td>
                               <td>
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="referedPatient" v-model="formData.referred_patient"/>
                                       <label class="form-check-label" for="referedPatient">Yes</label>
                                   </div>
                               </td>
                           </tr>
                           <tr :class="{'d-none':!formData.referred_patient}">
                               <td>Where?</td>
                               <td colspan="2">
                                   <select class="border" v-model="formData.infection_control_facility_place">
                                       <option v-for="hosp in accessories.hospitals">{{hosp}}</option>
                                   </select>
                               </td>
                               <td>For how long</td>
                               <td colspan="2" style="width: 75px !important">
                                   <input type="number" style="width: 45px !important" class="border" v-model="formData.infection_control_duration_val"/>
                                   <select v-model="formData.infection_control_duration_type" class="border">
                                       <option v-for="range in accessories.date_range" :value="range.text">{{range.text}}</option>
                                   </select>
                               </td>
                           </tr>
                           <tr :class="{'d-none':!formData.referred_patient}">
                               <td colspan="2">Reason of hospitalisation:</td>
                               <td colspan="2"><input type="text" /></td>
                               <td colspan="2"> Reason of transfert:</td>
                               <td colspan="4"><input type="text" v-model="formData.infection_control_reason_of_transfer"/></td>
                           </tr>
                           <!--                        <tr>-->
                           <!--                            <td class="table_title" colspan="11" >Admitting Medical Teams</td>-->
                           <!--                        </tr>-->
                           <!--                        <tr>-->
                           <!--                            <td>Employee ID</td>-->
                           <!--                            <td>Employee Name </td>-->
                           <!--                            <td>Function</td>-->
                           <!--                        </tr>-->
                           <tr>
                               <td class="table_title" colspan="11">Accommodation Specifications</td>
                           </tr>
                           <tr>
                               <td colspan="3">Does the patient eat at the hospital?</td>
                               <td>
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="meal" v-model="formData.meal"/>
                                       <label class="form-check-label" for="meal">Yes</label>
                                   </div>
                               </td>
                           </tr>
                           <!--                        <tr>-->
                           <!--                            <td colspan="3">-->
                           <!--                                <span class="mr-2">Outstanding debt:</span>-->
                           <!--                                <input class="border" v-model="formData.unpaid_amount"/>-->
                           <!--                            </td>-->
                           <!--                            <td colspan="2">-->
                           <!--                                <button class="btn btn-sm d-print-none btn-secondary">View Payment history</button>-->
                           <!--                            </td>-->
                           <!--                        </tr>-->
                           <hr>
                           <tr class="d-none d-print-block">
                               <td colspan="5">MHM's signature:</td>
                               <td colspan="6" style="text-align: right">Patient or family member signature</td>
                           </tr>

                           </tbody>
                       </table>
                   </div>
                </div>

            </form>
            <button class="btn btn-outline-primary float-right" @click="submit" id="printBtn" v-if="!is_overview">Submit</button>
            <div id="footer">Date:{{today}}</div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
    export default {
        name: "stork_admission",
        props:{
            is_overview:Boolean,
            stork_admission:Object
        },
        mixins: [validationMixin],
        data(){
            return{
                formData:{
                    new_request:false,
                    changes_made:false,
                    patient:{

                    },
                    admission_date:"",
                    admission_time:"",
                    service_id:"",
                    bed_id:"",
                    level_of_care:'',
                    category:'',
                    admission_diagnosis:"",
                    type_of_stay:"",
                    infection_control_referred_patient:false,
                    infection_control_facility_place:'',
                    infection_control_duration_type:"",
                    infection_control_duration_val:"",
                    infection_control_reason_of_hospitalisation:"",
                    infection_control_reason_of_transfer:"",
                    estimated_stay_length:"",
                    estimated_stay_length_type:1,
                    temp:'',
                    pulse:"",
                    weight:"",
                    bp:"",
                    spo2:"",
                    anesthesia_required:false,
                    anesthesia_type:"",
                    mobilisation_status: '',
                    type:"",
                    reason:"",
                    meal:false,
                    unpaid_amount:''
                },
                accessories:{
                    patient:{
                        id:"",
                        firstName:"",
                        lastName:'',
                        adress:'',
                        birthDate:"",
                        tel:''
                    },
                    date_range:[
                        {id:1,text:"days"},
                        {id:2,text:"weeks"},
                        {id:3,text:"months"},
                        {id:4,text:"year"}
                    ],
                    services:[],
                    in_patient_service_type:['pregnancy','postpartum'],
                    in_patient_mom_baby:['Mom','Baby','both'],
                    level_of_care:['normal','intermediate','intensive'],
                    mobilisation_status: ['strict bed rest','bed rest','mobilisation','no restriction'],
                    hospitals:['PSF','HJRA','CHU Anosiala','Befelatanana','HOMI','CHU Andohatapenaka','OTHER'],
                    beds:[],
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
                admission_date:{required},
                admission_time:{required},
                service_id:{required},
                admission_diagnosis:{required},
                type_of_stay:{required},
                mobilisation_status:{required},
                level_of_care:{required},
                bed_id:{required},
                category:{required}
            }
        },
        created() {
            this.init();
        },
        methods:{
           async init(){
                let response= await axios.get('/api/v1/patient_system/in_patient/service/7')
                this.accessories.services.push(...response.data)
               await axios.get('/api/v1/patient_system/in_patient/bed/14').then(response=>{this.accessories.beds=response.data})
               let src=this.$route.params.admission
               if(src){
                   this.formData.patient=src.patient
                   this.formData.admission_id=src.id
                   this.formData.temp=src.temp
                   this.formData.pulse=src.pulse
                   this.formData.bp= src.taDia+"/"+src.taSysto
                   this.formData.spo2=src.spo2
                   this.formData.weight=src.weight
                   this.formData.service_id=src.service_id
                   this.formData.new_request=true
               }
            },
            async change_divisions(){
               this.accessories.beds=[]
               let response= await axios.get(`/api/hospitalisation/bed_list/${this.formData.accomodations.division}`)
                this.accessories.beds.push(...response.data)
            },
            submit(){
            //check if the patient is already in the system
                this.$v.$touch();
                if (this.$v.$invalid)return
                this.formData.patient_id=this.formData.patient.id
                this.formData.user_id = window.auth.user.id
                // delete this.formData.patient
                axios.post("/api/v1/patient_system/in_patient/stork/admission",this.formData).then(
                    response=>{
                        if(response.data.success) this.$router.push("patient_list")
                        else{
                            this.$toast.open({message:response.data.message,type:"error"})
                            this.$router.push("patient_list")
                        }
                    }
                )

            },
            nullToString(el) {
                return el ?? ''
            }
        },
        computed:{
            today(){
                return new Date().toLocaleDateString()
            }
        },
        watch:{
            stork_admission:{
                handler(val){
                    if(this.is_overview)this.formData=val
                },
                deep:true,
                immediate:true
            }
        }


    }
</script>

<style scoped>

    .container{
        box-shadow: 0px 0px 0.5cm rgba(0,0,0,0.8);
        margin-top: 0.6%;
        background-color: white !important;
        font-family: calibri ;
    }

    input:hover{
        border:solid 1px lightblue;
    }
    #logo{
        width: 200px;
        height: 100px;

    }
    #title{
        margin-top: 10px;
        font-weight: bold;
    }
    .table_title{
        background-color: rgb(195,195,195) !important;
        font-weight: bold;
        /*-webkit-print-color-adjust: exact;*/
    }
    #parameters_table td{
        max-width: 10px !important;
    }
    #parameters_table td input{
        max-width: 100% !important;
    }
    @media print{
        .container{
            width:100% !important;
            max-height:29.7cm;
            margin-left: -50px !important;
        }

        input,select,textarea{
            border:none !important;
            outline:none !important;
        }
        #printBtn{
            display: none;
        }
        #footer{
            margin-top:200px !important;
        }
    }

</style>
