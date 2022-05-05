<template>
<div class="container w-75">
    <v-card>
        <v-card-title>BALANCE SHEET</v-card-title>
        <v-card-text>
            <span class="text-danger">Remember:</span>Check every 2 to 4 hours for urine:if two times zero, please inform Tanja immediately<br>
            ({{stork_admission.patient.id}})-{{nullToStr(stork_admission.patient.firstName) +" "+ nullToStr(stork_admission.patient.lastName)  }}
<!--            <table class="table-sm table table-bordered">-->
<!--                <tr>-->
<!--                    <td>-->
<!--                        Start(Date/time)-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <input type="date"/>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        End(Date/time)-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <input type="date"/>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        Number of hours-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <input type="number"/>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <div class="row mt-2">
                <div class="col in_form">
                    <h2 class="text-center">IN</h2>
                    <table class="table-sm table table-bordered">
                        <tr>
                            <td>Time</td>
                            <td>What</td>
                            <td>ml</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="time" v-model="formData_in.time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <select class="form-control form-control-sm" v-model="formData_in.what">
                                    <option v-for="opt in in_what_options">{{opt}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" v-model="formData_in.value" class="form-control form-control-sm"/>

                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" @click="submit_in">Submit </button>
                            </td>
                        </tr>
                        <tr v-for="row in list.in">
                            <td>
                                <input type="time" readonly :value="row.time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" :value="row.what" readonly/>

                            </td>
                            <td>
                                <input type="number" readonly :value="row.value" class="form-control form-control-sm"/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td></td>
                            <td class="font-weight-bold">{{total_in}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col out_form">
                    <h2 class="text-center">OUT</h2>
                    <table class="table-sm table table-bordered">
                        <tr>
                            <td>Time</td>
                            <td>What</td>
                            <td>ml</td>
                            <td>P</td>
                            <td>K</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="time" v-model="formData_out.time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <select class="form-control form-control-sm" v-model="formData_out.what">
                                    <option v-for="opt in out_what_options">{{opt}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" v-model="formData_out.value" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" v-model="formData_out.p" class="form-control "/>
                            </td>
                            <td>
                                <input type="checkbox" v-model="formData_out.k" class="form-control"/>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" @click="submit_out">Submit </button>
                            </td>
                        </tr>
                        <tr v-for="row in list.out">
                            <td>
                                <input type="time" readonly :value="row.time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" :value="row.what" readonly/>

                            </td>
                            <td>
                                <input type="number" disabled :value="row.value" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" disabled v-model="row.p" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" disabled v-model="row.k" class="form-control form-control-sm"/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td></td>
                            <td class="font-weight-bold">{{total_out}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <h4 class="font-weight-bold">RESULT: &nbsp{{total_in-total_out}}</h4>
            <v-expansion-panels>
                <v-expansion-panel
                >
                    <v-expansion-panel-header class="text-danger">
                        Close Balance Sheet
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <div class="row">
                          <div class="col form-group">
                              <label>End (Date/time)</label>
                              <input type="date" class="form-control form-control-sm" v-model="close_data.date_end"/>
                          </div>
                          <div class="col form-group">
                              <label>Number of hours</label>
                              <input type="number" class="form-control form-control-sm" v-model="close_data.number_of_hours"/>
                          </div>
                      </div>
                      <v-btn small color="purple" dark @click="close_balance">Submit</v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import { validationMixin } from "vuelidate";
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
    name: "balance_sheet",
    mixins: [validationMixin],
    data:()=>({
        list:{
            in:[],
            out:[]
        },
        stork_admission:{
            patient:{}
        },
        stork_balance:null,
        formData_in:{
            time:'',
            what:'',
            value:'',
            stork_balance_id:''
        },
        formData_out:{
            time:'',
            what:'',
            value:'',
            p:false,
            k:false,
            stork_balance_id:''
        },
        close_data:{
            stork_balance_id:'',
            date_end:'',
            number_of_hours:''
        },
        in_what_options:['milk','ampicillin','glucose','cafein'],
        out_what_options:['diaper','vomit','suction']
    }),
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get(`/api/v1/patient_system/in_patient/stork/balance/${this.$route.params.balance_sheet.id}`).then(response=>{
                this.stork_admission=response.data.stork_admission
                this.list.in=response.data.balance_ins
                this.list.out=response.data.balance_outs
            })
            this.stork_balance= this.$route.params.balance_sheet
        },
        nullToStr(text){
           return text===null?'':text
        },
        submit_in(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                this.formData_in.stork_balance_id=this.stork_balance.id
                axios.post("/api/v1/patient_system/in_patient/stork/store_balance_in",this.formData_in)
                this.list.in.push(this.formData_in)
                this.formData_in={
                    time:'',
                    what:'',
                    value:'',
                    stork_balance_id:''
                }
            }
        },
        submit_out(){
            if(this.formData_out.value !==''){
                this.formData_out.stork_balance_id=this.stork_balance.id
                axios.post("/api/v1/patient_system/in_patient/stork/store_balance_out",this.formData_out)
                this.list.out.push(this.formData_out)
                this.formData_out={
                    time:'',
                    what:'',
                    value:'',
                    p:false,
                    k:false
                }
            }

        },
        close_balance(){
            if(this.close_data.date_end !=='' && this.close_data.number_of_hours){
                this.close_data.stork_balance_id=this.stork_balance.id
                axios.post("/api/v1/patient_system/in_patient/stork/close_balance",this.close_data).then(
                    this.$toast.open({
                        message:'Balance closed',
                        type:'success'
                    })
                )
                this.$router.push({name:'stork_patient_list'})
            }
        }
    },
    computed:{
        total_in(){
            return (this.list.in.length>0)?this.list.in.reduce(( sum , cur ) => sum + parseInt(cur.value) , 0):0
        },
        total_out(){
            return (this.list.out.length>0)?this.list.out.reduce(( sum , cur ) => sum + parseInt(cur.value) , 0):0
        },

    },
    validations:{
        formData_in:{
            time:{required},
            what:{required},
            value:{required},
        }
    }
}
</script>

<style scoped>
input[type=number]{
    max-width: 80px;
}
</style>
