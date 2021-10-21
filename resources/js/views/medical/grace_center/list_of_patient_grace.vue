<template>
    <div class="container w-75">
        <v-app >
            <v-card class="p-4">
                <v-card-title>
                    Patients
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="headers" :items="items" :search="search" :loading="loading">
                    <template v-slot:item.actions="{ item }">
                        <v-icon small class="mr-2" @click="process(item)">
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.status="{ item }">
                        <v-chip :color="getColor(item.status)" dark x-small>
                            {{ item.status }}
                        </v-chip>
                    </template>
                    <template v-slot:item.admission_type.code="{ item }">
                        <v-chip :color="getTypeColor(item.admission_type.code)" dark x-small>
                            {{ item.admission_type.code }}
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "list_of_patient_grace",
    data(){
        return{
            search: '',
            items: [],
            loading: false,
            headers:[
                { text: "Id", value: "admission.patient.id" },
                { text: "First Name", value: "admission.patient.firstName" },
                { text: "Last Name", value: "admission.patient.lastName" },
                { text: "Service", value: "service" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ]

        }
    },
    created(){
        this.init()
    },
    methods:{
        async init() {
            this.loading = true;
            await axios.get('/api/v1/patient_system/grace_center/patient_list').then(response =>{
                this.items = response.data
                this.items.forEach(item=>{
                    item.status=item.done===1?'GIVEN':'WAITING'
                    item.service= item.admission.service.name+"/"+item.admission.service_activity.name
                })
            })
            this.loading = false;
        },
        process(item){
            this.$router.push({name:'grace_give_medicine',params:{transaction:item}})
        },
        getColor(status) {
            if (status === "WAITING") return "blue";
            else if (status === "GIVEN") return "green";
            else return "green";
        },
        getTypeColor(code) {
            if (code === "A") return "yellow";
            else if (code === "IR") return "orange";
            else return "purple";
        }
    },
}
</script>

<style scoped>

</style>
