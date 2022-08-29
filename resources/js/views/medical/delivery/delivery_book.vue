<template>
<div class="container-fluid">
 <v-app>
     <h1 class="title">Delivery Book</h1>
     <v-text-field
         v-model="search"
         append-icon="mdi-magnify"
         label="Search"
         single-line
         hide-details
     ></v-text-field>
     <v-data-table
         :headers="headers"
         :items="list"
         :search="search"
         height="90vh"
         multi-sort
     >
         <template v-slot:item.baby.weight="{ item }">
             <v-chip
                 :color="check_weight(item.baby.weight)"
                 dark
             >
                 {{ item.baby.weight }}
             </v-chip>
         </template>

     </v-data-table>
 </v-app>
</div>
</template>

<script>
export default {
    name: "delivery_book",
    data(){
        return{
            search:'',
            list:[],
            headers:[
                { text: 'Ref', value: 'ref' },
                { text: 'Mom ID', value: 'mom.patient_id' },
                { text: ' Mom Fullname', value: 'mom.fullName' },
                { text: 'BirthDate', value: 'mom.birthDate' },
                { text: 'Address', value: 'mom.address' },
                { text: 'G', value: 'mom.G' },
                { text: 'P', value: 'mom.P' },
                { text: 'A', value: 'mom.A' },
                { text: 'EV', value: 'mom.EV' },
                { text: 'M', value: 'mom.M' },
                { text: 'LPD', value: 'mom.lpd' },
                { text: 'GA', value: 'delivery.GA' },
                { text: 'Delivery date', value: 'delivery.date' },
                { text: 'Delivery time', value: 'delivery.time' },
                { text: 'Modus', value: 'baby.modus' },
                { text: 'Induction', value: 'delivery.induction' },
                { text: 'Induction method', value: 'delivery.induction_method' },
                {text:'Position mom',value:'mom.position'},
                { text: 'Complications Mom before birth', value: 'delivery.complication_mom_before_birth' },
                { text: 'Complications Mom after birth', value: 'delivery.complication_mom_after_birth' },
                { text: 'Placenta time', value: 'mom.placenta_time' },
                { text: 'Placenta complete', value: 'mom.placenta_complete' },
                { text: 'Placenta manual revision', value: 'mom.placenta_manual_revision' },
                { text: 'Placenta curetage', value: 'mom.placenta_curetage' },
                { text: 'Anesthesia', value: 'mom.anesthesia' },
                { text: 'Blood loss', value: 'delivery.blood_loss' },
                { text: 'Injuries (Where,position,degree)', value: 'delivery.injuries' },
                { text: 'Stiches', value: 'stiches' },
                { text: 'medicines', value: '' },
                { text: 'Baby ID', value: 'baby.id' },
                { text: 'Baby FirstName', value: 'baby.firstName' },
                { text: 'Baby lastName', value: 'baby.lastName' },
                { text: 'Gender', value: 'baby.gender' },
                { text: 'E1', value: 'baby.E1' },
                {text:'Position baby',value:'baby.position'},
                {text:'Correlation',value:'baby.correlation'},
                { text: 'Malformation', value: 'baby.malformation' },
                { text: 'Weight', value: 'baby.weight' },
                { text: 'Length', value: 'baby.length' },
                { text: 'Head', value: 'baby.head' },
                { text: 'chest', value: 'baby.chest' },
                { text: 'chest', value: 'baby.chest' },
                { text: 'Arm', value: 'baby.arm' },
                { text: 'apgar', value: 'baby.apgar' },
            ]
        }

    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/patient_system/delivery/book').then(response=>{
                this.list=response.data
            })
        },
        check_ga(val){
            if(val){
                if(parseInt(val.substring(0,2))<=36) return 'text-danger'
                if(parseInt(val.substring(0,2))<=37) return 'text-warning'
            }
        },
        check_weight(val){
            if(val<2500) return 'orange'
            if(val<2000) return 'red'
            return 'green'
        }
    },

}
</script>

<style scoped>
.table{
    max-width: 80vw;
}
.title{
    font-weight: bold;
    color:#1390c6;
}
</style>
