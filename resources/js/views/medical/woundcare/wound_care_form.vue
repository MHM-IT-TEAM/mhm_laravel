<template>
   <v-app>
       <div class="container">
           <v-card>
               <v-card-title>Wound care</v-card-title>
               <v-card-text>
                   <h6>{{$route.params.fullName}}</h6>
                   <v-row>
                       <v-col cols="4">
                           <v-textarea label="Diagnostic" rows="2" v-model="formData.diagnostic"/>
                       </v-col>
                       <v-col>
                           <v-textarea label="Description" rows="2"v-model="formData.description"/>
                       </v-col>
                   </v-row>
                   <h6></h6>
                   <div class="table-responsive">
                       <table class="table table-sm">
                           <tr>
                               <td style="width:70%">
<!--                                   <div class="form-group">-->
<!--                                       <label>Material</label>-->
<!--                                       <select class="form-control form-control-sm" v-model="temp_row.material">-->
<!--                                           <option v-for="mat in materials">-->
<!--                                               {{mat}}-->
<!--                                           </option>-->
<!--                                       </select>-->
<!--                                   </div>-->
                                   <v-autocomplete :items="materials" v-model="temp_row.material"  label="Material" class="mt-4"></v-autocomplete>
                               </td>
                               <td>
                                   <v-text-field  v-model="temp_row.quantity" class="mt-4" label="quantity"/>
                               </td>
                               <td style="width: 15%">
                                   <div class="form-group">
                                       <v-autocomplete :items="units" v-model="temp_row.unit"  label="Unit" class="mt-4"></v-autocomplete>
                                   </div>
                               </td>
                               <td>
                                   <v-btn small  class="mt-6" dark color="blue" @click="add_row">Add</v-btn>
                               </td>
                           </tr>
                           <tr v-for="row in formData.materials">
                               <td>{{row.material}}</td>
                               <td>{{row.quantity}}</td>
                               <td>{{row.unit}}</td>
                               <td>
                                   i
                               </td>
                           </tr>
                       </table>
                       <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
                   </div>
                   <div class="form-group">
                       <label>Appointment</label>
                       <input type="date" class="form-control form-control-sm" v-model="formData.appointment" style="width:150px">
                   </div>
               </v-card-text>
           </v-card>
       </div>
   </v-app>
</template>

<script>
import Give_medicine from "../../../components/give_medicine";
export default {
    name: "wound_care_form",
    components: {Give_medicine},
    data(){
        return{
            materials:[
                'Gauze steril'
                ,'Gauze non steril','Sparadrap','Gloves','Syringe 50cc','Syringe 20cc','Syringe 10cc','Syringe 5cc','Syringe 2cc',
                'sterile gloves','transflow','Bandage elastic','Bandage brown','Bandage White','SSI','Betadine gel','Cream nivea','Locain 2%',
                'xylonon'
            ],
            units:[
                'piece','ml','tab','box','tube','bottle','gellule','ampoule','cm','mm','m','g','mg','drop'
            ],
            formData:{
                admission_id:'',
                materials:[],
                appointment:''
            },
            temp_row:{
                material:'',
                quantity:'',
                unit:''
            },
            reset_medication_list:false,
        }
    },
    methods:{
        add_row(){
            this.formData.materials.push(this.temp_row)
            this.temp_row={
                material:'',
                quantity:'',
                unit:''
            }
        },
        get_medicines(data){
            this.formData.medication=data
        },
    }
}
</script>

<style scoped>

</style>
