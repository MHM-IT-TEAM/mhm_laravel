<template>
    <div class="container">
        <h2 class="title">IN PATIENT BOOK</h2>
        <div class="table-responsive">
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            <v-data-table
                class="mt-6 table"
                :headers="headers"
                :items="list"
                :search="search"
                height="90vh"
                multi-sort
            >
<!--                <template v-slot:item.id="{ item }">-->
<!--                    <v-btn-->
<!--                       @click="overview"-->
<!--                        dark-->
<!--                       text-->
<!--                       color="purple"-->
<!--                    >-->
<!--                        {{ item.id}}-->
<!--                    </v-btn>-->
<!--                </template>-->

            </v-data-table>
        </div>
    </div>
</template>

<script>
export default {
    name: "in_patient_book",
    data(){
        return{
            search:'',
            list:[],
            headers:[
                { text: 'Ref', value: 'id' },
                { text: 'Date of admission', value: 'admission_date' },
                { text: 'Time of admission', value: 'admission_time' },
                { text: 'Patient Id', value: 'patient_id' },
                { text: 'FirstName', value: 'patient.firstName' },
                { text: 'LastName', value: 'patient.lastName' },
                { text: 'Service', value: 'service.name' },
                { text: 'Level of care', value: 'level_of_care' },
                { text: 'Admission diagnosis', value: 'admission_diagnosis' },
                { text: 'Date of dismissal', value: 'stork_dismissal.dismissal_date' },

            ]
        }

    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/patient_system/in_patient/stork/in_patient_book').then(response=>{
                this.list=response.data
            })
        },
        overview(){

        },
        check_ga(val){
            if(val){
                if(parseInt(val.substring(0,2))<=36) return 'text-danger'
                if(parseInt(val.substring(0,2))<=37) return 'text-warning'
            }
        },
        check_weight(val){
            if(val<2500) return 'orange'
            if(val<2000) return 'red'
            return 'grey'
        }
    },
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
</style>
