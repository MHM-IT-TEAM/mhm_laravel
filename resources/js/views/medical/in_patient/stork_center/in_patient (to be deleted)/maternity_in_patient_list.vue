<template>
  <div class="container">
    <v-app>
        <v-card class="h-100 wrapper">
            <v-card-title>
                List of In Patient
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details

                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="list"
                :search="search"
                class="dataTable"
            >
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                </template>

            </v-data-table>
        </v-card>
    </v-app>
  </div>
</template>

<script>
export default {
    name: "maternity_in_patient_list",
    data(){
        return{
            search:'',
            list:[],
            headers:[
                {text:'Admission Id',value:'code'},
                {text:'Patient Id',value:'patient.id'},
                {text:'Firstname',value:'patient.firstName'},
                {text:'Lastname',value:'patient.lastName'},
                {text:'Diagnose',value:'provisional_diagnosis'},
                {text:'Division',value:'hospital_service_division.name'},
                {text:'Bed',value:'bed.code'},
                {text:'action',value:'actions',sortable:false}
            ]
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/maternity/maternity_admission').then(response=>{
                this.list=response.data
            })
        },
        editItem(item){
            this.$router.push({name:'in_patient_data_entry',params:{id:item.id}})
        }
    },
    computed:{
        new_code(){

        }
    }
}
</script>

<style scoped>
.wrapper{
    width: 100vw;
    padding: 40px;
}
.dataTable{
    width: 80%;
}

</style>
