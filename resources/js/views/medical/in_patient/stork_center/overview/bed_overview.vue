<template>
    <div class="container" id="container">
        <v-app>
           <div class=" d-flex justify-content-center align-items-center">
               <v-card width="100vw" height="100vh">
                   <v-system-bar  :color="stork_admission.bed.room.toLowerCase()" >
                       <div class="text-center w-100 font-weight-bold title">
                           {{stork_admission.bed.description}}
                       </div>
                   </v-system-bar>
                   <v-card-text>
                       <div class="table-responsive">
                           <table class="table table-sm table-bordered">
                               <tr>
                                   <td rowspan="2"></td>
                                   <td>ID</td>
                                   <td>Lastname</td>
                                   <td>Age</td>
                                   <td>G</td>
                                   <td>P</td>
                                   <td>A</td>
                                   <td>M</td>
                                   <td>LC</td>
                                   <td>DLD</td>
                                   <td>GA</td>
                               </tr>
                               <tr>
                                   <td>{{stork_admission.patient.id}}</td>
                                   <td>{{fullName}}</td>
                                   <td>{{patient_age}}</td>
                                   <td>{{cpn_data.gravida}}</td>
                                   <td>{{cpn_data.parity}}</td>
                                   <td>{{cpn_data.abortion}}</td>
                                   <td>{{cpn_data.miscarriage}}</td>
                                   <td>{{cpn_data.ev}}</td>
                                   <td>{{cpn_data.dda}}</td>
                               </tr>
                           </table>
                       </div>
                       <table class="table table-sm table-bordered">
                           <tr>
                               <td class="first-col" style="width:10%" >Level of Care</td>
                               <td  style="width:90%" >{{stork_admission.level_of_care}}</td>
                           </tr>
                           <tr>
                               <td class="first-col">Mobilisation status</td>
                               <td  >
                                   {{stork_admission.mobilisation_status}}
                               </td>
                           </tr>
                           <tr>
                               <td>Diagnose on entry</td>
                               <td>
                                   {{stork_admission.admission_diagnosis}}
                               </td>
                           </tr>
                           <tr>
                               <td class="first-col">Days</td>
                               <td style="width:45%">{{d(stork_admission.created_at)}}</td>
                           </tr>

                           <tr>
                               <td class="first-col">Diagnoses</td>
                               <td>
                                   {{last_diagnose.diagnose}}-({{last_diagnose.type}})
                               </td>
                           </tr>
                           <tr>
                               <td class="first-col">Vital signs</td>
                               <td>
                                   {{`BPL: ${last_vital_sign.bp_l} | BPR: ${last_vital_sign.bp_l} | Pulse: ${last_vital_sign.pulse} |Temp: ${last_vital_sign.temp} | SPO2: ${last_vital_sign.spo2}  `}}
                               </td>
                           </tr>
                           <tr>
                               <td  class="first-col">Medicines</td>
                               <td>
                                   <div class="row" v-for="row in plan_data.medicines" >
                                       <div class="col">
                                           {{row.to_do}}
                                       </div>
                                       <div class="col ">
                                           {{row.to_do_frequency}}
                                       </div>
                                   </div>
                               </td>
                           </tr>
                           <tr>
                               <td  class="first-col">Actions</td>
                               <td>
                                   <table class="table table-sm table-borderless">
                                       <tr v-for="row in plan_data.actions">
                                           <td style="width:30%">
                                               {{row.to_do}}
                                           </td>
                                           <td>
                                               {{row.to_do_frequency}}
                                           </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                          <tr>
                              <td class="first-col">Anamnese</td>
                              <td>
                                  <ul  v-for="row in anamneses">
                                      <li>
                                          {{row.anamnese}}
                                      </li>
                                  </ul>
                              </td>
                          </tr>
                           <tr>
                               <td class="first-col">Comments</td>
                               <td>
                                   {{plan_data.comment}}
                               </td>
                           </tr>
                       </table>

                       <div class="w-100 text-center">
                           <v-btn color="primary" small @click="switch_screen_mode">
                               <span v-if="!full_screen">Full screen</span>
                               <span v-if="full_screen">Exit Full screen</span>
                           </v-btn>
                       </div>
                   </v-card-text>
               </v-card>
           </div>
        </v-app>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "bed_overview",
    props:['stork_admission'],
    data(){
        return{
            full_screen:false,
            cpn_data:{
                gravida:'',
                parity:'',
                abortion:'',
                miscarriage:'',
                ev:'',
                dda:''
            },
            last_diagnose:{},
            anamneses:[],
            plan_data:{
                actions:[],
                medicines:[],
                comment:''
            },
            last_vital_sign:{}
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        async init(){
            //get plan data
            axios.get(`/api/v1/patient_system/in_patient/stork/plan/${this.stork_admission.id}`).then(
                response=>{
                    if(response.data.length>0){
                        this.plan_data.medicines=response.data[response.data.length -1].stork_plan_details.filter(item=>item.type===1)
                        this.plan_data.actions=response.data[response.data.length -1].stork_plan_details.filter(item=>item.type===2)
                        this.plan_data.comment=response.data[response.data.length -1].comment
                    }
                }
            )
            await axios.get(`/api/v1/patient_system/in_patient/stork/patient_cpn_data/${this.stork_admission.patient.id}`).then(
                response=>{
                   if(response.data.length>0) this.cpn_data=response.data.cpn_admissions[response.data.cpn_admissions.length -1]
                }
            )
            //get the latest diagnose
            await axios.get(`/api/v1/patient_system/in_patient/stork/last_diagnose/${this.stork_admission.id}`).then(resp=>this.last_diagnose=resp.data)
            //get latest vitalSigns
            await axios.get(`/api/v1/patient_system/vital_sign/${this.stork_admission.admission_id}`).then(
                response=>{
                    if(response.data.length>0) this.last_vital_sign=response.data[response.data.length -1]
                }
            )
            //get anamneses
            axios.get(`/api/v1/patient_system/anamnese/${this.stork_admission.patient_id}`).then(response=>{
                this.anamneses=response.data
            })


        },
        d(input){
            return moment().diff(moment(input), "days")+1
        },
        switch_screen_mode(){
            var element = document.querySelector("#container");
            if(!this.full_screen){
                element.requestFullscreen()
            }else{
                document.exitFullscreen()
            }
            this.full_screen= !this.full_screen
        },
        null_to_str(str){
            return str?str:""
        }
    },
    watch:{
        stork_admission:{
            handler:function(data){
                console.log(data)
                this.init()
            },
            deep:true
        }
    },
    computed:{
        fullName(){
            return this.null_to_str(this.stork_admission.patient.firstName) +" "+ this.null_to_str(this.stork_admission.patient.lastName)
        },
        patient_age(){
            var difference =
                Date.now() - new Date(this.stork_admission.patient.birthDate).getTime();
            var age = new Date(difference);
            return Math.abs(age.getUTCFullYear() - 1970);
        },
    }
}
</script>

<style scoped>
.first-col{
    vertical-align: middle;
}
*{
    font-size:1.2vw;
}
</style>
