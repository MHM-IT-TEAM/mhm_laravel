<template>
    <div class="container">
        <h2>External referral book</h2>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
        ></v-text-field>
        <v-data-table
            :headers="headers"
            :items="list"
            :items-per-page="30"
            class="elevation-1 mt-2"
            :search="search"
        ></v-data-table>
    </div>
</template>

<script>
export default {
    name: "external_referral_book",
    data(){
        return{
            search:'',
            list:[],
            headers:[
                {
                    text: 'Date',
                    align: 'start',
                    sortable: false,
                    value: 'departure_date',
                },
                {
                    text:'Patient Id',
                    value:'admission.patient_id'
                },
                {
                    text:'FirstName',
                    value:'admission.patient.firstName'
                },
                {
                    text:'FirstName',
                    value:'admission.patient.lastName'
                },
                {
                    text:'Date of birth',
                    value:'admission.patient.birthDate'
                },
                {
                    text:'Address',
                    value:'admission.patient.adress'
                },
                {
                    text:'Category',
                    value:'category'
                },
                {
                    text:'Reason',
                    value:'reason'
                },
                {
                    text:'Patient Condition',
                    value:'patient_condition'
                },
                {
                    text:'Referred to',
                    value:'medical_center.name'
                }
            ]
        }
    },
    created(){
        this.load_data()
    },
    methods:{
       load_data(){
           axios.get('/api/v1/patient_system/external_referral').then(response=>{this.list=response.data})
       }
    }
}
</script>

<style scoped>

</style>
