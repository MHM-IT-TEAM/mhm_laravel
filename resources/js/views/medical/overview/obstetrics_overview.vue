<template>
    <div class="container-fluid" >
        <div>
            <cpn_admission :is_overview="true" :reference="cpn_ref"  class="cpn"></cpn_admission>
        </div>
        <div>
            <Cpn_followup :is_overview="true" :cpn_ref="cpn_ref" class="cpn_followup"></Cpn_followup>
        </div>
        <div class="ultrasound_container">
            <ultrasound_form v-if="ultrasound_ref" class="ultrasound" :is_overview="true" :ultrasound_ref="ultrasound_ref" ></ultrasound_form>
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
            cpn_ref:'',
            ultrasound_ref:''
        }
    },
    async created(){
        await this.init();
    },
    methods:{
        async init(){
            this.cpn_ref= this.$route.params.cpn_ref;

            await axios.get(`/api/v1/patient_system/out_patient/obstetrical/overview/ultrasoundIdFromCpnAdmissionId/${this.cpn_ref}`)
                .then(result =>
                {
                    this.ultrasound_ref = result.data;
                });
        }
    }
}
</script>

<style scoped>
.ultrasound_container, .cpn,.cpn_followup{
    zoom: 0.8
}
</style>
<style>
.v-application--wrap {
    min-height: initial !important;
}
</style>
