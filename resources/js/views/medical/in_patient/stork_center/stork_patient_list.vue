<template>
   <div>
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

               <v-btn icon>
                   <v-icon>mdi-magnify</v-icon>
               </v-btn>
           </v-toolbar>

           <v-container fluid>
               <v-row dense>
                   <v-col
                       v-for="card in patient_list"
                       :key="card.room"
                   >
                       <v-card class="p-2" elevation="10">
                           <v-app-bar :color="card.color" dark>
                               <v-card-title v-text="card.room" ></v-card-title>
                           </v-app-bar>

                           <v-row dense>
                               <v-col v-for="bed in card.beds" :key="bed.code" >
                                   <v-card class="mt-2" elevation="2">
                                       <v-card-title v-text="bed.code"></v-card-title>
                                       <div class="border h-75 position-relative">
                                           <h6 class="text-center"><span class="font-weight-bold font-italic">{{(bed.patient_id)}}</span>-{{  null_to_str(bed.patient.firstName) + null_to_str(bed.patient.lastName) }}</h6>
                                           <v-list-item two-line >
                                               <v-list-item-content>
                                                   <v-list-item-title>Diagnose</v-list-item-title>
                                                   <v-list-item-subtitle class="text-danger">{{bed.admission_diagnosis}}</v-list-item-subtitle>
                                               </v-list-item-content>
                                           </v-list-item>
                                           <v-list-item two-line >
                                               <v-list-item-content>
                                                   <v-list-item-title>Date In</v-list-item-title>
                                                   <v-list-item-subtitle>{{bed.admission_date}}&nbsp <small>({{moment(bed.admission_date, "YYYYMMDD").fromNow()}})</small></v-list-item-subtitle>
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
                    {text:'Weekly measurments',url:''},
                    {text:'Excretion',url:''},
                    {text:'Post partum checkup',url:''},
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
                    {text:"Feeding report baby",url:''},
                    {text:"Bladder training",url:''},
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
                    {text:'Dismiss',url:'stork_dismissal'},
                    {text:'External Referral',url:'stork_external_referral'},
                    {text:'Internal Referral',url:'stork_internal_referral'},
                ]
            },
        ],
    }),
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get("/api/v1/patient_system/in_patient/stork/admission").then(response=>this.start_list=response.data)
        },
        open_menu(bed){
            this.dialog_menu=true
            this.chosen_patient=bed
        },
        process_option(item){
            this.$router.push({name:item.url,params:{stork_admission:this.chosen_patient,admission_id:this.chosen_patient.admission_id}})
        },
        null_to_str(str){
            return str? str:""
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
