<template>
    <div class="container w-75  p-4 bg-light" >
        <div class="d-flex flex-row justify-content-between">
            <div class="p-2"><h1 id="title">Stork Center Admission</h1></div>
            <div class="p-2"><img  id="logo" src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg" alt="MHM logo"/></div>
        </div>
            <form>
                <section id="notice">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="newRequest" v-model="formData.new_request" :disabled="formData.changes_made">
                        <label class="form-check-label" for="newRequest">New Request</label>
                    </div>
                    <label class="form-check-label mr-2">Or </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="updateRequest" v-model="formData.changes_made" :disabled="formData.new_request">
                        <label class="form-check-label" for="updateRequest">Changes Made</label>
                    </div>
                    <p class="text-justify"><span class="font-weight-bold">Notice:</span>
                        this form is the standard admission form for all elective medical, surgical and procedural
                        patients. All patient requiring immediate admission must be discussed with the Bed Manager
                    </p>
                </section>
                <div class="table-responsive">
                    <table class="table table-sm" id="details_table">
                        <tr >
                            <td colspan="8" class="table_title">Patient's Details</td>
                        </tr>
                        <tr>
                            <td>Id:</td>
                            <td><input type="text" v-model="formData.patient.id"/></td>
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
                            <td colspan="9" class="table_title">Admission's Details</td>
                        </tr>
                        <tr>
                            <td>Admission Date</td>
                            <td ><input type="date" v-model="formData.accomodations.admission_date"/></td>
                            <td>Admission Time</td>
                            <td><input type="time" v-model="formData.accomodations.admission_time" /></td>
                            <td>Service</td>
                            <td>
                                <select v-model="formData.accomodations.service" class="border">
                                    <option v-for="services in accessories.services" :value="services.id">{{services.name}}</option>
                                </select>
                            </td>
                            <td>
                                <span>Type</span>
                                <select v-model="formData.accomodations.division" class="border" :disabled="formData.accomodations.service!==14">
                                    <option v-for="type in accessories.in_patient_service_type" >{{type}}</option>
                                </select>
                            </td>
                            <td>
                                <span>Reason</span>
                                <select v-model="formData.accomodations.reason" class="border" :disabled="formData.accomodations.service!==14">
                                    <option v-for="reason in accessories.in_patient_mom_baby" >{{reason}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="type_of_stay" id="type_of_stay_1" value="day" class="custom-control-input" v-model="formData.accomodations.type_of_stay"/>
                                    <label class="custom-control-label" for="type_of_stay_1" >Day patient</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="type_of_stay" id="type_of_stay_2" value="overnight" class="custom-control-input" v-model="formData.accomodations.type_of_stay"/>
                                    <label class="custom-control-label"  for="type_of_stay_2" >Overnight Patient</label>
                                </div>
                            </td>
                            <td>Estimated length of stay:</td>
                            <td  colspan="2">
                                <input type="number" style="width: 45px" class="border"  v-model="formData.accomodations.estimated_stay_length"/>
                                <select v-model="formData.accomodations.estimated_stay_length_type" class="border">
                                    <option v-for="day in accessories.date_range" :value="day.id">{{day.text}}</option>
                                </select>
                            </td>
                            <td>Mobilisation Status</td>
                            <td>
                                <select class="border" v-model="formData.accomodations.mobilisation_status">
                                    <option v-for="mob in accessories.mobilisation_status">{{mob}}</option>
                                </select>
                            </td>
                            <td>Level of care</td>
                            <td>
                                <select class="border" v-model="formData.accomodations.level_of_care">
                                    <option v-for="level in accessories.level_of_care">{{level}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Consigned Bed

                                <select v-model="formData.accomodations.bed">
                                    <option v-for="beds in accessories.beds" :value="beds.id">{{beds.description}}</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-sm">
                        <tr>
                            <td colspan="8">Admission Diagnosis /indication of procedure:

                                <textarea class="form-control" v-model="formData.medical_history.admission_dagnosis"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8"> Medical Antecedents
                                <textarea class="form-control" v-model="formData.medical_history.medical_antecedents"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                Other significant medical issues:
                                <textarea class="form-control" v-model="formData.medical_history.other_issues"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="anesthesiaRequired" v-model="formData.anesthesia.required">
                                    <label class="form-check-label" for="newRequest">Anesthesia Required</label>
                                </div>
                            </td>
                            <td :class="{'d-none':!formData.anesthesia.required}" colspan="4">
                                Anesthesia Type:
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type1" name="anesthesia_type" value="local" v-model="formData.anesthesia.type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type1">Local</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type2" name="anesthesia_type" value="general" v-model="formData.anesthesia.type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type2">General</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type3" name="anesthesia_type" value="IVS" v-model="formData.anesthesia.type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type3">IVS</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="anesthesia_type4" name="anesthesia_type" value="epidural" v-model="formData.anesthesia.type" class="custom-control-input">
                                    <label class="custom-control-label" for="anesthesia_type4">Epidural</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table id="parameters_table" class="table table-sm">
                        <tbody>
                        <tr>
                            <td class="border">vital Signs:</td>
                            <td class="border">Temp:</td>
                            <td class="border"><input type="number" v-model="formData.vitalSigns.temp"/></td>
                            <td class="border">weight:</td>
                            <td class="border"><input type="number" v-model="formData.vitalSigns.weight"/></td>
                            <td class="border">B.P</td>
                            <td class="border"><input type="number" v-model="formData.vitalSigns.bp"/></td>
                            <td class="border">Pulse</td>
                            <td class="border"><input type="number" v-model="formData.vitalSigns.pulse"/></td>
                            <td class="border">O2</td>
                            <td class="border"><input type="number" v-model="formData.vitalSigns.o2"/></td>
                        </tr>
                        <td></td>
                        <tr>
                            <td class="table_title" colspan="11"  >Infection Control</td>
                        </tr>
                        <tr>
                            <td colspan="4">Has the patient been an inpatient in another facility within the last seven days? </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="referedPatient" v-model="formData.referredPatient"/>
                                    <label class="form-check-label" for="referedPatient">Yes</label>
                                </div>
                            </td>
                        </tr>
                        <tr :class="{'d-none':!formData.referredPatient}">
                            <td>Where?</td>
                            <td colspan="2"><input type="text" v-model="formData.infection_control.facility_place" /></td>
                            <td colspan="2">For how long</td>
                            <td colspan="2" style="width: 75px !important">
                                <input type="number" style="width: 45px !important"/>
                                <select v-model="formData.infection_control.duration">
                                    <option v-for="range in accessories.date_range" :value="range.text">{{range.text}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr :class="{'d-none':!formData.referredPatient}">
                            <td colspan="2">Reason of hospitalisation:</td>
                            <td colspan="2"><input type="text" /></td>
                            <td colspan="2"> Reason of transfert:</td>
                            <td colspan="4"><input type="text" v-model="formData.infection_control.reason_of_transfert"/></td>
                        </tr>
                        <tr>
                            <td class="table_title" colspan="11" >Admitting Medical Teams</td>
                        </tr>
                        <tr>
                            <td>Doctor ID</td>
                            <td ><input type="number" v-model="formData.medical_team.doctor.id"/></td>
                            <td colspan="2">Doctor Name </td>
                            <td colspan="6"><input type="text" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td>Anesthesist ID</td>
                            <td><input type="number" v-model="formData.medical_team.anesthesist.id"/></td>
                            <td colspan="2">Anesthesist Name</td>
                            <td colspan="6"><input type="text" style="width: 100%" /></td>
                        </tr>
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
                            <td>frequency:</td>
                            <td><input type="number" v-model="formData.accomodations.meal_frequency" /></td>
                            <td colspan="2">times a day</td>
                        </tr>
                        <tr>
                            <td class="table_title" colspan="11">Billing details</td>
                        </tr>
                        <tr>
                            <td colspan="3">Does the patient has an insurance?</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="insurance" v-model="formData.billing.insurance"/>
                                    <label class="form-check-label" for="meal">Yes</label>
                                </div>
                            </td>
                            <td>which one?</td>
                            <td colspan="6"> <input type="text" style="width:100%" class="border" :disabled="!formData.billing.insurance"/></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <span class="mr-2">Outstanding debt:</span>
                                <input class="border" v-model="formData.billing.unpaid_amount"/>
                            </td>
                            <td colspan="2">
                                <button class="btn btn-sm d-print-none btn-secondary">View Payment history</button>
                            </td>
                        </tr>
                        <hr>
                        <tr>
                            <td colspan="5">Doctor's signature:</td>
                            <td colspan="6" style="text-align: right">Patient or family member signature</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </form>
            <button class="btn btn-outline-primary" onclick="window.print()" id="printBtn">Print</button>
            <div id="footer">Date:{{today}}</div>
    </div>
</template>

<script>
    export default {
        name: "stork_admission",
        data(){
            return{
                formData:{
                   new_request:false,
                    changes_made:false,
                    referred_patient:false,
                    patient:{
                        id:"",
                        firstName:"",
                        lastName:'',
                        adress:'',
                        birthDate:"",
                        tel:''
                    },
                    infection_control:{
                        facility_place:"",
                        duration:"",
                        reason_of_hospitalisation:"",
                        reason_of_transfert:""
                    },
                    medical_team:{
                        doctor:{id:"",name:""},
                        anesthesist:{id:"",name:""},
                        nurse:{id:"",name:""}
                    },
                    vitalSigns:{
                        temp:"",
                        pulse:"",
                        weight:"",
                        bp:"",
                        o2:""
                    },
                    anesthesia:{
                        required:false,
                        type:""
                    },
                    medical_history:{
                        medical_antecedents:"",
                        admission_dagnosis:"",
                        other_issues:""
                    },
                    accomodations:{
                        type_of_stay:"",
                        estimated_stay_length:"",
                        estimated_stay_length_type:1,
                        mobilisation_status: '',
                        level_of_care:'',
                        service:"",
                        division:"",
                        bed:"",
                        admission_date:"",
                        admission_time:"",
                        meal:false,
                        meal_frequency:""
                    },
                    billing:{
                        unpaid_amount:'',
                        insurance:false,
                        insurance_name:""
                    }
                },
                formDataa:{
                    referedPatient:false,
                    patient_id:'',
                    infection_control_facility_place:'',
                    infection_control_duration:"",
                    infection_control_reason_of_hospitalisation:"",
                    infection_control_reason_of_transfert:"",
                    doctor_id:'',
                    anesthetist_id:'',
                    nurse_id:'',
                    midwife_id:'',
                    temp:'',
                    pulse:"",
                    weight:"",
                    bp:"",
                    o2:"",
                    anesthesia_required:false,
                    anesthesia_type:"",
                    medical_antecedents:"",
                    admission_dagnosis:"",
                    other_issues:"",
                    type_of_stay:"",
                    estimated_stay_length:"",
                    estimated_stay_length_type:1,
                    mobilisation_status: '',
                    level_of_care:'',
                    service:"",
                    division:"",
                    bed:"",
                    admission_date:"",
                    admission_time:"",
                    meal:false,
                    meal_frequency:"",
                    payment_method:""
                },
                accessories:{
                    date_range:[
                        {id:1,text:"days"},
                        {id:2,text:"weeks"},
                        {id:3,text:"months"},
                        {id:4,text:"year"}
                    ],
                    payment_method:[
                        {id:1,text:"cash"},
                        {id:1,text:"Card"},
                    ],
                    services:[],
                    in_patient_service_type:['pregnancy','postpartum'],
                    in_patient_mom_baby:['Mom','Baby'],
                    level_of_care:['normal','intermediate','intensive'],
                    mobilisation_status: ['strict bed rest','bed rest','mobilisation','no restriction'],
                    hospitals:['PSF','HJRA','CHU Anosiala','Befelatanana','HOMI','CHU Andohatapenaka','OTHER'],
                    beds:[],
                }

            }

        },
        created() {
            this.init();
        },
        methods:{
           async init(){
                let response= await axios.get('/api/v1/patient_system/in_patient/service/7')
                this.accessories.services.push(...response.data)
               let src=this.$route.params.admission
               if(src){
                   this.formData.patient=src.patient
               }
            },
            async change_divisions(){
               this.accessories.beds=[]
               let response= await axios.get(`/api/hospitalisation/bed_list/${this.formData.accomodations.division}`)
                this.accessories.beds.push(...response.data)
            },
            nullToString(el) {
                return el ?? ''
            }
        },
        computed:{
            today(){
                return new Date().toLocaleDateString()
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
        max-width: 250px;
        max-height: 100px;

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
