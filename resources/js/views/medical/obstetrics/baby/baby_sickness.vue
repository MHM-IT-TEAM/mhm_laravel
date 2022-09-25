<template>
    <div class="container">
        <v-card>
            <v-card-title>
                Sickness Form
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
                        @click="show_internal_lab=true"
                    >
                        IL
                    </v-btn>
                    <v-btn
                        fab
                        dark
                        small
                        color="purple"
                        @click="show_additional_consult=true"
                    >
                        AC
                    </v-btn>
                </v-speed-dial>
            </v-card-title>
            <v-card-text>
                <h6>{{$route.params.fullName}}</h6>
                <v-textarea
                label= "diagnose"
                v-model="formData.diagnose"
                :error="$v.formData.diagnose.$error"
                ></v-textarea>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Weight</label>
                            <input type="number" v-model="formData.weight" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Temp</label>
                            <input type="number" v-model="formData.temp" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>SPO2</label>
                            <input type="number" v-model="formData.spo2" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Lungs</label>
                            <input type="number" v-model="formData.lungs" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Pulse</label>
                            <input type="number" v-model="formData.pulse" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Intake</label>
                            <input type="string" v-model="formData.intake" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Pipi</label>
                            <input type="string" v-model="formData.pipi" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Kacka</label>
                            <input type="string" v-model="formData.kacka" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Fontanelle</label>
                            <input type="string" v-model="formData.fontanelle" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
                <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
                <v-btn color="primary" @click="submit" small>Submit</v-btn>
                <div class="table-responsive mt-4">
                    <h6>Data in the system</h6>
                    <table class="table table-sm">
                        <tr>
                            <td>Date</td>
                            <td>Diagnose</td>
                            <td>temp</td>
                            <td>spo2</td>
                            <td>Lungs</td>
                            <td>Pulse</td>
                            <td>Intake</td>
                            <td>Pipi</td>
                            <td>Kacka</td>
                            <td>Fontanelle</td>
                        </tr>
                        <tr v-for="row in data_in_system">
                            <td>{{row.created_at}}</td>
                            <td>{{row.diagnose}}</td>
                            <td>{{row.temp}}</td>
                            <td>{{row.spo2}}</td>
                            <td>{{row.lungs}}</td>
                            <td>{{row.pulse}}</td>
                            <td>{{row.intake}}</td>
                            <td>{{row.pipi}}</td>
                            <td>{{row.kacka}}</td>
                            <td>{{row.fontanelle}}</td>
                        </tr>
                    </table>
                </div>

            </v-card-text>
        </v-card>
        <v-dialog
            v-model="show_internal_lab"
        >
            <v-card>

                <v-card-text class="p-2">
                    <internal_lab :form_type="'request'" :admission="$route.params.admission"/>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="show_additional_consult"
        >
            <v-card>

                <v-card-text class="p-2">
                    <additional_consultation :admission="$route.params.admission"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import Give_medicine from "../../../../components/give_medicine";
import Internal_lab from "../../labwork/internal/internal_lab";
import Additional_consultation from "../../../../components/additional_consultation";
const {
    required,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "baby_sickness",
    mixins: [validationMixin],
    components: {Additional_consultation, Internal_lab, Give_medicine},
    data(){
        return{
            formData:{
                diagnose:'',
                weight:'',
                temp:'',
                spo2:'',
                lungs:'',
                pulse:'',
                intake:'',
                pipi:'',
                kacka:'',
                fontanelle:'',
                medication:[]
            },
            reset_medication_list:false,
            data_in_system:[],
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
            show_internal_lab:false,
            show_additional_consult:false,
        }
    },
    validations:{
        formData:{
            diagnose:{required},
        }
    },
    created(){
        this.get_data()
    },
    methods:{
        get_medicines(data){
            this.formData.medication=data
        },
        get_data(){
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/baby/sickness/${this.$route.params.patient_id}`).then(
                response=>{this.data_in_system=response.data}
            )
        },
        submit(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                this.formData.admission_id=this.$route.params.admission_id
                this.formData.patient_id=this.$route.params.patient_id
                axios.post(`/api/v1/patient_system/out_patient/obstetrical/baby/sickness`,this.formData).then(response=>{
                    this.$toast.open({
                        message:'data saved',
                        type:'success',
                        position:'top-right'
                    })
                    this.$router.push({name:'baby_sickness_list'})
                })
            }
        }
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
