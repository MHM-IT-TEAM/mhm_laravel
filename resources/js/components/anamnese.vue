<template>
<div class="container">
   <v-app>
       <v-card>
           <v-card-text>
               <h1 class="title">VITAL SIGNS</h1>
               <patient_information :patient_id="patient_id"/>
               <p class="table-title"><v-icon class="text-blue">mdi-account-circle</v-icon>  &nbsp B) Today's Anamnese</p>
               <textarea  class="form-control form-control-sm" v-model="formData.anamnese"></textarea>
               <v-btn
                   small
                   :loading="loading"
                   :disabled="loading"
                   color="secondary"
                   @click="submit"
                   class="mt-2"
               >
                   Submit
               </v-btn>
               <div class="table-responsive mt-2">

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
                               <th class="text-left">Anamnese</th>
                               <th>User</th>
                               <th></th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr
                               v-for="item in list"
                               :key="item.created_at"
                           >
                               <td>{{ moment(item.created_at).format("MMM Do YY")}}</td>
                               <td>{{item.anamnese}}</td>
                               <td>{{item.user.name}}</td>
                               <td>
                                    <v-icon medium @click="deleteItem(item)" >mdi-delete</v-icon>
                               </td>
                           </tr>
                           <v-dialog v-model="dialogDelete" max-width="500px">
                                                    <v-card>
                                                        <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                                            <v-spacer></v-spacer>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
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
    name: "anamnese",
    components: {Patient_information},
    props:['patient_id','admission_id'],
    data(){
        return{
            loading:false,
            formData:{
                admission_id:'',
                anamnese:'',
                patient_id:''
            },
            list:[],
            editedIndex: -1,
            editedItem:"",
            defaultItem: {
            },
            dialogDelete: false
        }
    },
    created(){
        this.formData.admission_id=this.admission_id ?? null
        this.formData.patient_id= this.patient_id
        axios.get(`/api/v1/patient_system/anamnese/${this.patient_id}`).then(response=>{
            this.list=response.data
        })
    },
    methods:{
        submit(){
            this.formData.user_id = window.auth.user.id
            axios.post('/api/v1/patient_system/anamnese',this.formData).then(response=>{
                this.list=response.data
                this.formData={
                    admission_id:'',
                   patient_id:''
                }
            })
        },
        deleteItem (item) {
            this.editedIndex = this.list.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm () {
            this.list.splice(this.editedIndex, 1)
            this.closeDelete()
            axios.delete(`/api/v1/patient_system/anamnese/${this.editedItem.id}`)
        },
        closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
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
