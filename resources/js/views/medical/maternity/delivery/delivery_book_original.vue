<template>
    <div>
       <div class="table-responsive">
           <table class="table">
               <tr class="table-bordered">
                   <th>Nr</th>
                   <th colspan="7" class="text-center">Mother</th>
                   <th colspan="11" class="text-center">Birth</th>
                   <th colspan="8" class="text-center">Baby</th>
                   <th colspan="2" class="text-center">Administration</th>
                   <th colspan="2" class="text-center" >Timeline</th>
                   <th>Responsibles</th>
               </tr>
               <tr class="subheader">
                   <td>Ref</td>
                   <td>Id</td>
                   <td style="width:240px !important">Fullname</td>
                   <td>Birthdate</td>
                   <td>Adress</td>
                   <td>G/P/A/M/EV</td>
                   <td>LPD</td>
                   <td>GA</td>
                   <td>Birth date</td>
                   <td>Birth time</td>
                   <td>Modus</td>
                   <td>Complications</td>
                   <td>Placenta time</td>
                   <td>Complete</td>
                   <td>Blood loss</td>
                   <td>Birth injuries</td>
                   <td>Stiches</td>
                   <td>Medicine used during delivery</td>
                   <td>Medicine used after delivery</td>
                   <td>Id</td>
                   <td >Fullname</td>
                   <td>Gender</td>
                   <td>Vit k</td>
                   <td>E1</td>
                   <td>Malformation</td>
                   <td>Weight/Length/Head/Chest/Arm</td>
                   <td>Apgar</td>
                   <td>Sterilization package Nr</td>
                   <td>Sterilization Suture Nr</td>
                   <td>Time arrived</td>
                   <td>Time dismissed</td>
                   <td>Medical team</td>
               </tr>
               <tr v-for="del in list">
                   <td>{{del.ref}}</td>
                   <td>{{del.mom.patient_id}}</td>
                   <td>{{del.mom.fullName}}</td>
                   <td>{{del.mom.birthDate}}</td>
                   <td>{{del.mom.birthDate}}</td>
                   <td>{{del.mom.G}}/{{del.mom.P}}/{{del.mom.A}}/{{del.mom.M}}/{{del.mom.EV}}/</td>
                   <td>{{del.mom.lpd}}</td>
                   <td :class="check_ga(del.delivery.GA)">{{del.delivery.GA}}</td>
                   <td>{{del.delivery.date}}</td>
                   <td>{{del.delivery.time}}</td>
                   <td>{{del.baby.modus}}</td>
                   <td class="text-danger">{{del.delivery.complications}}</td>
                   <td>{{del.mom.placenta_time}}</td>
                   <td :class="{'text-danger':del.mom.placenta_complete==='no'}">{{del.mom.placenta_complete}}</td>
                   <td  class="text-danger">{{del.delivery.injuries}}</td>
                   <td  class="text-danger">{{del.delivery.blood_loss}}</td>
                   <td  class="text-danger">{{del.delivery.stiches}}</td>
                   <td>{{del.medicines.during}}</td>
                   <td>{{del.medicines.after}}</td>
                   <td>{{del.baby.id}}</td>
                   <td style="width:300px !important">{{del.baby.firstName+ " "+ del.baby.lastName}}</td>
                   <td>{{del.baby.gender}}</td>
                   <td>{{del.baby.vit_k}}</td>
                   <td>{{del.baby.E1}}</td>
                   <td class="text-danger">{{del.baby.malformation}}</td>
                   <td ><span :class="{'text-danger':del.baby.weight<2500}">{{del.baby.weight}}</span>/{{del.baby.length}}/{{del.baby.head}}/{{del.baby.chest}}/{{del.baby.arm}}</td>
                   <td>{{del.baby.apgar}}</td>
                   <td>{{del.delivery.sterilisation_package}}</td>
                   <td>{{del.delivery.sterilization_suture}}</td>
                   <td>{{del.timeline.time_arrived}}</td>
                   <td>{{del.timeline.time_dismissed}}</td>
               </tr>
           </table>
       </div>
    </div>
</template>

<script>
export default {
    name: "delivery_book",
    data(){
        return{
            list:[
                {
                    ref:'',
                    mom:{
                        patient_id:'',
                        fullName:'',
                        birthDate:'',
                        address:'',
                        G:'',P:'',A:'',EV:'',M:'',
                        lpd:'',ga:'', placenta_complete:'', placenta_time:''
                    },
                    delivery:{
                        date:'',time:'',modus:'',complications:'',injuries:'',stiches:'',blood_loss:'',sterilisation_package:'',sterilisation_suture:''
                    },
                    medicines:{
                        during:'',after:''
                    },
                    baby:{
                        id:'',fullName:'',gender:'',malformation:'',weight:'',length:'',head:'',chest:'',arm:'',vit_k:'',E1:'',apgar:'',modus:''
                    },
                    timeline:{
                        time_arrived:'',time_dismissed:''
                    },
                    responsibles:[]
                }
            ]
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/maternity/delivery_registration/').then(response=>{
                this.list=response.data
            })
        },
        check_ga(val){
            if(val){
                if(parseInt(val.substring(0,2))<=36) return 'text-danger'
                if(parseInt(val.substring(0,2))<=37) return 'text-warning'
            }
        }
    },

}
</script>

<style scoped>

.table-responsive{
    margin: 0 auto;
    max-width:90vw;
    overflow: auto;
    height:100vh;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    transform:scale(0.8)
}
.subheader td{
    border: 0.5px solid lightgrey;
}
</style>
