<template>
    <div class="container w-75">
         <v-app>
             <patient_information :patient_id="formData.admission.patient_id" />
            <h6 class="table-title ml-2 font-weight-bold"><v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B) Today's actions</h6>
             <p class="ml-4 font-weight-bold">B.1) Diagnostics</p>
             <table class="table table-stripped table-sm" v-if="accessory.is_adult">
                 <caption v-if="accessory.previous_checkup">
                     Checkup date: {{accessory.previous_checkup_date}}
                 </caption>
<!--                 <tr>-->
<!--                     <th class="table-title" colspan="16"> <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp B) Today's actions</th>-->
<!--                 </tr>-->
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
                     <td v-for="tooth in second_row" class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.symbol)">
                         {{tooth.diagnostic.symbol}}</td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row"  class="text-center">{{tooth.id.substring(1)}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in second_row" class="text-center">
                         <v-btn x-small :disabled="tooth.diagnostic.symbol==='X'"
                                @click="process(tooth,i,2)" :class="td_color(tooth.diagnostic.symbol)"
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
                     <td v-for="tooth in extra_first_row"  class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.symbol)">
                         {{tooth.diagnostic.symbol}}

                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in extra_first_row" class="text-center">
                         {{tooth.id.substring(1)}}
                     </td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in extra_first_row" class="text-center">
                         <v-btn  x-small :disabled="tooth.diagnostic.symbol==='X'"
                                 @click="process(tooth,i,'E1')" :class="td_color(tooth.diagnostic.symbol)"
                                 v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>
                     </td>
                 </tr>
<!--                 extra second row-->
                 <tr>
                     <td></td>
                     <td v-for="tooth in extra_second_row"  class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.symbol)">
                         {{tooth.diagnostic.symbol}}

                     </td>
                     <td></td>
                 </tr>
                 <tr>
                     <td></td>
                     <td v-for="tooth in extra_second_row" class="text-center">
                         {{tooth.id.substring(1)}}
                     </td>
                     <td></td>
                 </tr>
                 <tr>
                     <td></td>
                     <td  v-for="(tooth,i) in extra_second_row" class="text-center">
                         <v-btn  x-small :disabled="tooth.diagnostic.symbol==='X'"
                                 @click="process(tooth,i,'E2')" :class="td_color(tooth.diagnostic.symbol)"
                                 v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>
                     </td>
                     <td></td>
                 </tr>
                 <!--                 extra_third_row-->
                 <tr>
                     <td></td>
                     <td v-for="tooth in extra_third_row" class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.symbol)">
                         {{tooth.diagnostic.symbol}}</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td></td>
                     <td v-for="tooth in extra_third_row"  class="text-center">{{tooth.id.substring(1)}}</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td></td>
                     <td  v-for="(tooth,i) in extra_third_row" class="text-center">
                         <v-btn x-small :disabled="tooth.diagnostic.symbol==='X'"
                                @click="process(tooth,i,'E3')" :class="td_color(tooth.diagnostic.symbol)"
                                v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>

                     </td>
                     <td></td>
                 </tr>
<!--                 extra_fourth_row-->
                 <tr>
                     <td v-for="tooth in extra_fourth_row" class="border font-weight-bold text-center" :class="td_color(tooth.diagnostic.symbol)">
                         {{tooth.diagnostic.symbol}}</td>
                 </tr>
                 <tr>
                     <td v-for="tooth in extra_fourth_row"  class="text-center">{{tooth.id.substring(1)}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in extra_fourth_row" class="text-center">
                         <v-btn  x-small :disabled="tooth.diagnostic.symbol==='X'"
                                 @click="process(tooth,i,'E4')" :class="td_color(tooth.diagnostic.symbol)"
                                 v-if="!accessory.today_operation_paid"
                         >
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                         <v-icon color="success" v-if="tooth.processed_today && accessory.today_operation_paid">mdi-adjust</v-icon>
                     </td>
                 </tr>


<!--                 end_of_extra_rows-->
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
                 <p class="ml-4 font-weight-bold">B.2) Treatment</p>
                 <give_medicine @get_value="get_medication_value"/>
                 <p class="ml-4 font-weight-bold">B.2) Remark</p>
                 <textarea class="form-control" v-model="formData.remark"/>
                 <h6 class="table-title ml-2 mt-2 font-weight-bold"> <v-icon class="text-white">mdi-flask</v-icon>&nbsp C) Labwork</h6>
                 <div class="ml-2">
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model.number="accessory.show_internal_lab"/>
                         <label class="form-check-label">Internal</label>
                     </div>
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model="accessory.show_external_lab"/>
                         <label class="form-check-label">External</label>
                     </div>
                 </div>
                 <h6 class="table-title ml-2 mt-2 font-weight-bold"> <v-icon class="text-white">mdi-stethoscope</v-icon>&nbsp D) Consultation</h6>
                 <div class="ml-2">
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model.number="accessory.show_internal_consultation"/>
                         <label class="form-check-label">Internal</label>
                     </div>
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model="accessory.show_external_consultation"/>
                         <label class="form-check-label">External</label>
                     </div>
                 </div>
                 <h6 class="table-title ml-2 mt-2 font-weight-bold"> <v-icon class="text-white">mdi-truck</v-icon>&nbsp E) Referral</h6>
                 <div class="ml-2">
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model.number="accessory.show_internal_referral"/>
                         <label class="form-check-label">Internal</label>
                     </div>
                     <div class="form-check form-check-inline">
                         <input type="checkbox" class="form-check-input" v-model="accessory.show_external_referral"/>
                         <label class="form-check-label">External</label>
                     </div>
                 </div>

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
<!--             internal lab-->
             <v-dialog
                 v-model="accessory.show_internal_lab"
             >
                 <v-card>
                     <v-card-text class="p-2">
                         <internal_lab :form_type="'request'" :admission="formData.admission"/>
                     </v-card-text>
                 </v-card>
             </v-dialog>
<!--             external lab-->
             <v-dialog v-model="accessory.show_external_lab">
                 <v-card>
                     <v-card-text class="p-2">
                         <external_lab  :admission="formData.admission"></external_lab>
                     </v-card-text>
                 </v-card>
             </v-dialog>
<!--             internal consultation-->
             <v-dialog
                 v-model="accessory.show_internal_consultation"
             >
                 <v-card>
                     <v-card-text class="p-2">
                         <internal_consultation  :admission="formData.admission"/>
                     </v-card-text>
                 </v-card>
             </v-dialog>
<!--             external consultation-->
             <v-dialog v-model="accessory.show_external_consultation">
                 <v-card>
                     <v-card-text class="p-2">
                         <external_consultation :admission="formData.admission"/>
                     </v-card-text>
                 </v-card>
             </v-dialog>
<!--             internal referral-->
             <v-dialog
                 v-model="accessory.show_internal_referral"
             >
                 <v-card>
                     <v-card-text class="p-2">
                         <internal_referral :admission="formData.admission"/>
                     </v-card-text>
                 </v-card>
             </v-dialog>
<!--             external referral-->
             <v-dialog v-model="accessory.show_external_referral">
                 <v-card>
                     <v-card-text class="p-2">
                         <external_referral :admission="formData.admission"/>
                     </v-card-text>
                 </v-card>
             </v-dialog>
         </v-app>
    </div>
</template>

<script>
import Patient_information from "../../../components/patient_information";
import Give_medicine from "../../../components/give_medicine";
import Internal_lab from "../labwork/internal/internal_lab";
import External_lab from "../labwork/external/external_lab";
import Internal_consultation from "../../../components/internal_consultation";
import External_consultation from "../../../components/external_consultation";
import Internal_referral from "../../../components/internal_referral";
import External_referral from "../../../components/external_referral";
export default {
    name: "dental_diagnostic_form",
    components: {
        External_referral,
        Internal_referral,
        External_consultation,
        Internal_consultation, External_lab, Internal_lab, Give_medicine, Patient_information},
    data(){
        return{
            first_row:[],
            second_row:[],
            extra_first_row:[],
            extra_second_row:[],
            extra_third_row:[],
            extra_fourth_row:[],
            formData:{
                cleaning_necessary:false,
                dental_checkup_id:'',
                medication:[],
                remark:''
            },
            accessory:{
                is_adult:true,
                dialog:false,
                temporary_row:null,
                temporary_chosen_tooth:{
                    id:'',
                    diagnostic:'',
                    diagnosed:false
                },
                diagnostic_options:[
                    {
                        label:'Healthy',
                        value:'healthy',
                        symbol:'H',
                        color:'success'
                    },
                    {
                        label:'Missing',
                        value:'missing',
                        symbol:'X',
                        color:'grey lighten-1'
                    },
                    {
                        label:'Should be extracted',
                        value:'extraction',
                        symbol:'EX',
                        color:'warning'

                    },

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
                        label:'Closed gap',
                        value:'closed_gap',
                        symbol:')(',
                        color:'grey lighten-2'
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
                show_internal_lab:false,
                show_external_lab:false,
                show_internal_consultation:false,
                show_external_consultation:false,
                show_internal_referral:false,
                show_external_referral:false
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
                //check if the patient is adult or baby
                this.accessory.price_list.extraction= response.data.find(data=>data.id===10)
                this.accessory.price_list.care= response.data.find(data=>data.id===13)
                this.accessory.price_list.Cleaning= response.data.find(data=>data.id===12)
                if(this.patient_age<=15){
                    this.accessory.is_adult=false
                    //the price of milk tooth extraction is different from the adult
                    this.accessory.price_list.extraction= response.data.find(data=>data.id===11)
                }
            })
            this.set_tooth_plan()
            //check the last checkup;
            await this.get_previous_checkup()
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
            switch (this.temporary_row){
                case 1:
                    let tooth= this.first_row[this.accessory.temporary_chosen_tooth.i]
                    tooth=this.accessory.temporary_chosen_tooth
                    if(tooth.diagnosed) tooth.processed_today=true
                break;
                case 2:
                    this.second_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                    if(this.second_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.second_row[this.accessory.temporary_chosen_tooth.i].processed_today=true
                break;
                case 'E1':
                    this.extra_first_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                    if(this.extra_first_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.extra_first_row[this.accessory.temporary_chosen_tooth.i].processed_today=true
                break;
                case 'E2':
                    this.extra_second_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                    if(this.extra_second_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.extra_second_row[this.accessory.temporary_chosen_tooth.i].processed_today=true
                break;
                case 'E3':
                    this.extra_third_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                    if(this.extra_third_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.extra_third_row[this.accessory.temporary_chosen_tooth.i].processed_today=true
                break;
                case 'E4':
                    this.extra_fourth_row[this.accessory.temporary_chosen_tooth.i]=this.accessory.temporary_chosen_tooth
                    if(this.extra_fourth_row[this.accessory.temporary_chosen_tooth.i].diagnosed) this.extra_fourth_row[this.accessory.temporary_chosen_tooth.i].processed_today=true
                break;
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
                case 'EX':
                    return' text-white bg-danger'
                break;
                case 'C':
                    return 'bg-warning'
                break;
                case 'K':
                    return 'bg-info'
                    break;
                case ')(':
                    return 'bg-success'
                case 'H':
                    return 'bg-success'
            }
        },
        async get_previous_checkup(){
            let array= this.first_row.concat(this.second_row).concat(this.extra_first_row).concat(this.extra_second_row).concat(this.extra_third_row).concat(this.extra_fourth_row)
            await axios.get(`/api/v1/patient_system/out_patient/dentist/patient_last_checkup/${this.formData.admission.patient_id}`).then(response=>{
                if(response.data){
                    this.accessory.previous_checkup=true
                    this.formData.dental_checkup_id=response.data.id
                    for (const [key, value] of Object.entries(response.data)) {
                        // let array= this.first_row.concat(this.second_row)
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
        get_today_task(){
            let arry= this.first_row.concat(this.second_row).concat(this.extra_first_row).concat(this.extra_second_row).concat(this.extra_third_row).concat(this.extra_fourth_row)
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
             await axios.put(`/api/v1/patient_system/out_patient/dentist/dental_checkup/${this.formData.dental_checkup_id}`,this.formData).then(
                 response=>{
                     if(response.data.success){
                         this.$toast.open({position: 'top-right', type: 'success', message: 'Data successfully saved'})
                         this.$router.push({name:'dentist_patient_list'})
                     }
                 }
             )
            // save the medication and remark
        },
        send_to_cashier(){
            this.formData.admission.service_activity_id=10
            this.formData.details= this.today_process
            this.formData.prices= this.prices
            this.formData.price_list= this.accessory.price_list
            axios.post('/api/v1/patient_system/out_patient/dentist/send_to_cashier',this.formData).then(response=>{
                if(response.data.success){
                    this.$toast.open({position: 'top-right', type: 'success', message: 'Data sent'})
                    this.$router.push({name:'dentist_patient_list'})
                }
            })
        },
        get_medication_value(data){
                this.formData.medication=data
        },
        set_tooth_plan(){
            let first= this.first_row
            if(this.accessory.is_adult){
                //set the first row
                for (let i=18;  i>10; i--){
                    push_row(this.first_row,i)
                }
                for (let i=21;  i<29; i++){
                    push_row(this.first_row,i)
                }
                //set the second row
                for (let i=48;  i>40; i--){
                    push_row(this.second_row,i)
                }
                for (let i=31;  i<39; i++){
                    push_row(this.second_row,i)
                }
            }else{
                //set extra first_row
                for (let i=16; i>10;i--){
                    push_row(this.extra_first_row,i)
                }
                for (let i=21; i<27;i++){
                    push_row(this.extra_first_row,i)
                }
                // set extra second row
                for (let i=55; i>50;i--){
                    push_row(this.extra_second_row,i)
                }
                for (let i=61; i<66;i++){
                    push_row(this.extra_second_row,i)
                }
                //set extra third row
                for (let i=85; i>80;i--){
                    push_row(this.extra_third_row,i)
                }
                for (let i=71; i<76;i++){
                    push_row(this.extra_third_row,i)
                }
                //set extra fourth row
                for (let i=46; i>40;i--){
                    push_row(this.extra_fourth_row,i)
                }
                for (let i=31; i<37;i++){
                    push_row(this.extra_fourth_row,i)
                }
            }


        },


    },
    computed:{
        diagnostic(){
            return{
                extraction:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.value==='extraction'),
                ],
                carry:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.value==='carry'),
                ],
                crown:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.symbol==='K'),
                ],
                missing:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.value==='missing'),
                ],
                closed_gap:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.value==='closed_gap'),
                ],
        }

        },
        today_process(){
            return{
                extraction:[...this.first_row.filter(tooth=>tooth.diagnostic.value==='extraction'&& tooth.processed_today===true),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.value==='extraction' && tooth.processed_today===true)
                ],
                care:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true  ),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true ),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.symbol==='C' && tooth.processed_today===true)
                ],
                followup_care:[...this.first_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true  ),
                    ...this.second_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true ),
                    ...this.extra_first_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true),
                    ...this.extra_second_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true),
                    ...this.extra_third_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true),
                    ...this.extra_fourth_row.filter(tooth=>tooth.diagnostic.symbol==='FC' && tooth.processed_today===true)
                ],
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
function push_row(row_name,i){
    return row_name.push({
        id:`t${i}`,
        processed_today:false,
        diagnostic:{
            value:'',
            symbol:''
        }
    },)
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
