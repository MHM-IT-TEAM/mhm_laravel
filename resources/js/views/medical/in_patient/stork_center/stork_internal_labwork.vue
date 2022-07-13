<template>
    <div class="container">
        <table class="table table-sm">
            <tr>
                <td>ID</td>
                <td>FirstName</td>
                <td>LastName</td>
                <td>Birthdate</td>
                <td>Address</td>
            </tr>
            <tr>
                <td>{{patient.id}}</td>
                <td>{{patient.firstName}}</td>
                <td>{{patient.lastName}}</td>
                <td>{{patient.birthDate}}</td>
                <td>{{patient.adress}}</td>
            </tr>
        </table>
        <internal_lab :form_type="'request'" :admission="admission"/>
    </div>
</template>

<script>
import Internal_lab from "../../labwork/internal/internal_lab";
export default {
    name: "stork_internal_labwork",
    components: {Internal_lab},
    created(){
        this.init()
    },
    data(){
        return{
            admission:'',
            patient:{}
        }
    },
    methods:{
        async init(){
            axios.get(`/api/v1/patient_system/admission/admission/${this.$route.params.stork_admission.admission_id}`).then(response=>{
                this.patient=response.data.patient
                this.admission
            })
        }
    }
}
</script>

<style scoped>

</style>
