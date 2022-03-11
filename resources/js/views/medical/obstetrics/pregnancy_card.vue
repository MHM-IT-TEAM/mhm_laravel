<template>
<div class="container w-75">
    <cpn_admission/>
    <cpn_followup/>
    <ultrasound_exam_crud/>
</div>
</template>

<script>
import Cpn_admission from "./cpn/cpn_admission";
import Cpn_followup from "./cpn/cpn_followup";
import Ultrasound_exam_crud from "./ultrasound_1/ultrasound_exam_crud";


export default {
    name: "pregnancy_card",
    components: {Ultrasound_exam_crud,  Cpn_followup, Cpn_admission}
}
</script>

<style scoped>

</style>
