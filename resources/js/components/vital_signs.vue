<template>
<div class="container">
   <v-app>
       <v-card>
           <v-card-text>
               <h1 class="title">VITAL SIGNS</h1>
               <patient_information :patient_id="patient_id"/>
               <p class="table-title"><v-icon class="text-blue">mdi-account-circle</v-icon> &nbsp B) Today's diagnostic</p>
               <div class="table-responsive">
                   <table class="table table-sm">
                       <tr>
                           <td>Time</td>
                           <td>BP.L</td>
                           <td>BP.R</td>
                           <td>pulse</td>
                           <td>Spo2</td>
                           <td>Temp</td>
                           <td>Weight</td>
                           <td></td>
                       </tr>
                       <tr>
                           <td>
                               <input type="time" class="form-control form-control-sm" v-model="formData.time">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.bp_l">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.bp_r">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.pulse">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.spo2">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.temp">
                           </td>
                           <td>
                               <input type="text" class="form-control form-control-sm" v-model="formData.weight">
                           </td>
                           <td>
                               <v-btn
                                   small
                                   :loading="loading"
                                   :disabled="loading"
                                   color="secondary"
                                   @click="submit"
                               >
                                   Submit
                               </v-btn>
                           </td>
                       </tr>
                   </table>
                   <h5>Data in the system</h5>
                   <v-simple-table
                       fixed-header
                       height="300px"
                   >
                       <template v-slot:default>
                           <thead>
                           <tr>
                               <th class="text-left">
                                   Date
                               </th>
                               <th class="text-left">Time</th>
                               <th class="text-left">
                                   BP-L
                               </th>
                               <th class="text-left">
                                   BP-R
                               </th>
                               <th class="text-left">
                                   PULSE
                               </th>
                               <th class="text-left">
                                   SPO2
                               </th>
                               <th class="text-left">
                                   TEMP
                               </th>
                               <th class="text-left">
                                   Weight
                               </th>
                               <th>User</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr
                               v-for="item in list"
                               :key="item.created_at"
                           >
                               <td>{{ moment(item.created_at).format("MMM Do YY")}}</td>
                               <td>{{item.time}}</td>
                               <td>{{ item.bp_l}}</td>
                               <td>{{ item.bp_r }}</td>
                               <td>{{ item.pulse }}</td>
                               <td>{{ item.spo2 }}</td>
                               <td>{{ item.temp}}</td>
                               <td>{{ item.weight}}</td>
                               <td>{{ item.user}}</td>
                           </tr>
                           </tbody>
                       </template>
                   </v-simple-table>
               </div>
           </v-card-text>
       </v-card>
   </v-app>
</div>
</template>

<script>
import Patient_information from "./patient_information";
import moment from "moment"
export default {
    name: "vital_signs",
    components: {Patient_information},
    props:['patient_id','admission_id'],
    data(){
        return{
            loading:false,
            formData:{
                admission_id:'',
                time:'',
                bp_l:'',
                bp_r:'',
                pulse:'',
                temp:'',
                spo2:'',
                weight:''
            },
            list:[]
        }
    },
    created(){
        this.formData.admission_id=this.admission_id ?? null
        axios.get(`/api/v1/patient_system/vital_sign/${this.admission_id}`).then(response=>{
            this.list=response.data
        })
    },
    methods:{
        submit(){
            this.formData.user = window.auth.user.name
            axios.post('/api/v1/patient_system/vital_sign',this.formData).then(response=>{
                this.list=response.data
                this.formData={
                    admission_id: this.formData.admission_id,
                    bp_l:'',
                    bp_r:'',
                    pulse:'',
                    temp:'',
                    spo2:'',
                    weight:''
                }
            })
        }
    }
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
.table-title{
    background-color: #1390C6;
    color:white;
}
</style>
