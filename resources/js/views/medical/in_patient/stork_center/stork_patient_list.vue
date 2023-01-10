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
<!--                  <v-text-field v-model="search_text"/>-->
                 {{count_of_patient}}
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
                                          <v-card-text>
                                              <div class="border">
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
                                                          <v-list-item-title @click="bed.show_care_level_menu = !bed.show_care_level_menu">
                                                             Level of care: {{last_level_of_care(bed)}}
                                                          </v-list-item-title>
                                                          <v-list-item-subtitle v-if="bed.show_care_level_menu">
                                                              <v-select dense :items="care_level" label="Change level of Care" item-text="description"
                                                                        item-value="id" @change="change_care(bed)"
                                                                        v-model="bed.new_care_level"/>
                                                          </v-list-item-subtitle>

                                                      </v-list-item-content>
                                                  </v-list-item>
                                                  <v-list-item two-line>
                                                      <v-list-item-content>
<!--                                                          <v-list-item-title>Mobilisation status</v-list-item-title>-->
<!--                                                          <v-list-item-subtitle>{{bed.mobilisation_status}}</v-list-item-subtitle>-->
                                                          <v-list-item-title @click="bed.show_mobilisation_menu = !bed.show_mobilisation_menu">
                                                              Mobilisation: {{last_mobilisation(bed)}}
                                                          </v-list-item-title>
                                                          <v-list-item-subtitle v-if="bed.show_mobilisation_menu">
                                                              <v-select dense :items="mobilisation_menu" label="Change mobilisation" item-text="description"
                                                                        item-value="id" @change="change_mobilisation(bed)"
                                                                        v-model="bed.new_mobilisation"/>
                                                          </v-list-item-subtitle>
                                                      </v-list-item-content>
                                                  </v-list-item>
                                                  <v-list-item two-line>
                                                      <v-list-item-content>
                                                          <v-select :items="beds" label="change Bed" item-text="description" item-value="id" @change="change_bed(bed)" v-model="destination_bed"/>
                                                      </v-list-item-content>
                                                  </v-list-item>
                                              </div>
                                              <v-card-actions>
                                                  <v-btn
                                                      class="mx-2"
                                                      fab
                                                      dark
                                                      x-small
                                                      @click="open_menu(bed)"
                                                      color="cyan"
                                                  >
                                                      <v-icon dark>
                                                          mdi-pencil
                                                      </v-icon>
                                                  </v-btn>
                                                  <v-btn
                                                      class="mx-2"
                                                      fab
                                                      dark
                                                      x-small
                                                      @click="view_admission(bed)"
                                                      color="primary"
                                                  >
                                                      <v-icon dark>
                                                          mdi-eye
                                                      </v-icon>
                                                  </v-btn>
                                                  <v-btn
                                                      class="mx-2"
                                                      dark
                                                      x-small
                                                      @click="launch_projection(bed)"
                                                      color="primary"
                                                  >
                                                     Projection
                                                  </v-btn>
                                              </v-card-actions>
                                          </v-card-text>
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
          <v-dialog
              v-model="overview_dialog"

          >
              <v-card>
                  <v-card-text>
                      <stork_admission is_overview :stork_admission="chosen_stork_admission" v-if="overview_dialog"/>
                  </v-card-text>
              </v-card>
          </v-dialog>
          <v-dialog
              v-model="projection_dialog"
          >
              <v-card>
                  <v-card-text>
                      <bed_overview :stork_admission="chosen_stork_admission" v-if="projection_dialog"/>
                  </v-card-text>
              </v-card>
          </v-dialog>
      </v-app>
   </div>

</template>

<script>
import moment from "moment";
import Stork_admission from "./stork_admission";
import Bed_overview from "./overview/bed_overview";
export default {
    name: "stork_patient_list",
    components: {Bed_overview, Stork_admission},
    data: () => ({
        start_list:[],
        dialog_menu:false,
        chosen_patient:null,
        dropdown: [
            {
                text: 'Projection',
                icon: 'mdi-clock',
                active:false,
                children:[                    
                    {text:"Plan",url:'stork_patient_plan'},
                    {text:'Anamnese',url:'stork_anamnese'},
                    {text:'Comment',url:'stork_comment'},
                ]
            },
            {
                text: 'Diagnostic',
                icon: 'mdi-clock',
                active:false,
                children:[
                    {text:'Balance Sheet',url:'stork_diagnostic_balance_list'},
                    {text:'Diagnoses',url:'stork_diagnose'},
                    // {text:'Post partum checkup',url:''},
                    {text:'Pregnancy checkup',url:'stork_diagnostic_pregnancy_checkup'},
                    {text:'Vital signs',url:'stork_vital_signs'},
                    {text:'Weekly measurments',url:'stork_weekly_measurments'},
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
                    {text:'additional',url:'stork_additional_consultation'},
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
            {
                text: 'Extra',
                icon: 'mdi-flag',
                active:false ,
                children:[
                    // {text:'Change Bed',url:'stork_change_bed'},
                    {text:'Order Lunch',url:'stork_pay_lunch'},
                ]
            },
        ],
        beds:[],
        destination_bed:'',
        new_care_level:'',
        care_level:['normal care','intermediary care','intensive care'],
        mobilisation_menu:['bed rest','strict bed rest','mobilisation','no restriction'],
        search_text:'',
        overview_dialog:false,
        projection_dialog:false,
        chosen_stork_admission:null,

    }),
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get("/api/v1/patient_system/in_patient/stork/admission").then(response=>{
                response.data.forEach(list=>{
                    list.show_care_level_menu=false
                    list.show_mobilisation_menu=false
                })
                this.start_list=response.data
            })
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
        last_level_of_care(input){
            let el =input.patient_care_category_histories[input.patient_care_category_histories.length -1]
            return el? `(${moment(el.created_at).format('MMM Do YY')}/${el.category})`:input.level_of_care

        },
        last_mobilisation(input){
            let el =input.patient_mobilisation_histories[input.patient_mobilisation_histories.length -1]
            return el? `(${moment(el.created_at).format('MMM Do YY')}/${el.mobilisation})`:input.mobilisation_status

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
        },
        change_care(bed){
            let data= {stork_admission_id:bed.id,category:bed.new_care_level}
            axios.post('/api/v1/patient_system/in_patient/stork/update_care_level',data).then(
                response=>{
                    if(response.data.success){
                        this.init()
                    }
                }
            )

        },
        change_mobilisation(bed){
            let data= {stork_admission_id:bed.id,mobilisation:bed.new_mobilisation}
            axios.post('/api/v1/patient_system/in_patient/stork/update_mobilisation',data).then(
                response=>{
                    if(response.data.success){
                        this.init()
                    }
                }
            )
        },
        async view_admission(bed){
            this.chosen_stork_admission={}
            this.overview_dialog=true
            this.chosen_stork_admission= Object.assign({},bed)
        },
        async launch_projection(bed){
            // this.chosen_stork_admission={}
            this.chosen_stork_admission= Object.assign({},bed)
            this.projection_dialog=true

        }
    },
    computed:{
        patient_list(){

            return [
                {
                    room:'Red room',
                    color:'red',
                    beds:this.start_list.filter(list=>list.bed.room==='red').sort((a,b)=>(a.bed.code >  b.bed.code) ? 1 : ((b.bed.code >  a.bed.code) ? -1 : 0))
                },
                {
                    room:'Yellow room',
                    color:'yellow',
                    beds:this.start_list.filter(list=>list.bed.room==='yellow').sort((a,b)=>(a.bed.code >  b.bed.code) ? 1 : ((b.bed.code >  a.bed.code) ? -1 : 0))
                },
                {
                    room:'Recovery room',
                    color:'blue',
                    beds:this.start_list.filter(list=>list.bed.room==='recovery').sort((a,b)=>(a.bed.code >  b.bed.code) ? 1 : ((b.bed.code >  a.bed.code) ? -1 : 0))
                },
                {
                    room:'STC',
                    color:'green',
                    beds:this.start_list.filter(list=>list.bed.room==='STC').sort((a,b)=>(a.bed.code  > b.bed.code) ? 1 : ((b.bed.code >  a.bed.code) ? -1 : 0))
                },
                {
                    room:'Turquoise',
                    color:'cyan',
                    beds:this.start_list.filter(list=>list.bed.room==='TQU').sort((a,b)=>(a.bed.code >  b.bed.code) ? 1 : ((b.bed.code >  a.bed.code) ? -1 : 0))
                },
                {
                    room:'Pink',
                    color:'pink',
                    beds:this.start_list.filter(list=>list.bed.room==='PINK').sort((a, b) => a.code - b.code)
                },
            ]
        },
        count_of_patient(){
            let count=0;
            this.patient_list.forEach(list=>{
                count+=list.beds.length
            })
            return count
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
