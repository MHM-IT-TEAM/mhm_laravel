<template>
   <v-app>
       <div class="container">
           <v-card>
               <v-card-title>Wound care</v-card-title>
               <v-card-text>
                   <h6>{{$route.params.fullName}}</h6>
                   <v-row>
                       <v-col cols="4">
                           <v-textarea label="Diagnostic" rows="2" v-model="formData.diagnostic" :error="$v.formData.diagnostic.$error"/>
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
                   </div>
                   <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>

                   <div class="row">
                      <div class="col-10">
                          <div class="form-group">
                              <label>Appointment</label>
                              <input type="date" class="form-control form-control-sm" v-model="formData.appointment" style="width:150px">
                          </div>
                      </div>
                      <div class="col-2 text-right" >
                          <v-btn small color="primary" class="mt-4" dark @click="submit" :loading="form_is_submitting">Submit</v-btn>
                      </div>
                  </div>
               </v-card-text>
           </v-card>
           <v-card>
                <v-card-title>Data in the system</v-card-title>
               <v-card-text>
                   <div class="table-responsive">
                       <table class="table table-sm">
                           <tr>
                               <td>Date</td>
                               <td>Diagnostic</td>
                               <td>Description</td>
                               <td>Material</td>
                               <td>User</td>
                           </tr>
                           <tr v-for="row in data_in_system">
                               <td>{{row.created_at}}</td>
                               <td>{{row.diagnostic}}</td>
                               <td>{{row.description}}</td>
                               <td>
                                   <table class="table table-sm">
                                       <tr>
                                           <th>Name</th>
                                           <th>QTY</th>
                                           <th>Unit</th>
                                       </tr>
                                       <tr v-for="r in row.woundcare_materials">
                                           <td>{{ r.material }}</td>
                                           <td>{{ r.qty }}</td>
                                           <td>{{ r.unit}}</td>
                                       </tr>
                                   </table>
                               </td>
                               <td>
                                   {{row.user.name}}-({{row.user.employee_id}})
                               </td>

                           </tr>
                       </table>
                   </div>
               </v-card-text>
           </v-card>
       </div>
   </v-app>
</template>

<script>
import Give_medicine from "../../../components/give_medicine";
import { validationMixin } from "vuelidate";
const {
    required,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "wound_care_form",
    components: {Give_medicine},
    mixins: [validationMixin],
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
                patient_id:'',
                diagnostic:'',
                description:'',
                materials:[],
                medication:[],
                appointment:'',

            },
            temp_row:{
                material:'',
                quantity:'',
                unit:''
            },
            reset_medication_list:false,
            form_is_submitting:false,
            data_in_system:[]
        }
    },
    validations(){
      return {
          formData:{
              diagnostic:{required},
          }
      }
    },
    created(){
        this.formData.admission_id=this.$route.params.admission_id
        this.formData.patient_id=this.$route.params.patient_id
        this.init()
    },
    methods:{
        init(){
            axios.get(`/api/v1/patient_system/woundcare/${this.$route.params.patient_id}`).then(response=>{
                this.data_in_system=response.data
            })
        },
        add_row(){
            if(this.temp_row.quantity !=='' && this.temp_row.unit && this.temp_row.material !==''){
                this.formData.materials.push(this.temp_row)
                this.temp_row={
                    material:'',
                    quantity:'',
                    unit:''
                }
            }
        },
        get_medicines(data){
            this.formData.medication=data
        },
        submit(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                this.formData.user_id = window.auth.user.id
                this.form_is_submitting=true
                axios.post('/api/v1/patient_system/woundcare', this.formData).then(response=>{
                    this.$toast.open({
                        message: `Data submitted`,
                        position: "top-right",
                    });
                    this.form_is_submitting=false
                    this.$router.push({name:'wound_care_list'})
                })

            }
        }
    }
}
</script>

<style scoped>

</style>
