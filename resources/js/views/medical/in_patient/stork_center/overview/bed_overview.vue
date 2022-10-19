<template>
    <div class="container" id="container">
        <v-app>
           <div class=" d-flex justify-content-center align-items-center">
               <v-card width="100vw" height="100vh">
                   <v-system-bar  color="yellow" >
                       <div class="text-center w-100 font-weight-bold title">
                           Yellow 1
                       </div>
                   </v-system-bar>
                   <v-card-text>
                       <div class="table-responsive">
                           <table class="table table-sm table-bordered">
                               <tr>
                                   <td rowspan="2">Mom</td>
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
                                   <td rowspan="2">Vital signs</td>
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
                       <div class="table-responsive">
                           <table class="table table-sm table-bordered">
                               <tr>
                                   <td style="width:10%" class="first-col">Days</td>
                                   <td style="width:45%">25</td>
                                   <td style="width:45%">24</td>
                               </tr>
                               <tr>
                                   <td class="first-col">Diagnoses</td>
                                   <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                       Aliquam autem consequatur cumque eius fugit in, molestiae nemo neque perferendis placeat possimus quae quasi quo
                                       sapiente sed suscipit voluptas voluptate voluptatem!</td>
                                   <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate delectus ea eius quia
                                       repellendus? Architecto assumenda consequatur corporis debitis deleniti ea esse et iusto non omnis ratione repellendus tenetur, voluptates?</td>
                               </tr>
                               <tr>
                                   <td  class="first-col">Actions</td>
                                   <td >25</td>
                                   <td >24</td>
                               </tr>
                               <tr>
                                   <td class="first-col">Labworks</td>
                                   <td>25</td>
                                   <td>24</td>
                               </tr>
                               <tr>
                                   <td class="first-col">Anamnese</td>
                                   <td>25</td>
                                   <td>24</td>
                               </tr>
                               <tr>
                                   <td class="first-col">Comments</td>
                                   <td>25</td>
                                   <td>24</td>
                               </tr>
                           </table>
                       </div>
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
            cpn_data:{}
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get(`/api/v1/patient_system/in_patient/stork/patient_cpn_data/${this.stork_admission.patient.id}`).then(
                response=>{
                    this.cpn_data=response.data.cpn_admissions[response.data.cpn_admissions.length -1]
                }
            )
        },
        d(input){
            return "D"+ (moment().diff(moment(input), "days")+1)
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
    computed:{
        fullName(){
            return this.null_to_str(this.stork_admission.patient.firstName) +" "+ this.null_to_str(this.stork_admission.patient.lastName)
        },
        patient_age(){
            var difference =
                Date.now() - new Date(this.stork_admission.patient.birthDate).getTime();
            var age = new Date(difference);
            return Math.abs(age.getUTCFullYear() - 1970);
        }
    }
}
</script>

<style scoped>
.first-col{
    vertical-align: middle;
}
</style>
