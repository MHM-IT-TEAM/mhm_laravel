<template>
<div class="container-fluid w-75">
    <h1 class="title">MILK PROGRAM ADMISSION</h1>
        <patient_information :patient_id="formData.patient_id"/>
    <h6 class="table-title">B) Medical data</h6>
        <div class="form-inline">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" v-model="formData.mom_is_patient">
                <label class="form-check-label" >Is the mom our Patient?</label>
            </div>
            <div class="form-group">
                <input class="form-control form-control-sm ml-2"
                       placeholder="ID of the mom"
                       :class="{'is-invalid':$v.formData.mom_id.$error}"
                       v-model="formData.mom_id"
                       v-if="formData.mom_is_patient"
                />
                <div class="invalid-feedback" v-if="$v.formData.mom_id.$error">
                    You must add a write the Id of the mom
                </div>
            </div>
            <div class="form-group ml-2">
                <input type="checkbox" class="form-check-input" v-model="formData.mhm_baby">
                <label class="form-check-label" >Is the baby born here?</label>
            </div>
        </div>
    <div class="form-group">
        <label>Story</label>
        <textarea
            class="form-control form-control-sm"
            :class="{'is-invalid':$v.formData.story.$error}"
            rows="7"
            v-model="formData.story"
        >

        </textarea>
        <div class="invalid-feedback" v-if="$v.formData.story.$error">
            You must add a story to continue !
        </div>
    </div>
    <button
        class="btn btn-primary mt-12 float-right d-print-none"
        @click="submit"
    >
        Submit
    </button>
</div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import { validationMixin } from "vuelidate";
const {
    required,
    minValue,
    minLength,
    email,
    url,
    maxLength,
    between,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "baby_milk_pro_admission",
    components: {Patient_information},
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                story:'',
                mom_is_patient:false,
                mom_id:'',
                mhm_baby:false,
                admission_id:'',
                patient_id:''
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            if(this.$route.params.patient_id){
                this.formData.patient_id=this.$route.params.patient_id
                this.formData.admission_id=this.$route.params.admission_id
            }
        },
        submit(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                axios.post("/api/v1/patient_system/out_patient/obstetrical/milkPro/main",this.formData).then(
                    response=>{
                        if(response.data){
                            this.$toast.open({
                                message: `Milk Program Admission Id: ${response.data.id} `,
                                position: "top-right",
                            });
                            this.$router.push({
                                name: "milk_pro_followup",
                                params: {
                                    patient_id: response.data.patient_id,
                                    milk_pro_admission:response.data
                                },
                            });
                        }
                    }
                )
            }
        }
    },
    validations:{
        formData:{
            story:{required},
            mom_id: {
                required:requiredIf((formData)=>formData.mom_is_patient===true)
            }
        }
    }
}
</script>

<style scoped>
.table-title{
    background-color: #1390C6;
    color:white;
}
.title{
    color:#1390C6;
    font-weight: bold;
}
</style>
