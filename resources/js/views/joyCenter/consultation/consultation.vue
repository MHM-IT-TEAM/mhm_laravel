<template>
    <div class="container w-75">
        <v-app>
            <h1 class="text-center form-title">CONSULTATION FORM</h1>
            <div class="inline mb-4">Quick search <input type="number" class="required" style="width:80px" @change="fetch_reference" v-model="formData.id"/></div>
            <table class="table table-sm">
                <tr>
                    <th class="table-title" colspan="3"><v-icon>mdi-account-circle</v-icon> Personal information <span :class="{'text-primary':formData.priority==='BLUE'}" v-if="formData.priority==='BLUE'">Blue priority</span></th>
                </tr>
                <tr>
                    <td style="width:20%"><span class="text-danger">*</span>Id</td>
                    <td style="width:40%">First name</td>
                    <td style="width:40%">Last name</td>
                </tr>
                <tr>
                    <td>
                        <input type="number" class="border required" v-model="formData.patient.id" @change="changePat" :class="{'border border-danger':$v.formData.patient.id.$error}"/>
                        <p class="text-white bg-danger" v-if="$v.formData.patient.id.$error">The patient id is required</p>
                    </td>
                    <td class="required">
                        {{formData.patient.firstName}}
                    </td>
                    <td class="required">
                        {{formData.patient.lastName}}
                    </td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td>Address</td>
                    <td>Tel</td>
                </tr>
                <tr>
                    <td class="required">{{formData.patient.birthDate}}</td>
                    <td class="required" :class="{'text-white bg-success':formData.patient.sector===true}">{{formData.patient.adress}}</td>
                    <td class="required">{{formData.patient.tel}}</td>
                </tr>
            </table>
            <table class="table table-sm">
                <tr>
                    <th class="table-title" colspan="5"> <v-icon>mdi-stethoscope</v-icon>Medical data</th>
                </tr>
                <tr>
                    <td>
                        <select class="required" v-model="formData.type_consult_id" @change="changeConsult">
                            <option value=""><span class="text-danger">*</span>Type of consultation</option>
                            <option v-for="item in accessory.type_consultation" :value="item.id">{{item.name}}</option>
                        </select>
                        <p class="text-white bg-danger" v-if="$v.formData.type_consult_id.$error">The type of consultation is required</p>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" @click="accessory.blue_priority_modal=true" v-if="!accessory.elderly_patient">Manual blue priority</button>
                    </td>
                    <td class="text-primary">{{formData.blue_priority_reason}}</td>
                </tr>
                <tr>
                    <td>Temp</td>
                    <td>Weight</td>
                    <td>Blood Pressure</td>
                    <td>Pulse</td>
                    <td>Spo2</td>
                </tr>
                <tr>
                    <td>
                        <input type="number" class="required"  v-model="formData.temp" :class="{'text-danger': formData.temp>=38}"/>
                    </td>
                    <td>
                        <input type="number" class="required"  v-model="formData.weight"/>
                    </td>
                    <td>
                        <input type="number" class="required"  v-model="formData.taSysto" :class="{'text-danger': formData.taSysto>=14}"/> /
                        <input type="number" class="required"  v-model="formData.taDia"/>
                    </td>
                    <td>
                        <input type="number" class="required" v-model="formData.pulse" />
                    </td>
                    <td>
                        <input type="number" class="required" v-model="formData.spo2" :class="{'text-danger': formData.taSysto>=75}"/>
                    </td>
                </tr>
            </table>
            <table class="table table-sm">
                <tr>
                    <th class="table-title">
                        <v-icon>mdi-calendar-check</v-icon>
                        Remarks:
                    </th>
                </tr>
                <tr>
                    <td>
                        <textarea class="form-control form-control-sm" v-model="formData.remark"></textarea>
                    </td>
                </tr>
            </table>
            <table class="table table-sm">
                <tr>
                    <th class="table-title">
                        <v-icon>mdi-cash</v-icon>
                        Payment
                    </th>
                </tr>
            </table>
            <div class="row">
                <div class="col-6">
                    <table class="table table-sm" v-if="formData.type_consult_id!==''">
                        <tr>
                            <td>
                                <select class="required" v-model="accessory.temp_care_line">
                                    <option v-for="item in accessory.servicePrice" :value="item">{{item.name}}</option>
                                </select>
                            </td>
                            <td>
                                {{accessory.temp_care_line.price}}
                            </td>
                            <td>
                                <input type="number" class="required" @keypress.enter.prevent="add_care_line" v-model="accessory.temp_care_line.qty"/>
                            </td>
                            <td>
                                {{accessory.temp_care_line.qty * accessory.temp_care_line.price }}
                            </td>
                        </tr>
                        <tr v-for="(line,i ) in formData.patient_care_details">
                            <td>{{line.name}}</td>
                            <td>{{line.price}}</td>
                            <td>{{line.qty}}</td>
                            <td>{{line.qty * line.price}}</td>
                            <td>
                                <v-btn
                                    x-small
                                    icon
                                    @click="delete_care_line(i)"
                                >
                                    <v-icon> mdi-delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table table-sm">
                        <tr>
                            <td>In debt</td>
                            <td :class="{'text-danger':formData.patient.last_due>0}">{{formData.patient.last_due}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Subtotal</td>
                            <td>{{subTotal}}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td class="font-weight-bold text-decoration-underline">{{subTotal + formData.patient.last_due}}</td>
                        </tr>
                    </table>
                    <div class="text-right mt-6">
                        <v-btn color="info" :loading="accessory.form_is_submitting" @click="submit">submit</v-btn>
                    </div>
                </div>
            </div>

            <v-dialog
                v-model="accessory.blue_priority_modal"
                width="500"
                :persistent="true"
            >
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">
                        Blue Priority
                    </v-card-title>

                    <v-card-text >
                        <v-textarea v-model="formData.blue_priority_reason" label="write here the reason">
                        </v-textarea>
                    </v-card-text>


                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                            @click="validate_priority_reason"
                        >
                            I accept
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
</template>
<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
    export default {
        name: "consultation",
        mixins: [validationMixin],
        props: ['edit','reference'],
        data() {
            return {
                formData: {
                    id: "",
                    type_consult_id:'',
                    priority: "",
                    status: "RUNNING",
                    temp: "",
                    pulse: "",
                    taSysto: "",
                    taDia: "",
                    weight: "",
                    spo2:"",
                    blue_priority_reason:'',
                    patient: {
                        id: "",
                        firstName: "",
                        lastName: "",
                        birthDate:"",
                        adress: "",
                        tel:"",
                        sector: false,
                        last_due: 0,
                    },
                    remark:'',
                    patient_care_details: []
                },
                accessory: {
                    servicePrice: [],
                    type_consultation: [],
                    fokontany: [],
                    noPatientFound: false,
                    temp_care_line:{id:'',name:'',price:'', qty:''},
                    blue_priority_modal:false,
                    elderly_patient:false,
                    form_is_submitting:false,
                    form_update:false
                },

            }
        },
        created() {
            this.init()
        },
        watch: {
            formData:{
                handler(val){
                    if(val.priority !=='BLUE'){
                        if(val.temp >= 38 ||val.taSysto >= 14) val.priority='GREEN'
                        else if(val.sop2 >0 && val.sop2 <=75 ) val.priority='GREEN'
                        else val.priority=''
                    }
                },
                deep:true
            },
        },
        validations:{
            formData:{
                type_consult_id:{required},
                patient:{
                    id:{required}
                }
            }
        },
        methods: {
            async init() {
                axios.get('/api/typeConsult').then(response=>this.accessory.type_consultation=response.data)
                axios.get("/api/fokontany").then(response => response.data.forEach(fkt => this.accessory.fokontany.push(fkt.name.toLowerCase())))
                if(this.reference !=='' && this.reference !==undefined){
                    this.formData.id=this.reference
                    this.fetch_reference()
                }
            },
            async changePat() {
                await axios.get(`/api/patients/${this.formData.patient.id}/edit`)
                    .then(response => {
                        this.resetForm()
                        if (response.data.success) {
                            this.formData.patient = response.data.patient
                            this.formData.patient.last_due =response.data.dueSum
                            let adress = this.formData.patient.adress.toLowerCase().split(' ')
                            let check = false
                            adress.forEach(ad => {
                                if (this.accessory.fokontany.indexOf(ad) !== -1) {
                                    check = true
                                }
                            })
                            this.formData.patient.sector = check
                            if(this.check_age>=80){
                                this.$toast.open({message:'elderly patient, manual blue priority',position:'top-right',type:'info'})
                                this.formData.priority='BLUE'
                                this.accessory.elderly_patient=true
                            }
                        } else {
                            this.accessory.noPatientFound = true
                        }
                    })

            },
            async changeConsult() {
                let servicePrice = await axios.get('/api/servicePrice', {
                    params: {
                        type_consult: this.formData.type_consult_id,
                        sector: this.formData.patient.sector
                    }
                })
                this.validate_consult_type()
                this.accessory.servicePrice = servicePrice.data
            },
            add_care_line(){
                let line= this.accessory.temp_care_line
                line.amount= line.price * line.qty
                this.formData.patient_care_details.push(line)
            },
            delete_care_line(rowId) {
                return  this.formData.patient_care_details.splice(rowId, 1)
            },
            async submit() {
                this.$v.$touch()
                if (this.$v.$invalid) {
                    return true;
                }
                // this.accessory.form_is_submitting=true
                this.formData.responsible= window.auth.user.name
                if(!this.accessory.form_update){
                    await axios.post('/api/consultation',this.formData).then(response=>{
                        if(response.data.success){
                            this.accessory.form_is_submitting=false
                            this.$toast.open({message:response.data.msg,position:'top-right',type:'success'})
                            this.resetForm()
                            this.$v.$reset()
                        }
                    })
                }else{
                    await axios.put(`/api/consultation/${this.formData.id}`,this.formData).then(response=>{
                        if(response.data.success){
                            if(this.edit){
                                this.$emit('updated')
                            }else{
                                this.$toast.open({message:response.data.msg,position:'top-right',type:'success'})
                            }
                        }
                    })
                }
            },
            resetForm() {
                this.formData = {
                    id: "",
                    type_consult_id:'',
                    priority: "",
                    status: "RUNNING",
                    temp: "",
                    pulse: "",
                    taSysto: "",
                    taDia: "",
                    weight: "",
                    spo2:"",
                    blue_priority_reason:'',
                    patient: {
                        id: "",
                        firstName: "",
                        lastName: "",
                        birthDate:"",
                        adress: "",
                        tel:"",
                        sector: false,
                        last_due: 0,
                    },
                    remark:'',
                    patient_care_details: []
                }
            },
            validate_priority_reason(){
                if(this.formData.blue_priority_reason !==""){
                    this.accessory.blue_priority_modal=false
                }
            },
            async validate_consult_type(){
                let restricted_by_gender=[
                    4,//cpn
                    5,//ultrasound
                    6//postpartum
                ]
                let restricted_by_age=[
                    7,//vacccination
                    8,//baby checkup
                    10
                ]
                let checkup_weight=[1,2,4,5,6]
                if(this.formData.patient.gender==='M' && restricted_by_gender.indexOf(this.formData.type_consult_id)!== -1){
                    this.$toast.open({message:'the patient is not female',position:'top-right',type:'error'})
                    this.formData.type_consult_id=""
                }
                if(this.check_age >50 && restricted_by_gender.indexOf(this.formData.type_consult_id)!== -1 ){
                    this.$toast.open({message:'the patient is too old for obstetrics service',position:'top-right',type:'error'})
                    this.formData.type_consult_id=""
                }
                if(this.formData.patient.height <=50 && restricted_by_gender.indexOf(this.formData.type_consult_id)!== -1 ){
                    this.$toast.open({message:'The height of the patient is required for obstetrics service, no height found in database',position:'top-right',type:'error'})
                    this.formData.type_consult_id=""
                }
                if(this.check_age>=2 && restricted_by_age.indexOf(this.formData.type_consult_id)!== -1 ){
                    this.$toast.open({message:'only baby equal or under two years old are admissible for this service',position:'top-right',type:'error'})
                    this.formData.type_consult_id=""
                }
                //check if the patient is today already in the system
                await axios.post('/api/consultation/today',{type_consult_id:this.formData.type_consult_id,patient_id:this.formData.patient.id}).then(response=>{
                    if(response.data.length>0){
                        this.$toast.open({message:'A patient cannot in on day consult the same service more than once',position:'top-right',type:'error'})
                        this.formData.type_consult_id=""
                    }
                })
            },
            async fetch_reference(){
                await axios.get(`/api/consultation/${this.formData.id}`).then(
                    response=>{
                        this.accessory.form_update=true
                        let care_details=[]
                        this.formData=response.data
                        this.formData.patient.last_due=response.data.patient.patient_due !== null? parseInt(response.data.patient.patient_due.amount):0
                        response.data.patient_care_details.forEach((line)=>{
                             let output={
                                 id:line.service_prices.id,
                                 name:line.service_prices.name,
                                 price:line.service_prices.price,
                                 qty:line.qty,
                                 amount:line.qty*line.service_prices.price
                             }
                             care_details.push(output)
                        })
                        this.formData.patient_care_details= response.data.patient_care_details.length>0?[...care_details]:[]
                        this.changeConsult()
                })
            }
        },
        computed: {
            subTotal(){
                let subTot=0;
                if(this.formData.patient_care_details.length>0)this.formData.patient_care_details.forEach((line)=>subTot+=parseInt(line.amount))
                return subTot
            },
            check_age(){
                let now= new Date().getFullYear()
                let birthDate= new Date(this.formData.patient.birthDate)
                return now-birthDate.getFullYear()
            },
        }
    }
</script>
<style scoped>
.container{
    margin-top: 40px;
    background-color: white;
    min-height:90vh;
    padding:40px;
}
.table-title{
    background-color: #cceff0;
}
.required{
    background-color: rgba(233, 242, 238, 0.7);
}
.form-title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px; font-size: 40px;
    font-weight: bold;
    color: #7c795d;
}
</style>
