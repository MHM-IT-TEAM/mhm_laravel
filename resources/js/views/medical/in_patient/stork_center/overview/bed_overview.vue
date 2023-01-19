<template>
    <div class="container" id="container">
        <v-app>
           <div class=" d-flex justify-content-center align-items-center">
               <v-card width="100vw" min-height="100vh">
                   <v-system-bar  :color="stork_admission.bed.room.toLowerCase()" >
                       <div class="text-center w-100 font-weight-bold title">
                           {{stork_admission.bed.description}}
                       </div>
                   </v-system-bar>
                   <v-card-text>
                       <div class="table-responsive">
                           <table class="table table-sm table-bordered" v-if="patient_age>1">
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
                                   <td>{{cpn_data.current_ga}}</td>
                               </tr>
                           </table>
                           <table class="table table-sm table-bordered" v-if="patient_age<=1">
                               <tr>
                                   <td rowspan="2"></td>
                                   <td>ID</td>
                                   <td>Name</td>
                                   <td>BW</td>
                                   <td>GA Birth</td>
                                   <td>GA Today</td>
                                   <td>APGAR</td>
                                   <td>Gender</td>
                                   <td>Age</td>
                               </tr>
                               <tr>
                                   <td>{{stork_admission.patient.id}}</td>
                                   <td>{{fullName}}</td>
                                   <td>{{birth_weight}}</td>
                                   <td>{{ga_birth}}</td>
                                   <td>{{baby_ga_now}}</td>
                                   <td>{{baby_apgar}}</td>
                                   <td>{{baby_gender}}</td>
                                   <td>{{patient_age_in_days}}</td>
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
                                        {{`BPL: ${last_vital_sign.bp_l} | BPR: ${last_vital_sign.bp_r} | Pulse: ${last_vital_sign.pulse} |Temp: ${last_vital_sign.temp} | SPO2: ${last_vital_sign.spo2}  `}}
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="first-col">Medicines</td>
                                    <td>
                                        <table class="table table-sm table-borderless">
                                            <tr v-for="row in plan_data.medicines">
                                                <div v-if="row.show_in_projection==1">
                                                    <td style="width:15%">
                                                        {{row.created_at +":"}} 
                                                    </td>
                                                    <td style="width:30%">
                                                        {{row.to_do}}
                                                    </td>
                                                    <td>
                                                        {{row.to_do_frequency}}
                                                    </td>
                                                    <td>
                                                        {{"Day: " + row.day + " ( done: "+ row.days_diff + ")"}}
                                                    </td>
                                                </div>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="first-col">Actions</td>
                                    <td>
                                        <table class="table table-sm table-borderless">
                                            <tr v-for="row in plan_data.actions">
                                                <div v-if="row.show_in_projection==1">
                                                    <td style="width:15%">
                                                        {{row.created_at +":"}} 
                                                    </td>
                                                    <td style="width:30%">
                                                        {{row.to_do}}
                                                    </td>
                                                    <td>
                                                        {{row.to_do_frequency}}
                                                    </td>
                                                </div>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="first-col">Labworks</td>
                                    <td>
                                        <table class="table table-sm table-borderless">
                                            <tr v-for="row in plan_data.laboratory">
                                                <div v-if="row.show_in_projection==1">
                                                    <td style="width:15%">
                                                        {{row.created_at +":"}} 
                                                    </td>
                                                    <td>
                                                        {{ row.description}}
                                                    </td>

                                                </div>
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
                                <tr v-if="patient_age<=1 && vital_signs.length>0">
                                    <td>Weight (Date)</td>
                                    <td>
                                        <div class="row ml-1 mt-1 text-center" >
                                            <div class="col" v-for="weight in weights">
                                                <div class="row">{{weight.value}}g</div>
                                                <div class="row">({{weight.created_at}})</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="patient_age<=1 && vital_signs.length>0">
                                    <td>Gain/Loss</td>
                                    <td>
                                        <div class="row">
                                            <div class="col"  v-for="diff in weight_differences">
                                                {{diff.weight}}g <v-icon>{{diff.icon}}</v-icon>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first-col">Comments</td>
                                    <td>
                                        <table class="table table-sm table-borderless">
                                            <tr v-for="row in comments">
                                                <div v-if="row.show_in_projection==1">
                                                    <!-- <td style="width:10%">
                                                        {{row.created_at +":"}} 
                                                    </td> -->
                                                    <td>
                                                        {{ row.comment}}
                                                    </td>
                                                </div>
                                            </tr>
                                        </table>
                                    </td>
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
            action_groups:[],
            cpn_data:{
                gravida:'',
                parity:'',
                abortion:'',
                miscarriage:'',
                ev:'',
                dda:'',
                current_ga:''
            },
            last_diagnose:{},
            anamneses:[],
            comments:[],
            plan_data:{
                actions:[],
                medicines:[],
                laboratory:[]
            },
            last_vital_sign:{},
            vital_signs:[],
            weights:[],
            birth_weight:'',
            ga_birth:'',
            baby_apgar:'',
            baby_gender:'',
            baby_ga_now:''
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
                        
                        let medicines=[];
                        let actions=[];
                        const laboratory=[];

                        response.data.forEach(data=>{
                            if( data.stork_plan_details != null){
                                
                                // Get actions
                                const list=data.stork_plan_details.filter(item=>item.type===2);
                                list.forEach(item=>item.created_at=this.date_format(item.created_at));
                                actions=actions.concat(list);

                                // Get medicines
                                const list2 = data.stork_plan_details.filter(item=>item.type===1);
                                list2.forEach(item=> {
                                    item.days_diff=this.calculateDaysDiff(item.created_at, item.day);
                                    item.created_at =this.date_format(item.created_at);
                                });
                                medicines=medicines.concat(list2);
                                
                            }
                            // Get laboratory work
                            if(data.laboratory!=null){
                                const item ={description:data.laboratory, created_at:this.date_format(data.created_at), show_in_projection:data.show_in_projection };
                                laboratory.push(item);
                            }
                        })
                        this.plan_data.medicines=medicines;
                        this.plan_data.laboratory=laboratory;
                        this.plan_data.actions=actions;
                        
                    }
                }
            )
      
            await axios.get(`/api/v1/patient_system/in_patient/stork/patient_cpn_data/${this.stork_admission.patient.id}`).then(
                response=>{
                   if(response.data.cpn_admissions.length>0){
                       this.cpn_data=response.data.cpn_admissions[response.data.cpn_admissions.length -1]
                       this.cpn_data.current_ga= this.current_gestational_age(this.cpn_data.created_at,this.cpn_data.gestational_age)
                   }
                }
            )
            //get the latest diagnose
            await axios.get(`/api/v1/patient_system/in_patient/stork/last_diagnose/${this.stork_admission.id}`).then(resp=>this.last_diagnose=resp.data)
            //get latest vitalSigns
            await axios.get(`/api/v1/patient_system/vital_sign/${this.stork_admission.admission_id}`).then(response=>{
                    if(response.data.length>0) this.last_vital_sign=response.data[response.data.length -1]
                    this.vital_signs=response.data
                }
            )
            await axios.get('/api/v1/extra/stork_action_group').then(response=>this.action_groups=response.data)

            const take_weight_id=this.action_groups.find(element=>element.description=='Take weight' && element.type=='medical_care').id
        
            // get medical care take weight with max 6 entries due to space in projection
            await axios.get(`/api/v1/patient_system/in_patient/stork/stork_action/${this.stork_admission.id}/41`).then(
                response=>{this.weights=response.data.slice(-7,-1)})
           

            //get anamneses
            axios.get(`/api/v1/patient_system/anamnese/${this.stork_admission.patient_id}`).then(response=>{
                this.anamneses=response.data
            })

            //get comments
            axios.get(`/api/v1/patient_system/in_patient/stork/comment/${this.stork_admission.id}`).then(response=>{
                this.comments=response.data
                this.comments.forEach(data=>{
                    data.created_at= this.date_format(data.created_at)
                })
            })
            //if patient is baby
            if(this.patient_age<1){
                axios.get(`/api/v1/patient_system/patient/birth_data/${this.stork_admission.patient_id}`).then(response=>{
                    let med_data=response.data.birth_medical_data
                    this.birth_weight=med_data.weight
                    this.ga_birth=med_data.birth.GA
                    this.baby_gender=med_data.gender
                    this.baby_apgar=`${med_data.apgar_1}/${med_data.apgar_2}/${med_data.apgar_3}`
                    this.baby_ga_now=this.current_gestational_age(med_data.birth.created_at,med_data.birth.GA)
                })
            }


        },
        d(input){
            return moment().diff(moment(input), "days")+1
        },
        switch_screen_mode(){
            //var elem = document.querySelector("#container");
             var elem =document.documentElement;
            if(!this.full_screen){
                if (elem.requestFullscreen) {elem.requestFullscreen()}
            }else{
                document.exitFullscreen()
            }
            this.full_screen= !this.full_screen
        },
        null_to_str(str){
            return str?str:""
        },
        date_format(date){
            return moment(date).format("MMM Do YY");
        },
        current_gestational_age(src_date,src_ga){
            // src_date= this.ultrasound_data.created_at
            const diff = new Date()- new Date(src_date);
            const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);
            const ga_weeks = Math.floor(diff_in_days / 7);
            const ga_days = diff_in_days % 7;
            // splitting src date
            let [left_ga,right_ga]= [parseInt(src_ga.split('+')[0]),parseInt(src_ga.split('+')[1])]
            // summing the right part
            let ga_in_days= ga_days+ right_ga
            let ga_in_week= ga_weeks+ left_ga
            if (ga_in_days>6){
                ga_in_week++;
                ga_in_days=ga_in_days-7;
            } 
            return ga_in_week + "+"+ ga_in_days
        },
        calculateDaysDiff( created_at, days){
            const diff1 = new Date() - new Date(created_at);
            let diff_in_days = Math.round(diff1 / 1000 / 60 / 60 / 24);
            const days_done=diff_in_days < days ? diff_in_days : days;
            return days_done;
        }
       
    },
    watch:{
        stork_admission:{
            handler:function(data){
                //console.log(data)
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
            var difference = Date.now() - new Date(this.stork_admission.patient.birthDate).getTime();
            var age = new Date(difference);
            return Math.abs(age.getUTCFullYear() - 1970);

        },
        patient_age_in_days(){
            var a = moment();
            var b = moment(new Date(this.stork_admission.patient.birthDate));
           return a.diff(b, 'days') // 1
        },
        weight_differences(){
            let result=[]
            // If weights are not fetched from database yet
            if(this.weights.length===0){
                return result
            }
            let start_weight= 0|| this.birth_weight
            let first_weight=this.weights[0].value -start_weight
            let first_icon=first_weight<this.birth_weight?'mdi-arrow-down-bold':'mdi-arrow-up-bold'
            result.push({weight:first_weight,icon:first_icon})
            for(let i=1;i<this.weights.length;i++){
                let icon=this.weights[i].value<this.weights[i-1].value?'mdi-arrow-down-bold':'mdi-arrow-up-bold'
                result.push({weight:this.weights[i].value-this.weights[i-1].value,icon:icon})
            }
            return result
        }
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
