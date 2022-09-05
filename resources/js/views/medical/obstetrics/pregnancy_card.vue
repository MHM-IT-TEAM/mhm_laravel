<template>
<div class="container-sm border">
    <cpn_admission :is_overview="true" :reference="cpn_admission_id"/>
    <cpn_followup :is_overview="true" :cpn_admission_id="cpn_admission_id"/>
    <div class="m-4">
        ULTRASOUND
    </div>
    <ultrasound_exam_crud :is_overview="true" :ultrasound_admission_id="ultrasound_admission_id" v-if="ultrasound_admission_id!==''"/>
</div>
</template>

<script>
import Cpn_admission from "./cpn/cpn_admission";
import Cpn_followup from "./cpn/cpn_followup";
import Ultrasound_exam_crud from "./ultrasound_1/ultrasound_exam_crud";


export default {
    name: "pregnancy_card",
    components: {Ultrasound_exam_crud,  Cpn_followup, Cpn_admission},
    data(){
        return{
            cpn_admission_id:'',
            ultrasound_admission_id:''
        }
    },
    created(){
        this.init()
    },
    methods:{
       async init(){
            let data=this.$route.params.data
            if(data !==undefined){
                this.cpn_admission_id=data.id
            }
           axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/patient/${this.$route.params.data.patient_id}`).then(response=>{
               this.ultrasound_admission_id= response.data
           })
        },
    }
}
</script>

<style scoped>

</style>
