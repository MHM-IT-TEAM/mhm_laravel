<template>
<div class="container w-75 border">
    <cpn_admission :is_overview="true" :reference="cpn_admission_id"/>
    <cpn_followup :is_overview="true" :cpn_admission_id="cpn_admission_id"/>
    <div class="m-4">
        ULTRASOUND
    </div>
    <ultrasound_exam_crud :is_overview="true" :ultrasound_admission_id="ultrasound_admission_id"/>
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
        init(){
            let data=this.$route.params.data
            if(data !==undefined){
                this.cpn_admission_id=data.id
                this.ultrasound_admission_id=data.ultrasound_admission_id

            }
        }
    }
}
</script>

<style scoped>

</style>
