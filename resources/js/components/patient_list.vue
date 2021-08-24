<template>
   <div>
        <div class="container">
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
                            <v-icon small class="mr-2" @click="$emit('edit', item)">
                                mdi-pencil
                            </v-icon>
                        </template>
                        <template v-slot:item.status="{ item }">
                            <v-chip :color="getColor(item.status)" dark x-small>
                                {{ item.status }}
                            </v-chip>
                        </template>
                    </v-data-table>
                </v-card>
            </v-app>
        </div>
   </div>
</template>

<script>
export default {
    name: "patient_list",
    props:{
        type_consult:'',
        headers: Array
    },
    data(){
        return{
            search: '',
            items: [],
            loading: false
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            this.loading = true;

            let data;
            switch (this.type_consult){
                case 1:
                    data=await axios.get('/api/consultation/today/1')
                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    data=await axios.get('/api/consultation/today/4')
                    break;
                case 5:
                    data=await axios.get('/api/consultation/today/5');
                    break;
                case 6:
                    break;
                case 7:
                    data=await axios.get('/api/obstetrics/baby_vaccination/todayList')
                    break;
                case 8:
                    data=await axios.get('/api/obstetrics/baby_checkup/todayList')
                    break;
                case 9:
                    break;
                case 10:
                    break;
                case 11:
                    break;
            }
            this.loading = false;

            this.consultation_id=data.id
            this.items=data.data
        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else return "green";
        }
    },
}
</script>

<style scoped>

</style>
