<template>
    <div class="container w-75">
         <v-app>
             <patient_information :patient_id="formData.admission.patient_id" />
             <table class="table table-stripped table-sm" v-if="accessory.is_adult">
                 <caption v-if="accessory.previous_checkup">
                     Checkup date: {{accessory.previous_checkup_date}}
                 </caption>
                 <tr>
                     <th class="table-title" colspan="16"> <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B) Today's actions</th>
                 </tr>
                 <tr>
                     <td v-for="tooth in first_row"  class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.value)">
                         {{tooth.diagnostic.symbol}}

                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in first_row" class="text-center">
                         {{tooth.id.substring(1)}}
                     </td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in first_row" class="text-center">
                         <v-btn  x-small :disabled="tooth.diagnostic.symbol==='X'"
                                 @click="process(tooth,i,1)" :class="td_color(tooth.diagnostic.value)"
                                 v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>
                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row" class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.value)">
                         {{tooth.diagnostic.symbol}}</td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row"  class="text-center">{{tooth.id.substring(1)}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in second_row" class="text-center">
                         <v-btn x-small :disabled="tooth.diagnostic.symbol==='X'"
                                @click="process(tooth,i,2)" :class="td_color(tooth.diagnostic.value)"
                                v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>

                     </td>
                 </tr>
                 <tr>
                     <td colspan="16">
                         <div class="form-check">
                             <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="formData.cleaning_necessary">
                             <label class="form-check-label" for="exampleCheck1">Cleaning necessary</label>
                         </div>
                     </td>
                 </tr>
             </table>
             <table class="table table-stripped table-sm" v-if="!accessory.is_adult">
                 <caption v-if="accessory.previous_checkup">
                     Checkup date: {{accessory.previous_checkup_date}}
                 </caption>
                 <tr>
                     <th class="table-title" colspan="16"> <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B) Today's actions</th>
                 </tr>
                 <tr>
                     <td v-for="tooth in first_row"  class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.value)">
                         {{tooth.diagnostic.symbol}}

                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in first_row" class="text-center">
                         {{tooth.id.substring(1)}}
                     </td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in first_row" class="text-center">
                         <v-btn  x-small :disabled="tooth.diagnostic.symbol==='X'"
                                 @click="process(tooth,i,1)" :class="td_color(tooth.diagnostic.value)"
                                 v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>
                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row" class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.value)">
                         {{tooth.diagnostic.symbol}}</td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row"  class="text-center">{{tooth.id.substring(1)}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in second_row" class="text-center">
                         <v-btn x-small :disabled="tooth.diagnostic.symbol==='X'"
                                @click="process(tooth,i,2)" :class="td_color(tooth.diagnostic.value)"
                                v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>

                     </td>
                 </tr>
                 <tr>
                     <td colspan="16">
                         <div class="form-check">
                             <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="formData.cleaning_necessary">
                             <label class="form-check-label" for="exampleCheck1">Cleaning necessary</label>
                         </div>
                     </td>
                 </tr>
             </table>
             <div class="text-right mt-2" v-if="!accessory.checkup_saved && !accessory.previous_checkup && !accessory.today_operation_paid">
                 <v-btn color="warning" small  @click="submit_checkup" >Save Checkup</v-btn>
             </div>
             <div class="text-left mt-0" v-if="!accessory.today_operation_paid && accessory.previous_checkup ">
                 <v-btn color="warning" small  @click="accessory.case_opened=true" v-if="!accessory.today_operation_paid" >Continue treatment</v-btn>
             </div>
            <section class="overview mt-2" v-if="accessory.checkup_saved || accessory.case_opened">
                <h5 style="color:#1390C6;">Today Operation</h5>
                <table class="table-sm table">
                    <tr>
                        <th>Nature</th>
                        <th>List</th>
                        <th>Count</th>
                        <th>Unit price</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td style="color:red">Extraction</td>
                        <td style="width:30%">
                            <span v-for="i in today_process.extraction">{{i.id}} - </span>
                        </td>
                        <td>{{today_process.extraction.length}}</td>
                        <td>{{accessory.price_list.extraction.price}}</td>
                        <td>{{prices.extraction}}</td>
                    </tr>
                    <tr>
                        <td style="color:green">Care</td>
                        <td style="width:30%">
                            <span v-for="i in today_process.care">{{i.id.substring(1)}} - </span>
                        </td>
                        <td>{{today_process.care.length}}</td>
                        <td>{{accessory.price_list.care.price}}</td>
                        <td>{{prices.care}}</td>
                    </tr>
                    <tr>
                        <td style="color:blue">Followup Care</td>
                        <td style="width:30%">
                            <span v-for="i in today_process.followup_care">{{i.id.substring(1)}} - </span>
                        </td>
                        <td>{{today_process.followup_care.length}}</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td style="color:green">Cleaning</td>
                        <td style="width:30%">
                            <span v-if="formData.cleaning_necessary">All teeth</span>
                        </td>
                        <td>-</td>
                        <td>{{accessory.price_list.Cleaning.price}}</td>
                        <td>{{prices.Cleaning}}</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-weight-bold">{{prices.care +prices.Cleaning +prices.extraction}}</td>
                    </tr>
                </table>
                <div class="text-right mt-6">
                    <v-btn color="warning" small  @click="send_to_cashier">Send_to_cashier</v-btn>
                </div>
            </section>
             <section class="overview mt-2" v-if="accessory.today_operation_paid">
                 <h5 style="color:#1390C6;">Medication</h5>
                 <give_medicine @get_value="get_medication_value"/>
                 <h5 class="mt-1" style="color:#1390C6;">Remark</h5>
                 <textarea class="form-control" v-model="formData.remark"/>
                 <div class="text-right mt-6">
                     <v-btn color="warning" small  @click="submit">Submit treatment</v-btn>
                 </div>
             </section>
             <v-dialog
                 v-model="accessory.dialog"
                 max-width="290"
             >
                 <v-card>
                     <v-card-title class="text-h5 text-center" >
                         Tooth Nr {{accessory.temporary_chosen_tooth.id}}
                     </v-card-title>

                     <v-card-text>
                         <v-radio-group v-if="!accessory.previous_checkup" v-model.number="accessory.temporary_chosen_tooth.diagnostic">
                             <v-radio v-for="(row,i) in accessory.diagnostic_options" :key="i"
                                      :label="row.label"
                                      :color="row.color"
                                      :value="row"
                             >
                             </v-radio>
                         </v-radio-group>
                         <v-radio-group v-if="accessory.checkup_saved || accessory.previous_checkup" v-model.number="accessory.temporary_chosen_tooth.diagnostic">
                             <v-radio v-for="(row,i) in accessory.process_options" :key="i"
                                      :label="row.label"
                                      :color="row.color"
                                      :value="row"
                             >
                             </v-radio>
                         </v-radio-group>
                     </v-card-text>

                     <v-card-actions>
                         <v-spacer></v-spacer>

                         <v-btn
                             color="green darken-1"
                             text
                             @click="accessory.dialog = false"
                         >
                            Cancel
                         </v-btn>

                         <v-btn
                             color="green darken-1"
                             text
                             @click="save_checkup"
                         >
                             save
                         </v-btn>
                     </v-card-actions>
                 </v-card>
             </v-dialog>
         </v-app>
    </div>
</template>

<script>
import Patient_information from "../../../components/patient_information";
import Give_medicine from "../../../components/give_medicine";
export default {
    name: "dental_diagnostic_form",
    components: {Give_medicine, Patient_information},
    data(){
        return{
            first_row:[
                {
                    id:'t18',
                    processed_today:false,
                    diagnostic:{
                        value:'',
                        symbol:''
                    }
                },
                {
                    id:'t17',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t16',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t15',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   },
                    missing:true
                },
                {
                    id:'t14',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t13',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t12',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t11',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t21',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t22',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t23',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t24',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t25',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t26',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t27',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t28',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                }

            ],
            second_row:[
                {
                    id:'t48',
                    processed_today:false,
                    treatment:'E',
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t47',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t46',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t45',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   },
                },
                {
                    id:'t44',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t43',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t42',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t41',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t31',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t32',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t33',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t34',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t35',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t36',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }

                },
                {
                    id:'t37',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }
                },
                {
                    id:'t38',
                    processed_today:false,
                   diagnostic:{
                        value:'',
                       symbol:''
                   }
                }

            ],
            formData:{
                cleaning_necessary:false,
                dental_checkup_id:'',
                medication:[],
                remark:''
            },
            accessory:{
                is_adult:false,
                dialog:false,
                temporary_row:null,
                temporary_chosen_tooth:{
                    id:'',
                    diagnostic:'',
                    diagnosed:false
                },
                diagnostic_options:[

                    {
                        label:'Carry',
                        value:'carry',
                        symbol:'C',
                        color:'warning'

                    },
                    {
                        label:'Crown',
                        value:'crown',
                        symbol:'K',
                        color:'warning'

                    },
                    {
                        label:'Extraction',
                        value:'extraction',
                        symbol:'EX',
                        color:'warning'

                    },
                    {
                        label:'Closed gap',
                        value:'closed_gap',
                        symbol:')(',
                        color:'grey lighten-2'
                    },
                    {
                        label:'Missing',
                        value:'missing',
                        symbol:'X',
                        color:'grey lighten-1'
                    },
                ],
                process_options:[],
                fokontany:[],
                price_list:{
                    extraction:'',
                    care:'',
                    Cleaning:'',
                    followup_care:{id:14,price:0,qty:1}
                },
                previous_checkup:false,
                previous_checkup_date:'',
                checkup_saved:false,
                today_operation_paid:false,
                case_opened:false,
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            if(this.$route.params.admission)this.formData.admission= this.$route.params.admission
            axios.get("/api/v1/extra/fokontany").then(response => response.data.forEach(fkt => this.accessory.fokontany.push(fkt.name.toLowerCase())))
            let adress = this.formData.admission.patient.adress.toLowerCase().split(' ')
            let check = false
            adress.forEach(ad => {
                if (this.accessory.fokontany.indexOf(ad) !== -1) {
                    check = true
                }
            })
            this.formData.admission.patient.sector = check
            let patient_category
            if(this.formData.admission.patient.patient_category_id===null){
                patient_category= this.formData.admission.patient.sector===false?0:1
            }else patient_category=this.formData.admission.patient.patient_category_id
            await axios.get(`/api/v1/patient_system/admission/activity_price/10/${patient_category}`).then(response=>{
                this.accessory.price_list.extraction= response.data.find(data=>data.id===10)
                this.accessory.price_list.care= response.data.find(data=>data.id===13)
                this.accessory.price_list.Cleaning= response.data.find(data=>data.id===12)
            })
            //check the last checkup;
            this.get_previous_checkup()
            //get the todo list for today if existing
            this.get_today_task()



        },
        process(tooth,i,row){
            this.accessory.temporary_chosen_tooth=tooth
            this.accessory.temporary_chosen_tooth.i=i
            this.temporary_row=row
            if(tooth.diagnostic.symbol !=='') tooth.diagnosed=true
            if(tooth.diagnostic.symbol==='EX') this.accessory.process_options=[
                {

                    label:'Extract',
                    value:'extraction',
                    symbol:'Ex',
                    color:'red'
                },
            ]
            if(tooth.diagnostic.symbol==='C' ) this.accessory.process_options=[
                {

                    label:'Process care',
                    value:'care',
                    symbol:'C',
                    color:'success'
                },
            ]
            if(tooth.diagnostic.symbol==='FC') this.accessory.process_options=[
                {

                    label:'Continue care',
                    value:'care',
                    symbol:'FC',
                    color:'success'
                },
            ]
            this.accessory.dialog=true
        },
        save_checkup(){
            if(this.temporary_row===1){
                let tooth= this.first_row[this.accessory.temporary_chosen_tooth.i]
                tooth=this.accessory.temporary_chosen_tooth
                if(tooth.diagnosed) tooth.processed_today=true

            }else{
                this.second_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                if(this.second_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.second_row[this.accessory.temporary_chosen_tooth.i].processed_today=true

            }
            this.accessory.dialog=false
            this.accessory.temporary_chosen_tooth={
                id:'',
                cleaning:false,
                carry:false,
                crown:false,
                closed_gap:false,
                gingitivis:false,
                extraction:false,
                missing:false
            }
            this.accessory.process_options=[]
        },
        td_color(value){
            switch (value){
                case 'crown':
                    return'text-success'
                break;
                case 'control_again':
                    return 'text-warning'
                break;
                case 'extraction':
                    return 'text-danger'
                    break;
                case 'missing':
                    return 'bg-secondary'
            }
        },
        async get_previous_checkup(){
            let arry= this.first_row.concat(this.second_row)
            await axios.get(`/api/v1/patient_system/out_patient/dentist/patient_last_checkup/${this.formData.admission.patient_id}`).then(response=>{
                if(response.data){
                    this.accessory.previous_checkup=true
                    this.formData.dental_checkup_id=response.data.id
                    for (const [key, value] of Object.entries(response.data)) {
                        let array= this.first_row.concat(this.second_row)
                        let found= array.find(tooth=>tooth.id===key)
                        if(found !== null && found !==undefined){
                            found.diagnostic.symbol=value
                            switch( found.diagnostic.symbol){
                                case "EX":
                                    found.diagnostic.value='extraction'
                                    found.color="red"
                                break;
                                case "C":
                                    found.diagnostic.value='care'
                                    found.color="success"
                                    break;
                            }
                        }
                    }
                }
            })
        },
        check_if_followup(){
            axios.get(`/api/v1/patient_system/out_patient/dentist/check_if_followup/${this.formData.admission.patient_id}`).then(response=>{
                console.log(response.data)
            })
        },
        get_today_task(){
            let arry= this.first_row.concat(this.second_row)
            axios.get(`/api/v1/patient_system/out_patient/dentist/today_task/${this.formData.admission.patient_id}`).then(response=>{
                if(response.data.length>0){
                    this.accessory.today_operation_paid=true
                    // console.log(response.data[0].extraction)
                    if(response.data[0].cleaning_necessary===1) this.formData.cleaning_necessary=true
                   split_today_task(response.data[0],'extraction',arry)
                   split_today_task(response.data[0],'care',arry)
                }
            })
        },
        submit_checkup(){
            this.formData.diagnostic= this.diagnostic
            this.formData.prices= this.prices
            axios.post('/api/v1/patient_system/out_patient/dentist/dental_checkup',this.formData).then(response=>{
                if (response.data.success){
                    this.accessory.checkup_saved=true
                }
            })
        },
        async submit(){
            this.formData.diagnostic=this.today_process
            //update the dental checkup table
             await axios.put(`/api/v1/patient_system/out_patient/dentist/dental_checkup/${this.formData.dental_checkup_id}`,this.formData)
            // save the medication and remark
        },
        send_to_cashier(){
            this.formData.admission.service_activity_id=10
            this.formData.details= this.today_process
            this.formData.prices= this.prices
            this.formData.price_list= this.accessory.price_list
            axios.post('/api/v1/patient_system/out_patient/dentist/send_to_cashier',this.formData)
        },
        get_medication_value(data){
                this.formData.medication=data
        }

    },
    computed:{
        diagnostic(){
            return{
                extraction:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='extraction'),...this.second_row.filter(tooth=>tooth.diagnostic.value==='extraction')],
                carry:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='carry'),...this.second_row.filter(tooth=>tooth.diagnostic.value==='carry')],
                crown:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='K'),...this.second_row.filter(tooth=>tooth.diagnostic.value==='K')],
                missing:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='missing'),...this.second_row.filter(tooth=>tooth.diagnostic.value==='missing')],
                closed_gap:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),...this.second_row.filter(tooth=>tooth.diagnostic.value==='closed_gap')],
        }

        },
        today_process(){
            return{
                extraction:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='extraction'&& tooth.processed_today===true),...this.second_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true)],
                care:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true  ),...this.second_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true )],
                followup_care:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true  ),...this.second_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true )],
                Cleaning:this.formData.cleaning_necessary? [{diagnostic:{id:'all',value:'cleaning'}}]:[]

            }

        },
        prices(){
            return {
                extraction:this.today_process.extraction.length * this.accessory.price_list.extraction.price,
                Cleaning:this.formData.cleaning_necessary?this.accessory.price_list.Cleaning.price:0,
                care:this.today_process.care.length * this.accessory.price_list.care.price,
                followup_care:0,
            }
        },
        patient_age(){
            return calculateAge(this.formData.admission.patient.birthDate)
        }

    }


}
function split_diagnostic(data_src,column_name,symbol,arry){
    if(data_src[column_name].length>0){
        let name=data_src[column_name].split("-")
        name.forEach(tooth=>{
            let value= arry.find(t=>t.id===parseInt(tooth))
            value.diagnostic.value=column_name
            value.diagnostic.symbol=symbol
        })
    }
}
function split_today_task(data_src,column_name,arry){
    if(data_src[column_name].length>0){
        let name=data_src[column_name].split("-")
        name.forEach(tooth=>{
            let value= arry.find(t=>t.id===tooth)
            value.processed_today=true
        })
    }
}
function calculateAge(dob) {
    if (dob !== "") {
        var difference =
            Date.now() - new Date(dob).getTime();
        var age = new Date(difference);
        return Math.abs(age.getUTCFullYear() - 1970);
    } else {
        return "";
    }
}
</script>

<style scoped>
.table-title{
    background-color: #1390C6;
    color:white;
}
.overview{
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
    padding:5px;
}
</style>
