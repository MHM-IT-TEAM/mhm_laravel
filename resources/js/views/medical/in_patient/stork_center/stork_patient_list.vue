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
                                           <h6 class="text-center"><span class="font-weight-bold font-italic">{{(bed.patient_id)}}</span>-{{  bed.patient.firstName + bed.patient.lastName }}</h6>
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
        rooms:[
            {
                room:'red',
                color:'red',
                beds:[
                    {code:'R1',patient_id:10900,occupied:true,fullName:'Dimby Tiavina Idealisoa Princy',diagnosis:'Prenatal Checkup',date_in:'2022-04-02'},
                    {code:'R2',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                    {code:'R3',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                    {code:'R4',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                ]
            },
            {
                room:'yellow',
                color:'yellow',
                beds:[
                    {code:'Y1',patient_id:10700,occupied:true,fullName:'RANJASON',diagnosis:'MARAR LOHA',date_in:''},
                    {code:'Y2',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                    {code:'Y3',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                    {code:'Y4',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                ]
            },
            {
                room:'Recovery',
                color:'blue',
                beds:[
                    {code:'R1',patient_id:10700,occupied:true,fullName:'RANJASON',diagnosis:'MARAR LOHA',date_in:''},
                    {code:'R2',patient_id:null,occupied:false,fullName:'',diagnosis:'',date_in:''},
                ]
            },

        ],
        dialog_menu:false,
        dropdown: [
            {
                text: 'Diagnostic',
                icon: 'mdi-clock',
                active:false,
                children:[
                    {text:'Balance Sheet',url:'stork_diagnostic_balance'},
                    {text:'Pregnancy checkup',url:'stork_diagnostic_pregnancy_checkup'},
                    {text:'Weekly measurments',url:''},
                    {text:'Excretion',url:''},
                    {text:'Post partum checkup',url:''},
                    {text:'Vital signs',url:'stork_vital_signs'},
                ]
            },
            {
                text: 'Treatment',
                icon: 'mdi-account',
                active:false ,
                children:[
                    {text:"Medicines",url:'stork_give_medicine'},
                    {text:"Woundcare",url:''},
                    {text:"Mobilisation",url:''},
                    {text:"Body-care/Mobilisation help",url:''},
                    {text:"Breast Care",url:''},
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
                    {text:'internal',url:''},
                    {text:'external',url:''},
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
        },
        process_option(item){
            this.$router.push({name:item.url})
        }
    },
    computed:{
        patient_list(){
            return [
                {
                    room:'red',
                    color:'red',
                    beds:this.start_list.filter(list=>list.bed.room==='red')
                },
                {
                    room:'yellow',
                    color:'yellow',
                    beds:this.start_list.filter(list=>list.bed.room==='yellow')
                },
                {
                    room:'Recovery',
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
