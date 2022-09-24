<template>
<div class="container-fluid">
    <v-app>
       <v-card>
           <v-card-title >
               Baby Checkup ({{$route.params.fullName}})
               <v-speed-dial
                   v-model="speed_dial.fab"
                   :top="true"
                   :right="true"
                   direction="bottom"
                   :open-on-hover="speed_dial.hover"
                   :transition="speed_dial.transition"
               >
                   <template v-slot:activator>
                       <v-btn
                           v-model="speed_dial.fab"
                           color="blue darken-2"
                           dark
                           fab
                       >
                           <v-icon v-if="speed_dial.fab">
                               mdi-close
                           </v-icon>
                           <v-icon v-else >
                               mdi-briefcase-check
                           </v-icon>
                       </v-btn>
                   </template>
                   <v-btn
                       fab
                       dark
                       small
                       color="green"
                       @click="accessory.show_internal_lab=true"
                   >
                       IL
                   </v-btn>
                   <v-btn
                       fab
                       dark
                       small
                       color="purple"
                       @click="accessory.show_additional_consult=true"
                   >
                       AC
                   </v-btn>
               </v-speed-dial>
           </v-card-title>
           <v-row class="p-2">
               <v-col cols="6">
                   <v-row>
                       <v-col>
                           <v-card>
                               <v-simple-table
                                   dense
                                   height="350px"
                               >
                                   <template v-slot:default>
                                       <thead>
                                       <tr>
                                           <th>Date</th>
                                           <th>Weight</th>
                                           <th>Temp</th>
                                           <th>Skin</th>
                                           <th>Umbilic</th>
                                           <th>General impression</th>
                                           <th>Precautions</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <tr v-for="row in baby_checkup_data.baby_checkups" :key="row.id">
                                           <td>{{row.created_at}}</td>
                                           <td>{{row.weight}}</td>
                                           <td>{{row.temp}}</td>
                                           <td>{{row.skin}}</td>
                                           <td>{{row.umbilic}}</td>
                                           <td>{{row.gl_impression}}</td>
                                           <td>{{row.precautions}}</td>
                                       </tr>
                                       </tbody>
                                   </template>
                               </v-simple-table>
                              <button class="btn btn-sm btn-secondary" @click="weight_control">Weight control</button>
                           </v-card>
                       </v-col>
                   </v-row>
                   <v-row>
                       <v-col>
                           <v-card dense>
                               <h6>Checkup Form</h6>
                               <v-form class="p-2" >
                                   <v-row>
                                       <v-col>
                                           <v-text-field
                                               label="weight"
                                               hide-details
                                               v-model="formData.weight"
                                               :error="$v.formData.weight.$error"
                                           >
                                           </v-text-field>
                                       </v-col>
                                       <v-col>
                                           <v-select
                                               label="Skin"
                                               hide-details
                                               v-model="formData.skin"
                                               :items="accessory.skin"
                                               :error="$v.formData.skin.$error"
                                           >

                                           </v-select>
                                       </v-col>
                                       <v-col>
                                           <v-text-field
                                               label="umbilic"
                                               hide-details
                                               v-model="formData.umbilic"
                                               :error="$v.formData.umbilic.$error"
                                           ></v-text-field>
                                       </v-col>
                                   </v-row>
                                   <v-row>
                                       <v-col>
                                           <v-select
                                               label="General impression"
                                               v-model="formData.gl_impression"
                                               :items="accessory.gl_impression"
                                               hide-details
                                               :error="$v.formData.gl_impression.$error"
                                           ></v-select>
                                       </v-col>
                                       <v-col>
                                           <v-text-field label="Temp" hide-details v-model="formData.temp"></v-text-field>
                                       </v-col>
                                   </v-row>
                                   <v-row>
                                       <v-col>
                                           <v-textarea label="remark and precautions" solo hide-details dense v-model="formData.precautions"></v-textarea>
                                       </v-col>
                                   </v-row>
                               </v-form>
                               <v-card-actions  dense>
                                   <v-btn color="primary" right sm @click.prevent=submit>
                                       Submit

                                   </v-btn>
                               </v-card-actions>
                           </v-card>
                       </v-col>
                   </v-row>
               </v-col>
               <v-col cols="6">
                   <v-card>
                       <v-row>
                          <v-col>
                              <weight_overview></weight_overview>
                          </v-col>
                       </v-row>
                       <v-row>
                           <v-col>
                               <give_medicine @get_value="get_medicines" :reset="accessory.reset_medication_list"/>
                           </v-col>
                       </v-row>

                   </v-card>
               </v-col>
           </v-row>

       </v-card>
        <v-dialog
            v-model="accessory.dialog"
            fullscreen
        >
            <v-card>
                <v-card-title class="text-h5">
                   Weight Control ({{$route.params.fullName}})
                </v-card-title>

                <v-card-text>
                    <baby_weight_gain :src_data="table_data"/>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="purple lighten-2"
                        dark
                        @click="accessory.dialog = false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="accessory.show_internal_lab"
        >
            <v-card>

                <v-card-text class="p-2">
                    <internal_lab :form_type="'request'" :admission="$route.params.admission"/>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="accessory.show_additional_consult"
        >
            <v-card>

                <v-card-text class="p-2">
                  <additional_consultation :admission="$route.params.admission"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-app>
</div>
</template>

<script>
import { validationMixin } from "vuelidate";
import weight_overview from "./weight_overview";
import {mapGetters,mapActions} from 'vuex'
import Give_medicine from "../../../../components/give_medicine";
import Baby_weight_gain from "./baby_weight_gain";
import Internal_lab from "../../labwork/internal/internal_lab";
import Additional_consultation from "../../../../components/additional_consultation";
const {
    required,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "baby_checkup",
    components:{Additional_consultation, Internal_lab, Baby_weight_gain, Give_medicine, weight_overview},
    mixins: [validationMixin],
    data(){
        return{
            table_data:[],
            formData:{
                patient_id:'',
                consultation_id:'',
                weight:'',
                skin:'',
                umbilic:'',
                gl_impression:'',
                temp:'',
                precautions:'',
                medication:[]
            },
            defaultData:{
                patient_id:'',
                consultation_id:'',
                weight:'',
                skin:'',
                umbilic:'',
                gl_impression:'',
                temp:'',
                precautions:'',
                medication:[]
            },
            accessory:{
                skin:['Healthy','Yellow','Dry'],
                gl_impression:['Healthy','Weak','Infection sign','In Danger'],
                reset_medication_list:false,
                dialog:false,
                show_internal_lab:false,
                show_additional_consult:false
            },
            speed_dial:{
                direction: 'top',
                fab: false,
                fling: false,
                hover: false,
                tabs: null,
                top: false,
                right: true,
                bottom: true,
                left: false,
                transition: 'slide-y-reverse-transition',
            },
        }
    },
    validations:{
        formData:{
            weight:{required},
            skin:{required},
            umbilic:{required},
            gl_impression:{required},
        }
    },
    created(){
        this.init()
    },
    methods:{
        ...mapActions('baby_checkup',['bootstrap_checkup_data','insert_checkup_data']),
        async init(){
            this.formData.patient_id= this.$route.params.patient_id
            this.formData.admission_id=this.$route.params.admission_id
            await this.bootstrap_checkup_data(this.$route.params.patient_id)
            this.table_data=this.baby_checkup_data
        },
        get_medicines(data){
           this.formData.medication=data
        },
        async submit(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                await this.insert_checkup_data(this.formData)
                await this.bootstrap_checkup_data(this.$route.params.patient_id)
                this.reset()
                this.accessory.reset_medication_list=true
                this.$toast.open({
                    message: 'Data submitted',
                    position: "top-right",
                    type: "success",
                })
            }
            this.$v.$reset()

        },
        reset(){
            this.formData=Object.assign({},this.defaultData)
            this.formData.admission_id=this.$route.params.admission_id
        },
        async weight_control(){
            await this.init()
            this.accessory.dialog=true
        }
    },
    computed:{
        ...mapGetters('baby_checkup',['baby_checkup_data']),
    }
}
</script>

<style scoped>
.v-speed-dial {
    position: absolute;
}

.v-btn--floating {
    position: relative;
}
</style>
