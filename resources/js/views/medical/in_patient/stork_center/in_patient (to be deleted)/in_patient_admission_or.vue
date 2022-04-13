<template>
    <div class="container-fluid w-75">
        <v-app hide-details>
            <div class="p-2 title">
                <h2 style="display: inline-block">Stork center Admission</h2>
                <v-btn class="float-right d-print-none" @click="print"><v-icon>mdi-printer</v-icon></v-btn>
            </div>
            <div class="table-responsive p-4">
                <table id="patient_gl_info" class="table table-sm">
                    <tr>
                        <th colspan="4" style="text-align:center;">General information about the patient</th>
                    </tr>
                    <tr>
                        <td >Id<span class="text-danger">*</span>  <input v-model="formData.patient_id" type="number" @change="change_patient" :class="{'error':$v.formData.patient_id.$error}"/></td>
                        <td>FirstName <input v-model="formData.firstName" type="text"/></td>
                        <td>LastName <input v-model="formData.lastName" type="text"/></td>
                        <td>BirthDate<input v-model="formData.birthDate" type="text"style="width:125px"/></td>
                    </tr>
                </table>
<!--                <table id="patient_contact_table">-->
<!--                    <tr >-->
<!--                        <td>Address: <input v-model="formData.address" type="text"/></td>-->
<!--                        <td>Tel: <input v-model="formData.tel" type="text"/></td>-->
<!--                        <td>Mail: <input v-model="formData.mail" type="text"/></td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--                <table  class="table table-sm table-borderless mt-2">-->
<!--                    <tr>-->
<!--                        <th style="text-align:center;" colspan="3">Admission details</th>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td colspan="2"><span class="font-weight-bold">Date:</span><span class="text-danger">*</span> <input v-model="formData.date" type="date" style="margin-right:10px" :class="{'error':$v.formData.date.$error}"/>-->
<!--                            | &nbsp<span class="font-weight-bold">Time:</span><span class="text-danger">*</span> <input v-model="formData.time" type="time" :class="{'error':$v.formData.time.$error}" /></td>-->
<!--                        <td>-->
<!--                            <span class="mr-2 font-weight-bold">Service:</span><span class="text-danger">*</span> <select :class="{'error':$v.formData.in_patient_service_id.$error}" v-model="formData.in_patient_service_id" @change="fetch_free_bed"><option v-for="item in accessory.in_patient_service" :value="item.id" >{{item.name}}</option></select>-->
<!--                            <div v-if="formData.in_patient_service_id===14" class="d-inline">-->
<!--                                <span class="mr-2 font-weight-bold">Type:</span><span class="text-danger">*</span> <select :class="{'error':$v.formData.in_patient_service_type.$error}" v-model="formData.in_patient_service_type"><option v-for="item in accessory.in_patient_service_type" >{{item}}</option></select>-->
<!--                                <span class="mr-2 font-weight-bold">Reason:</span><span class="text-danger">*</span> <select :class="{'error':$v.formData.in_patient_mom_baby.$error}" v-model="formData.in_patient_mom_baby"><option v-for="item in accessory.in_patient_mom_baby" :value="item" >{{item}}</option></select>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td>-->
<!--                            <span class="font-weight-bold">Level of care:</span> <span class="text-danger">*</span><select :class="{'error':$v.formData.level_of_care.$error}" v-model="formData.level_of_care" ><option v-for="item in accessory.level_of_care" >{{item}}</option></select>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span class="ml-4">Bed:</span><span class="text-danger">*</span> <select :class="{'error':$v.formData.bed_id.$error}"  v-model="formData.bed_id"><option v-for="item in accessory.beds" :value="item.id" >{{item.description}}</option></select>-->

<!--                        </td>-->
<!--                        <td>-->
<!--                            <span class="font-weight-bold">Mobilisation status:</span> <span class="text-danger">*</span><select :class="{'error':$v.formData.mobilisation_status.$error}" v-model="formData.mobilisation_status" ><option v-for="item in accessory.mobilisation_status" >{{item}}</option></select>-->

<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span class="font-weight-bold">-->
<!--                                Is the patient referred from other hospital?-->
<!--                            </span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td class="border-none" colspan="3">-->
<!--                            <span class="text text-danger">Emergency Case: </span> <input v-model="formData.emergency_case" type="checkbox">-->
<!--                            <span style="color:#1B4390" class="ml-2" v-if="formData.emergency_case">-->
<!--                                Please take all required actions if any of the following danger signs are present.-->
<!--                            Remember, following the QM is capital for the survival of the mother and the baby.-->
<!--                            </span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none" v-if="formData.emergency_case">-->
<!--                        <td  colspan="3">-->
<!--                            <span class="mr-2">Vaginal bleeding:</span><input v-model="formData.vaginal_bleeding" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">Severe abdominal pain:</span><input v-model="formData.severe_abdominal_pain" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">High fever:</span><input v-model="formData.high_fever" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">Sever headache or blurred vision:</span><input v-model="formData.severe_headache" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">Difficulty in breathing:</span><input v-model="formData.breathing_difficulty" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">convulsions:</span><input v-model="formData.convulsions" type="checkbox"/>-->
<!--                            <span class="mr-2 ml-2">Other danger:</span><input  type="checkbox"/>-->
<!--                            <input v-model="formData.other_danger" type="text" class="ml-2"/>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td colspan="3" class="border-none preg_data">-->
<!--                            Gestational Age:<span class="text-danger">*</span> <input v-model="formData.ga" type="text" :class="{'error':$v.formData.ga.$error}"/>-->
<!--                            <span class="ml-2">Due Date of Labor <small>[{{formData.due_date_method}}]</small>: </span>-->
<!--                            <input v-model="formData.due_date_labor" type="date"/>-->
<!--                            <span class="ml-2">CPN ref:</span>-->
<!--                            <router-link :to="{name:'obstetrics_overview',params:{cpn_ref:formData.cpn_ref,ultrasound_ref:formData.ultrasound_ref}}" >-->
<!--                            {{formData.cpn_ref}}</router-link>-->
<!--                            <span class="ml-2" :class="{'error':$v.formData.booked_delivery.$error}">Booked Delivery:</span>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.booked_delivery" type="radio" id="booked_delivery_1" name="booked_delivery" value="yes" class="custom-control-input v-model=">-->
<!--                                <label class="custom-control-label" for="booked_delivery_1">yes</label>-->
<!--                            </div>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.booked_delivery" type="radio" id="booked_delivery_2" name="booked_delivery" value="no" class="custom-control-input v-model=">-->
<!--                                <label class="custom-control-label" for="booked_delivery_2">no</label>-->
<!--                            </div>-->
<!--                            <span class="ml-2 c-section" :class="{'error':$v.formData.planned_oc.$error}">Planned C-section</span>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.planned_oc" type="radio" id="planned_oc_1" name="planned_oc" value="1" class="custom-control-input v-model=">-->
<!--                                <label class="custom-control-label" for="planned_oc_1">yes</label>-->
<!--                            </div>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.planned_oc" type="radio" id="planned_oc_2" name="planned_oc" value="0" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="planned_oc_2">no</label>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td class="border-none" colspan="3">-->
<!--                            <span :class="{'error':$v.formData.labor_pain.$error}">Presented with labor pain:</span>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.labor_pain" type="radio" id="labor_pain_1" name="labor_pain" value="yes" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="labor_pain_1">yes</label>-->
<!--                            </div>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.labor_pain" type="radio" id="labor_pain_2" name="labor_pain" value="no" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="labor_pain_2">no</label>-->
<!--                            </div>-->
<!--                            <span class="ml-2" :class="{'error':$v.formData.pregnancy_complication.$error}">Presented with complication of pregnancy</span>-->
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input v-model="formData.pregnancy_complication" type="radio" id="pregnancy_complication_1" name="pregnancy_complication" value="yes" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="pregnancy_complication_1">yes</label>-->
<!--                            </div>-->
<!--                            <div class="custom-control custom-radio custom-control-inline mr-4">-->
<!--                                <input v-model="formData.pregnancy_complication" type="radio" id="pregnancy_complication_2" name="pregnancy_complication" value="no" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="pregnancy_complication_2">no</label>-->
<!--                            </div>-->
<!--                            <span class="ml-2 explanation" v-if="formData.pregnancy_complication==='yes'">Explanation</span>-->
<!--                            <input v-model="formData.complication_explanation" type="text"  id="explanation_input" v-if="formData.pregnancy_complication==='yes'" />-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td class="border-none" colspan="2" style="border-right:none">-->
<!--                            <div class="form-group">-->
<!--                                <label>Provisional Diagnosis</label><span class="text-danger">*</span>-->
<!--                                <textarea v-model="formData.provisional_diagnosis" style="width:100%; box-shadow: 0.5px 0.5px  lightgrey" rows="4" :class="{'error':$v.formData.provisional_diagnosis.$error}"></textarea>-->
<!--                            </div>-->

<!--                        </td>-->
<!--                        <td class="border-none" colspan="1" style="border-left:none" >-->
<!--                            <div class="form-group">-->
<!--                                <label>Final Diagnosis</label><span class="text-danger">*</span>-->
<!--                                <textarea v-model="formData.final_diagnosis" style="width:100%; box-shadow: 0.5px 0.5px  lightgrey" rows="4"></textarea>-->
<!--                            </div>-->

<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td colspan="3" class="border-none">-->
<!--                            <v-file-input-->
<!--                                chips-->
<!--                                multiple-->
<!--                                label="Attach documents"-->
<!--                                v-model="accessory.file"-->
<!--                                >-->

<!--                            </v-file-input>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="border-none">-->
<!--                        <td colspan="3" class="border-none">-->
<!--                            Vital Signs-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="vital-sign">-->
<!--                        <td colspan="3">-->
<!--                            BP left: <input v-model="formData.bp_left" type="text" id="hide"/>-->
<!--                            <span class="ml-2">BP right:</span>-->
<!--                            <input v-model="formData.bp_right" type="text" />-->
<!--                            <span class="ml-2">Pulse:</span>-->
<!--                            <input v-model="formData.pulse" type="number"/>-->
<!--                            <span class="ml-2">Temp:</span>-->
<!--                            <input v-model="formData.temp" type="text"/>-->
<!--                            <span class="ml-2">SPO2:</span>-->
<!--                            <input v-model="formData.spo2" type="number"/>-->
<!--                            <span class="ml-2">Weight:</span>-->
<!--                            <input v-model="formData.weight" type="number"/>-->


<!--                        </td>-->
<!--                    </tr>-->
<!--                </table>-->

            </div>
            <button class="btn btn-primary btn-sm float-right d-print-none" @click="submit">Submit</button>
            <div class=" signature d-none d-print-block">
                <div class="ml-4">Senior Midwife</div>
                <div class="text-right mr-4">Patient or relative</div>
            </div>
            <div class="img-footer ">
                <v-img max-height="50" max-width="100" src="/storage/assets/media/images/system/Mhmlogo_PRINT.jpg"></v-img>
            </div>
        </v-app>
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
        name: "in_patient_admission",
        data(){
            return{
                formData:{

                        patient_id:'',
                        firstName:'',
                        lastName:'',
                        birthDate:'',
                        address:'',
                        tel:'',
                        mail:'',
                        date:'',
                        time:'',
                        in_patient_service_id:'',
                        in_patient_service_type:'',
                        in_patient_mom_baby:'',
                        level_of_care:'',
                        mobilisation_status:'',
                        bed_id:'',
                        emergency_case:false,
                        vaginal_bleeding:false,
                        severe_abdominal_pain:false,
                        high_fever:false,
                        severe_headache:false,
                        breathing_difficulty:false,
                        convulsions:false,
                        other_danger:'',
                        ga:'',
                        due_date_labor:'',
                        due_date_method:'',
                        cpn_ref:'',
                        ultrasound_ref:'',
                        booked_delivery:'',
                        planned_oc:'',
                        labor_pain:'',
                        pregnancy_complication:'',
                        complication_explanation:'',
                        provisional_diagnosis:'',
                        final_diagnosis:'',
                        bp_left:'',
                        bp_right:'',
                        pulse:'',
                        temp:'',
                        spo2:'',
                        weight:''
                },
                accessory:{
                    in_patient_service:'',
                    beds:'',
                    file:null,
                    last_code:'',
                    in_patient_service_type:['pregnancy','postpartum'],
                    in_patient_mom_baby:['Mom','Baby'],
                    level_of_care:['normal','intermediate','intensive'],
                    mobilisation_status: ['strict bed rest','bed rest','mobilisation','no restriction']
                }
            }
        },
        mixins: [validationMixin],
        validations(){
            return{
                formData:{
                    patient_id:{required},
                    date:{required},
                    time:{required},
                    in_patient_service_id:{required},
                    in_patient_service_type:{required},
                    in_patient_mom_baby:{required},
                    level_of_care:{required},
                    mobilisation_status:{required},
                    bed_id:{required},
                    ga:{required},
                    booked_delivery:{required},
                    planned_oc:{required},
                    labor_pain:{required},
                    pregnancy_complication:{required},
                    provisional_diagnosis:{required},
                }
            }
        },
        created(){
            this.init()
        },
        methods:{
            async change_patient(){
                let patData = await axios.get(`/api/v1/patient_system/in_patient/maternity/fetch_patient_data/${this.formData.patient_id}`);
                this.formData.firstName=patData.data.patient_data.firstName
                this.formData.lastName=patData.data.patient_data.lastName
                this.formData.birthDate=patData.data.patient_data.birthDate
                this.formData.address=patData.data.patient_data.adress
                this.formData.tel=patData.data.patient_data.tel
                this.formData.mail=patData.data.patient_data.email
                this.formData.cpn_ref= patData.data.patient_data.cpn_admissions.length>0?patData.data.patient_data.cpn_admissions[0].id:''
                this.formData.ultrasound_ref=patData.data.patient_data.ultra_sound_admissions.length>0?patData.data.patient_data.ultra_sound_admissions[0].id:''

                if(patData.data.patient_data.cpn_admissions.length>0){
                    this.formData.due_date_method=patData.data.patient_data.cpn_admissions[0].dpa_method
                    switch ( patData.data.patient_data.cpn_admissions[0].dpa_method){
                        case 'echo':
                            this.formData.due_date_labor=patData.data.patient_data.cpn_admissions[0].dpa_echo
                            break;
                        case 'calc':
                            this.formData.due_date_labor=patData.data.patient_data.cpn_admissions[0].dpa_calc
                            break;
                        case 'corrected':
                            this.formData.due_date_labor=patData.data.patient_data.cpn_admissions[0].dpa_corrected
                            break;
                    }
                    this.formData.planned_oc=patData.data.patient_data.cpn_admissions[0].planned_oc
                }


                this.formData.ga= patData.data.ga
                // this.formData= Object.assign(this.formData,patData.data.patient_data)
            },
            async init(){
                await axios.get('/api/v1/patient_system/in_patient/service/7').then(response=>this.accessory.in_patient_service=response.data)
                await axios.get('/api/maternity/last_code').then(response=>{this.accessory.last_code=response.data.length>0?response.data:'2021-MA-0001'})
            },
            async fetch_free_bed(){
                await axios.get('/api/free_bed/'+this.formData.in_patient_service_id).then(response=>{
                    this.accessory.beds= response.data
                })

            },
            async submit(){
                this.$v.$touch()
                if(!this.$v.$invalid){
                    this.formData.code=this.new_code
                    await axios.post('/api/maternity/maternity_admission',this.formData)
                        .then(response=>{
                            //upload the files
                            if(this.accessory.file!==null) this.upload_file(response.data)
                        })
                    this.$toast.open({
                        message:'data submited',
                        position:'top-right'
                    })
                    this.reset_form()
                    this.$v.$reset()
                }
            },
            upload_file(admission_id){
                const config= {
                    headers:{
                        'content-type':'multipart/form-data'
                    }
                }
                let formData = new FormData();
                formData.append('maternity_admission_id',admission_id)
                for(let i=0; i<this.accessory.file.length;i++){
                    formData.append(`file${i}`,this.accessory.file[i])
                }
                axios.post('/api/maternity/upload_files',formData,config)
            },
            print(){
                window.print()
            },
            reset_form(){
                let src= this.formData
                for (const key of Object.keys(src)){
                    if(typeof(src[key])==='boolean'){
                        src[key]=false
                    }else{
                        src[key]=''
                    }
                }
            }
        },
        computed:{
            new_code(){
                let date = new Date();
                let intPart = parseInt(this.accessory.last_code.split("-")[2]);
                intPart++;
                let zero = "";
                let intPart_length = intPart.toString().length;
                for (let i = 0; i < 5 - intPart_length; i++) {
                    zero += "0";
                }
                return  date.getFullYear() + "-MA-" + zero + intPart;
            }
        }
    }
</script>

<style scoped>
.title{
    background-color: #1A417E;
    color:whitesmoke;
}
input{
    border:0.5px  solid lightgrey;
}
#patient_gl_info{
    width:100%;
    border: 1px solid black;

}
/*!*#patient_gl_info > th,tr,td {*!*/
/*!*    border: 1px solid black;*!*/
/*!*    padding: 5px;*!*/
/*!*}*!*/
/*#patient_gl_info input{*/
/*    width:80%;*/
/*}*/
/*#patient_contact_table,#patient_admission_details {*/
/*    width:100%;*/

/*}*/
/*#patient_contact_table > tr,td{*/
/*    border-top:none;*/
/*}*/
#patient_admission_details{
 margin-top:3px;
}
.border-none {
    border-top:none;
    border-bottom: none;
}
.signature {
    display:flex;
    flex-direction: row;
}
.signature div{
    flex-basis: 100%;
}
.img-footer{
    position:fixed;
    bottom: 10px;
    visibility:hidden;
}
@media all and (max-width: 1370px){
    .container{
        width:90% !important;
    }
    .explanation{
        display: block;
    }
    #explanation_input{
        width:100%;
    }
    .vital-sign td input{
        width: 50px;
    }
    .preg_data input[type=text]{

        width:50px;
    }
    .c-section{
        display:inline-block;
    }
}
@media print{
    .container{
        margin-top: -50px;
    }
    .img-footer{
    visibility:visible;
    }
}
</style>
