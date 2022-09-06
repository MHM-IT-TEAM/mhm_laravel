<template>
   <div>
      <v-app>
          <v-card
              class="mx-auto"
              width="90vw"
          >
              <v-toolbar
                  color="indigo"
                  dark
              >
                  <v-toolbar-title>List of patients</v-toolbar-title>

                  <v-spacer></v-spacer>

                 {{patient_list.length}}
              </v-toolbar>

              <v-container fluid>
                  <v-row dense>
                      <v-col
                          v-for="card in patient_list"
                          :key="card.room"
                          v-if="card.beds.length>=1"
                      >
                          <v-card class="p-2" elevation="10">
                              <v-app-bar :color="card.color" dark>
                                  <v-card-title >{{card.room}}</v-card-title>
                              </v-app-bar>

                              <v-row dense>
                                  <v-col v-for="bed in card.beds" :key="bed.code" >
                                      <v-card class="mt-2" elevation="2" min-width="250px">
                                          <v-card-title >{{bed.bed.code}} <v-spacer/><span class="font-weight-bold font-italic">{{(bed.patient_id)}}</span>-{{  null_to_str(bed.patient.firstName) + null_to_str(bed.patient.lastName) }}</v-card-title>
                                          <div class="border h-75 position-relative">
<!--                                              <h6 class="text-center"><span class="font-weight-bold font-italic">{{(bed.patient_id)}}</span>-{{  null_to_str(bed.patient.firstName) + null_to_str(bed.patient.lastName) }}</h6>-->
                                              <v-list-item two-line>
                                                  <v-list-item-content>
                                                      <v-list-item-title>Date In</v-list-item-title>
                                                      <v-list-item-subtitle>{{moment(bed.admission_date).format("MMM Do YY")}}&nbsp <small>({{d(bed.admission_date)}})</small></v-list-item-subtitle>
                                                  </v-list-item-content>
                                              </v-list-item>
                                              <v-list-item two-line >
                                                  <v-list-item-content>
                                                      <v-list-item-title>Diagnose on entry</v-list-item-title>
                                                      <v-list-item-subtitle class="text-danger">{{bed.admission_diagnosis}}</v-list-item-subtitle>
                                                  </v-list-item-content>
                                              </v-list-item>
                                              <v-list-item two-line >
                                                  <v-list-item-content>
                                                      <v-list-item-title>Last diagnose</v-list-item-title>
                                                      <v-list-item-subtitle class="text-danger">{{last_diagnose(bed)}}</v-list-item-subtitle>
                                                  </v-list-item-content>
                                              </v-list-item>

                                              <v-list-item two-line>
                                                  <v-list-item-content>
                                                      <v-list-item-title>Care Category</v-list-item-title>
                                                      <v-list-item-subtitle>{{bed.level_of_care}}</v-list-item-subtitle>
                                                  </v-list-item-content>
                                              </v-list-item>
                                              <v-list-item two-line>
                                                  <v-list-item-content>
                                                      <v-list-item-title>Mobilisation status</v-list-item-title>
                                                      <v-list-item-subtitle>{{bed.mobilisation_status}}</v-list-item-subtitle>
                                                  </v-list-item-content>
                                              </v-list-item>
                                              <v-list-item two-line>
                                                  <v-list-item-content>
                                                      <v-select :items="beds" label="change Bed" item-text="description" item-value="id" @change="change_bed(bed)" v-model="destination_bed"/>
                                                  </v-list-item-content>
                                              </v-list-item>
                                              <v-btn icon  x-small class="btx"  @click="open_menu(bed)">
                                                  <v-icon>mdi-pencil</v-icon>
                                              </v-btn>

                                          </div>
                                      </v-card>
                                  </v-col>
                              </v-row>

                          </v-card>
                      </v-col>
                  </v-row>
              </v-container>
          </v-card>
          <v-dialog
              v-model="dialog_menu"
              max-width="290"
          >
              <v-card>
                  <v-list dense>
                      <v-subheader>MENU</v-subheader>
                      <!--                   <v-list-item-group-->
                      <!--                       v-model="selectedItem"-->
                      <!--                       color="primary"-->
                      <!--                   >-->
                      <!--                       <v-list-item-->
                      <!--                           v-for="(item, i) in items"-->
                      <!--                           :key="i"-->
                      <!--                           @click="process_option"-->

                      <!--                       >-->
                      <!--                           <v-list-item-icon>-->
                      <!--                               <v-icon v-text="item.icon"></v-icon>-->
                      <!--                           </v-list-item-icon>-->
                      <!--                           <v-list-item-content>-->
                      <!--                               <v-list-item-title v-text="item.text"  ></v-list-item-title>-->
                      <!--                           </v-list-item-content>-->
                      <!--                       </v-list-item>-->
                      <!--                   </v-list-item-group>-->
                      <v-list-group
                          no-action
                          sub-group
                          v-for="menu in dropdown"
                          :key="menu.text"
                          :value="menu.active"
                      >
                          <template v-slot:activator>
                              <v-list-item-content>
                                  <v-list-item-title>{{menu.text}}</v-list-item-title>
                              </v-list-item-content>
                          </template>

                          <v-list-item
                              v-for="(item, i) in menu.children"
                              :key="i"
                              link
                              @click="process_option(item)"

                          >
                              <v-list-item-title v-text="item.text"></v-list-item-title>

                              <v-list-item-icon>
                                  <v-icon v-text="item.icon"></v-icon>
                              </v-list-item-icon>
                          </v-list-item>
                      </v-list-group>

                  </v-list>
                  <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                          color="green darken-1"
                          text
                          @click="dialog_menu = false"
                      >
                          Close
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
      </v-app>
   </div>

</template>

<script>
import moment from "moment";
export default {
    name: "stork_patient_list",
    data: () => ({
        start_list:[],
        dialog_menu:false,
        chosen_patient:null,
        dropdown: [
            {
                text: 'Diagnostic',
                icon: 'mdi-clock',
                active:false,
                children:[
                    {text:'Balance Sheet',url:'stork_diagnostic_balance_list'},
                    {text:'Pregnancy checkup',url:'stork_diagnostic_pregnancy_checkup'},
                    {text:'Weekly measurments',url:'stork_weekly_measurments'},
                    // {text:'Excretion',url:''},
                    // {text:'Post partum checkup',url:''},
                    {text:'Vital signs',url:'stork_vital_signs'},
                    {text:'diagnoses',url:'stork_diagnose'},
                ]
            },
            {
                text: 'Treatment',
                icon: 'mdi-account',
                active:false ,
                children:[
                    {text:"Medicines",url:'stork_give_medicine'},
                    {text:"Woundcare",url:'stork_wound_care'},
                    {text:"Mobilisation",url:'stork_mobilisation'},
                    {text:"Body-care",url:'stork_body_care'},
                    {text:"Medical care",url:'stork_medical_care'},
                    // {text:"Feeding report baby",url:''},
                    // {text:"Bladder training",url:''},
                ]
            },
            {
                text: 'Consultation',
                icon: 'mdi-flag',
                active:false ,
                children:[
                    {text:'internal',url:'stork_internal_consultation'},
                    {text:'external',url:'stork_external_consultation'},
                ]
            },
            {
                text: 'Labwork',
                icon: 'mdi-flag',
                active:false ,
                children:[
                    {text:'internal',url:'stork_internal_lab'},
                    {text:'external',url:''},
                ]
            },
            {
                text: 'Dismiss/refer',
                icon: 'mdi-flag',
                active:false ,
                children:[
                    // {text:'Change Bed',url:'stork_change_bed'},
                    {text:'Dismiss',url:'stork_dismissal'},
                    {text:'External Referral',url:'stork_external_referral'},
                    {text:'Internal Referral',url:'stork_internal_referral'},
                ]
            },
        ],
        beds:[],
        destination_bed:''
    }),
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get("/api/v1/patient_system/in_patient/stork/admission").then(response=>this.start_list=response.data)
            axios.get(`/api/v1/extra/bed/0`).then(response=>this.beds=response.data)
        },
        open_menu(bed){
            this.dialog_menu=true
            this.chosen_patient=bed
        },
        process_option(item){
            this.$router.push({name:item.url,params:{stork_admission:this.chosen_patient,admission_id:this.chosen_patient.admission_id,admission:this.chosen_patient.admission}})
        },
        null_to_str(str){
            return str? str:""
        },
        d(input){
            return "D"+ (moment().diff(moment(input), "days")+1)
        },
        last_diagnose(input){
            let el =input.stork_diagnoses[input.stork_diagnoses.length -1]
            return el? `(${moment(el.created_at).format('MMM Do YY')}/${el.time})- ${el.diagnose}-${el.type}`:''
        },
        change_bed(bed){
            let data= {stork_admission_id:bed.id,source_bed:bed.bed_id, destination_bed:this.destination_bed }
            axios.post('/api/v1/patient_system/in_patient/stork/change_bed',data).then(
                response=>{
                    if(response.data.success){
                        this.init()
                        this.destination_bed=''
                    }
                }
            )
        }
    },
    computed:{
        patient_list(){
            return [
                {
                    room:'Red room',
                    color:'red',
                    beds:this.start_list.filter(list=>list.bed.room==='red')
                },
                {
                    room:'Yellow room',
                    color:'yellow',
                    beds:this.start_list.filter(list=>list.bed.room==='yellow')
                },
                {
                    room:'Recovery room',
                    color:'blue',
                    beds:this.start_list.filter(list=>list.bed.room==='recovery')
                },
                {
                    room:'STC',
                    color:'green',
                    beds:this.start_list.filter(list=>list.bed.room==='STC')
                },
                {
                    room:'Turquoise',
                    color:'cyan',
                    beds:this.start_list.filter(list=>list.bed.room==='TQU')
                },
                {
                    room:'Pink',
                    color:'pink',
                    beds:this.start_list.filter(list=>list.bed.room==='PINK')
                },
            ]
        }

    }
}
</script>

<style scoped>
.btx{
    position:absolute;
    bottom:0;
    right:5px;
}
</style>
