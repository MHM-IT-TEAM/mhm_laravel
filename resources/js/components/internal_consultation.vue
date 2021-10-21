<template>
    <div class="mt-2">
        <p class="table-title pl-6">D.1. Internal Consultation</p>
        <div class="card">
            <div class="card-body" v-if="!accessory.data_submitted">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Choose which service are you calling<span class="text-danger">*</span></label>
                            <select class="form-control" :class="{'form-control is-invalid':$v.formData.internal_consultation_type_id.$error}" v-model="formData.internal_consultation_type_id">
                                <option v-for="service in accessory.services" :value="service.id">{{service.name}}</option>
                            </select>
                            <div class="invalid-feedback" v-if="$v.formData.internal_consultation_type_id.$error">
                                You must choose one service !
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Write here the reason for your request<span class="text-danger">*</span></label>
                            <textarea class="form-control" :class="{'form-control is-invalid':$v.formData.reason.$error}" v-model="formData.reason"></textarea>
                            <div class="invalid-feedback" v-if="$v.formData.reason.$error">
                                You must explain your request!
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-sm submit" @click="submit">Submit</button>
                </div>
            </div>
           <transition name="fade">
               <div class="card-body" v-if="accessory.data_submitted">
                   <v-row justify="center">
                       <h3>Data submitted</h3>
                   </v-row>
                   <v-row justify="center">
                       <v-icon color="success" large> mdi-check-circle</v-icon>
                   </v-row>
               </div>
           </transition>

        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "internal_consultation",
    props:['admission'],
    mixins: [validationMixin],
    data(){
        return{
            admission_id:'',
            formData:{
                reason:'',
                internal_consultation_type_id:'',
            },
            accessory:{
               services:[],
                data_submitted:false
            }
        }
    },
    validations:{
        formData:{
            internal_consultation_type_id:{required},
            reason:{required}
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            axios.get('/api/v1/patient_system/internal_consultation_types').then(response=>this.accessory.services= response.data)
        },

        submit(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                return true;
            }
            this.formData.admission_id=this.admission.id
            axios.post('/api/v1/patient_system/internal_consultation',this.formData).then(response=>{
                this.accessory.data_submitted= !!response.data.success
            })
        }
    }

}
</script>

<style scoped>
.table-title{
    background-color: #1390C6;
    color:white;
    font-size: 14px !important;
    font-weight:bold;
}
.submit{
    background-color: #e47911;
    position: relative;
    color: white;
    width: 55px;
    height: 30px;
    text-align: center !important;
    vertical-align: middle !important;
    padding: 0;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
