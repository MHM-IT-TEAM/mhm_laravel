<template>
<div>
    <Cpn_admission :is_overView="true"></Cpn_admission>
    <ultrasound_form></ultrasound_form>
</div>
</template>

<script>
import Cpn_admission from "../../../../resources/js/views/medical/obstetrics/cpn/cpn_admission";
import Ultrasound_form from "../../../../resources/js/views/medical/obstetrics/ultrasound/ultrasound_form";
export default {
    name: "overview",
    components: {Ultrasound_form, Cpn_admission},
    data(){
        return{

        }
    }
}
</script>

<style scoped>

</style>
