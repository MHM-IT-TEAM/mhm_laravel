<template>
    <div class="container-fluid vh-100">
        <v-card>
            <v-card-title>
                List of Obstetrical patients
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="formData.query"
                    append-icon="mdi-magnify"
                    @keyup="searchPatient"
                    label="Search the patient here"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-card-text>
                <v-data-table :headers="headers" :items="items"  :loading="loading">
                    <template v-slot:item.actions="{ item }">
                        <v-icon small class="mr-2" @click="process(item)" v-if="item.cpn_admissions.length>0">
                            mdi-pencil
                        </v-icon>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "patient_cpn_search",
    data(){
        return{
            formData:{
                query:''
            },
            headers:[
                { text: "Id", value: "id" },
                { text: "First Name", value: "firstName" },
                { text: "Last Name", value: "lastName" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            loading:false,
            items:[]
        }
    },
    methods:{
        searchPatient(e){
            e.preventDefault();
            clearTimeout(this.timeout);
            let self = this;
            this.loading = true;
            this.timeout = setTimeout(function () {
                self.formData.query.length > 0 ? self.fetchPatients(self.formData.query) : "";
            }, 1000);
        },
        fetchPatients(){
            axios.post("/api/v1/patient_system/out_patient/obstetrical/cpn/patient_cpn_search",this.formData).then(response=>{
                this.items=response.data
                if (this.items.length>0 || this.items.length===0) this.loading=false
            })
        },
        process(patient){
            this.$router.push({
                name: "patient_list_of_cpn",
                params: {data:patient}
            })
        }
    }
}
</script>

<style scoped>

</style>
