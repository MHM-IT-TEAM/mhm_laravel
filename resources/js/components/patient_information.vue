<template>
    <div>
        <table class="table table-sm ">
            <tr>
                <th class="table-title" colspan="3"><v-icon class="text-white">mdi-account-circle</v-icon> &nbsp A) Personal information </th>
            </tr>
            <tr>
                <th style="width:20%"><span class="text-danger">*</span>Id</th>
                <th style="width:40%">First name</th>
                <th style="width:40%">Last name</th>
            </tr>
            <tr>
                <td>
                    {{patient.id}}
                </td>
                <td class="required">
                    {{patient.firstName}}
                </td>
                <td class="required">
                    {{patient.lastName}}
                </td>
            </tr>
            <tr>
                <th>Date of birth</th>
                <th>Address</th>
                <th>Tel</th>
            </tr>
            <tr>
                <td class="required">
                    {{moment(patient.birthDate).format("DD/MMM/YYYY")}}
                </td>
                <td class="required">
                    {{patient.adress}}
                </td>
                <td class="required">
                    {{patient.tel}}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import moment from "moment"
export default {
    props:['patient_id'],
    name: "patient_information",
    data(){
        return{
          patient:{}
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get(`/api/v1/patient_system/patient/patient/${this.patient_id}`).then(response=>{
                this.patient=response.data
            })
        }
    }
}
</script>

<style scoped>
.table-title{
    background-color: #1390C6;
    color:white;
}
</style>
