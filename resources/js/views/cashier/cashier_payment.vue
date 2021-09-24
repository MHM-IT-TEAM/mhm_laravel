<template>
    <div class="container w-75">
        <v-app>
            <h2 class="text-center title">Patient payment Form</h2>
            <div class="p-2">
                <input type="number"
                       v-if="direct_payment"
                       class="form-control form-control-sm"
                       style="width:200px"
                       placeholder="write the patient Id"
                       @change="fetch_patient"
                       v-model="patient_id"/>
            </div>
            <h3 class="p-2">{{patient_full_name}}</h3>
            <div class="panel panel-default p-4 m-4 bg-light">
                <section >
                    <h6> Former Transactions</h6>
                    <table class="table table-bordered mt-4" id="paymentRecords">
                        <thead>
                        <th>Date</th>
                        <th>Transac Nr</th>
                        <th>Nature</th>
                        <th>Last due</th>
                        <th>Value</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <tr v-for="line in former_transactions">
                            <td> {{moment(line.created_at).format("DD/MM/YYYY")}}</td>
                            <td>{{line.id}}</td>
                            <td> {{line.nature}}</td>
                            <td> {{line.last_due}}</td>
                            <td> {{line.to_pay}}</td>
                            <td> {{line.paid}}</td>
                            <td> {{line.new_debt}}</td>
                            <td>
                                <v-btn
                                    x-small
                                    v-if="line.new_debt>0"
                                    color="blue-grey"
                                    class="ma-2 white--text"
                                    @click="pay_due(line)"
                                >
                                    Pay
                                </v-btn>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Total</strong></td>
                            <td><strong>{{current_debt}}</strong></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </section>
                <section>
                    <h6> Transaction for today</h6>
                    <table id="todayTransac" class="table table-bordered mt-2 ">
                        <thead>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        </thead>
                        <tbody>
                        <tr v-for="detail in unpaid_treatments">
                            <td>
                                {{detail.activity_price.name}}
                            </td>
                            <td>
                                {{detail.total/detail.qty}}
                            </td>
                            <td>
                                {{detail.qty}}
                            </td>
                            <td>
                                {{detail.total}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
                <section v-if="!already_paid">
                    <input type="hidden" name=" consult_id" />
                    <input type="hidden" name=" patId" />
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="last_due"> Last Due</label>
                                <input type="text" name="last_due"  class="form-control" disabled v-model="formData.last_due"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="toPay"> to pay</label>
                                <input type="text" name="toPay" id="toPay" class="form-control" disabled v-model="formData.to_pay" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="paid"> paid</label>
                                <input type="number" class="form-control"  required v-model.number="formData.paid" :class="{'form-control is-invalid':$v.formData.paid.$error}"/>
                                <span class="invalid-feedback" v-if="$v.formData.paid.$error">check the amount</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="paid"> New Due</label>
                                <input type="text" name="new_due" id="new_due" class="form-control" disabled :value="new_debt"/>
                            </div>
                        </div>
                        <div class="col-8">
                            <button type="submit" id="submit" class="btn btn-primary mt-4 " @click.prevent="submit" > Submit</button>
                        </div>
                    </div>
                </section>
                <v-dialog
                    v-model="payment_dialog"
                    max-width="290"
                    persistent
                >
                    <v-card>
                        <v-card-title class="text-h6">
                            Amount to be paid
                        </v-card-title>

                        <v-card-text>
                            <input type="number" class="form-control form-control-sm" v-model.number="due_payment.paid"/>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="red darken-1"
                                text
                                @click="payment_dialog = false"
                            >
                                cancel
                            </v-btn>


                            <v-btn
                                color="green darken-1"
                                text
                                @click="submit_due_payment"
                            >
                                Pay
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-app>
    </div>
</template>

<script>
import moment from "moment"
import {validationMixin} from "vuelidate";

const {
    required,
    numeric,
    requiredIf,
    maxValue
} = require("vuelidate/lib/validators");
export default {
    name: "cashier_payment",
    mixins: [validationMixin],
    data(){
        return{
            admission:{
                patient:{
                    firstName:'',
                    lastName:'',
                },
                service_activity:{
                    name:''
                },
                admission_care_details:[]

            },
            formData:{
               admission_id:'',
               patient_id:'',
               last_due:'',
               to_pay:'',
               paid:null,
               nature:'',
               new_debt:''
            },
            former_transactions:[],
            patient_dues:[],
            already_paid:'',
            payment_dialog:false,
            due_payment:{
                paid:'',
                patient_id:'',
                admission_id:'',
                nature:''
            },
            direct_payment:false,
            patient_id:''
        }
    },
    created(){
        this.init()
    },
    validations(){
        return{
            formData:{
                paid:{
                    required,
                    maxValue:maxValue(this.formData.to_pay)
                }
            }
        }
    },
    watch:{
        new_debt(val){
            this.formData.new_debt=val
        },
    },
    methods:{
        async init(){

            if(this.$route.params.paid===1) this.already_paid=true
            if(this.$route.params.admission){
                this.admission=this.$route.params.admission
                this.formData.patient_id=this.admission.patient_id
                this.fetch_data()
                this.formData.nature= this.admission.service_activity.name + "-"+ moment(this.admission.created_at).format("DD/MM/YYYY")
            }else{
                this.already_paid=true
                this.direct_payment=true
            }
        },
        async fetch_data(){
            await axios.get(`/api/v1/patient_system/cashier/patient_due/${this.formData.patient_id}`).then(response=>{
                this.formData.last_due=response.data
            })
            this.formData.to_pay=this.to_pay
            this.formData.admission_id=this.admission.id
            axios.get(`/api/v1/patient_system/cashier/former_transactions_list/${this.formData.patient_id}`).then(response=>this.former_transactions=response.data)
        },
        async submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.care_details=this.unpaid_treatments
            await axios.post('/api/v1/patient_system/cashier/pay',this.formData).then(response=>{
                if(response.data.success){
                    window.open(`invoices/payment/${this.admission.id}`);
                    this.$router.push({name:'cashier_admission_list'})
                }
            })
        },
        pay_due(transaction){
            this.payment_dialog=true
            this.due_payment.id=transaction.id
            this.due_payment.patient_id=transaction.patient_id
            this.due_payment.admission_id=transaction.admission_id
            this.due_payment.nature=`Payment Transaction Nr-${transaction.id} `
        },
        async submit_due_payment(){
           await axios.post("/api/v1/patient_system/cashier/pay_previous_transaction",this.due_payment)
            this.payment_dialog=false
            this.fetch_data()
            // axios.get(`/api/v1/patient_system/cashier/former_transactions_list/${this.formData.patient_id}`).then(response=>this.former_transactions=response.data)
        },
        async fetch_patient(){
           this.formData.patient_id= this.patient_id
           await axios.get(`/api/v1/patient_system/patient/patient/${this.patient_id}`).then(response=>{
                this.admission.patient.firstName= response.data.firstName
                this.admission.patient.lastName= response.data.lastName
            })
            this.fetch_data()
        }
    },
    computed:{
        patient_full_name(){
            return null_to_empty(this.admission.patient.firstName)+ " "+ null_to_empty(this.admission.patient.lastName)
        },
        new_debt(){
            return this.formData.to_pay- this.formData.paid
        },
        unpaid_treatments(){
            return this.admission.admission_care_details.filter(care => care.payment_status === 0)
        },
        to_pay(){
            let to_pay
            if(this.unpaid_treatments.length===0) to_pay=this.formData.last_due
            else if(this.unpaid_treatments.length===1) to_pay=parseInt(this.unpaid_treatments[0].total)+parseInt(this.formData.last_due)
            else if (this.unpaid_treatments.length>1) to_pay=this.unpaid_treatments.reduce((acc,obj)=>parseInt(acc.total)+parseInt(obj.total))+parseInt(this.formData.last_due)
            return to_pay
        },
        current_debt(){
            if(this.former_transactions.length>0){
                let debt=0;
                this.former_transactions.forEach(item=>{
                    if (item.new_debt===null) item.new_debt=0
                    debt+= parseInt(item.new_debt)
                })
                return debt
            }
        }
    }
}
function null_to_empty(val){
    if(val ===null)return ''
    else return val
}
</script>

<style scoped>
.container{
    margin-top: 50px;
}
.title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px;
    font-size: 50px;
    font-weight: bold;
    color: #7c795d;
}
</style>
