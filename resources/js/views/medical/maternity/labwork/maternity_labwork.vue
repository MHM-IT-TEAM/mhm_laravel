<template>
    <div class="content">
        <laboratory_request></laboratory_request>
    </div>
</template>

<script>
import Laboratory_request from "../../laboratory/laboratory_request";
export default {
    name: "maternity_labwork",
    components: {Laboratory_request}
}
</script>

<style scoped>
    .content{
        margin-left:25%;
    }
    @media print{
        .content{
            margin-left:0;
        }
    }
</style>
