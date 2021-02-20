<template>
<div class="container-fluid mt-4">
    <form>
        <input type="text"  name="searchBAr" class="form-control" v-model="query" @keyup="runSearch" placeholder="type your search here"/>
    </form>
    <v-divider></v-divider>
<patient-data :data="patients"></patient-data>

</div>

</template>

<script>
    import patientData from "./patientData";
    import {mapGetters,mapActions} from 'vuex'
    export default {
        name: "patientSearch",
        components:{patientData},
        data(){
            return {
                query:null,
                result:null
            }
        },
        methods:{
            ...mapActions('patient',['fetchPatients']),
            async runSearch(){
                let response= await this.fetchPatients(this.query)
            },
        },
        computed:{
            ...mapGetters('patient',['patients']),
            get: function(){
                return this.patients
            }
        }
    }
</script>

<style scoped>

</style>
