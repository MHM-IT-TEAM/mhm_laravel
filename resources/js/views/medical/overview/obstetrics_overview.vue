<template>
<div class="container-fluid">
    <cpn_admission :is_overview="true" :reference="cpn_ref"  class="cpn"></cpn_admission>
    <div>
        <Cpn_followup :is_overview="true" :cpn_ref="cpn_ref" class="cpn_followup"></Cpn_followup>
    </div>
    <div  class="ultrasound_container">
        <ultrasound_form class="ultrasound" :is_overview="true" :ultrasound_ref="ultrasound_ref" ></ultrasound_form>
    </div>
</div>
</template>

<script>
import Cpn_admission from "../obstetrics/cpn/cpn_admission";
import Ultrasound_form from "../obstetrics/ultrasound/ultrasound_form";
import Cpn_followup from "../obstetrics/cpn/cpn_followup";
export default {
    name: "obstetrics_overview",
    components: {Cpn_followup, Ultrasound_form, Cpn_admission},
    data(){
        return{
            patient_id:'',
            cpn_ref:'',
            ultrasound_ref:''
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            this.cpn_ref= this.$route.params.cpn_ref
            this.ultrasound_ref= this.$route.params.ultrasound_ref
        }
    }
}
</script>

<style scoped>
.ultrasound_container, .cpn,.cpn_followup{
    zoom: 0.8
}
.cpn_followup  {
   max-height: 300px;
}

</style>
