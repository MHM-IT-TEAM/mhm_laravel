<template>
   <div>
       <v-app>
           <v-simple-table>
               <template v-slot:default>
                   <thead>
                   <tr>
                       <th class="text-left">Id</th>
                       <th class="text-left">
                           firstName
                       </th>
                       <th class="text-left">
                           lastName
                       </th>
                       <th class="text-left">
                           Status
                       </th>
                       <th>
                           Actions
                       </th>
                   </tr>
                   </thead>
                   <tbody>
                   <tr
                       v-for="item in list"
                   >
                       <td>{{ item.patient.id }}</td>
                       <td>{{ item.patient.firstName }}</td>
                       <td>{{item.patient.lastName}}</td>
                       <td>{{item.status}}</td>
                       <td><v-btn icon @click="redirect(item.id,item.patient.id)"><v-icon>mdi-pencil-box-multiple</v-icon></v-btn></td>
                   </tr>
                   </tbody>
               </template>
           </v-simple-table>
       </v-app>
   </div>
</template>

<script>
export default {
    name: "patient_list",
    props:{
        type_consult:'',
    },

    data(){
        return{
            list:[],
            route_name:'',
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            let data;
            switch (this.type_consult){
                case 1:
                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    data=await axios.get('/api/obstetrics/first_cpn_list')
                    this.route_name='cpn_admission'
                    break;
                case 5:
                    break;
                case 6:
                    break;
                case 7:
                    data=await axios.get('/api/obstetrics/baby_vaccination/todayList')
                    this.route_name='baby_vaccination_card'
                    break;
                case 8:
                    data=await axios.get('/api/obstetrics/baby_checkup/todayList')
                    this.route_name='baby_checkup'
                    break;
                case 9:
                    break;
                case 10:
                    break;
                case 11:
                    break;
            }
            this.consultation_id=data.id
            this.list=data.data
        },
        redirect(consultation_id,patient_id){
            this.$router.push({
                name:this.route_name,
                params:{
                    patient_id:patient_id,
                    consultation_id:consultation_id
                }
            })

        }
    },
}
</script>

<style scoped>

</style>
