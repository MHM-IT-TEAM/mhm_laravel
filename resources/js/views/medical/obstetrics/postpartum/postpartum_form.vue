<template>
<div class="container">
    <v-card>
        <v-card-title>POSTPARTUM</v-card-title>
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
                        <label>Eyes</label>
                        <input type="text" v-model="formData.eyes" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Breast</label>
                        <input type="text" v-model="formData.breast" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Uterus size</label>
                        <input type="text" v-model="formData.uterus_size" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Perineum</label>
                        <input type="text" v-model="formData.perineum" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Legs</label>
                        <input type="text" v-model="formData.legs" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>BP</label>
                        <input type="text" v-model="formData.bp" class="form-control form-control-sm"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Bleeding</label>
                        <input type="text" v-model="formData.bleeding" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Urine</label>
                        <input type="text" v-model="formData.urine" class="form-control form-control-sm"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Kacka</label>
                        <input type="text" v-model="formData.kacka" class="form-control form-control-sm"/>
                    </div>
                </div>
            </div>
            <v-textarea
                label= "woundcare"
                v-model="formData.woundcare"
            ></v-textarea>
            <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
            <v-btn color="primary" @click="submit" small>Submit</v-btn>
            <div class="table-responsive mt-4">
                <h6>Data in the system</h6>
                <table class="table table-sm">
                    <tr>
                        <td>Date</td>
                        <td>Diagnose</td>
                        <td>Eyes</td>
                        <td>Legs</td>
                        <td>bp</td>
                        <td>Perineum</td>
                        <td>Breast size</td>
                        <td>Uterus size</td>
                        <td>Bleeding</td>
                        <td>Urine</td>
                        <td>Kacka</td>
                        <td>Woundcare</td>
                    </tr>
                    <tr v-for="row in data_in_system">
                        <td>{{row.created_at}}</td>
                        <td>{{row.diagnose}}</td>
                        <td>{{row.eyes}}</td>
                        <td>{{row.legs}}</td>
                        <td>{{row.bp}}</td>
                        <td>{{row.perineum}}</td>
                        <td>{{row.breast_size}}</td>
                        <td>{{row.uterus_size}}</td>
                        <td>{{row.bleeding}}</td>
                        <td>{{row.urine}}</td>
                        <td>{{row.kacka}}</td>
                        <td>{{row.woundcare}}</td>
                    </tr>
                </table>
            </div>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    requiredIf,
} = require("vuelidate/lib/validators");
import Give_medicine from "../../../../components/give_medicine";
export default {
    name: "postpartum_form",
    mixins: [validationMixin],
    components: {Give_medicine},
    data(){
        return{
            formData:{
                diagnose:'',
                eyes:'',
                legs:'',
                bp:'',
                perineum:'',
                woundcare:'',
                breast:'',
                uterus_size:'',
                bleeding:'',
                urine:'',
                kacka:'',
                medication:[]
            },
            reset_medication_list:false,
            data_in_system:[]
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
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/postpartum/${this.$route.params.patient_id}`).then(
                response=>{this.data_in_system=response.data}
            )
        },
        submit(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                this.formData.admission_id=this.$route.params.admission_id
                this.formData.patient_id=this.$route.params.patient_id
                axios.post(`/api/v1/patient_system/out_patient/obstetrical/postpartum`,this.formData).then(response=>{
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

</style>
