<template>
   <div>
        <div class="container">
            <v-app >
                <v-card class="p-4">
                    <v-row>
                        <v-container>
                            Filter by date
                            <date-picker
                                v-model="today"
                                mode="date"
                                :model-config="dateConfig"
                                :masks="dateConfig.masks"
                                @input="fetch"
                            >
                                <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                        class="bg-white border px-2 py-1 rounded"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                    />
                                </template>
                            </date-picker>
                        </v-container>
                    </v-row>
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
                    <v-card-text>
                        <v-data-table :headers="headers" :items="items" :search="search" :loading="loading">
                            <template v-slot:item.actions="{ item }">
                                <v-icon small class="mr-2" @click="$emit('edit', item)" v-if="item.status!=='DONE'">
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
                    </v-card-text>
                </v-card>
            </v-app>
        </div>
   </div>
</template>

<script>
import moment from "moment";
export default {
    name: "patient_list",
    props:{
        service_id:'',
        service_activity_id:'',
        headers: Array
    },
    data(){
        return{
            search: '',
            items: [],
            loading: false,
            search_date:'',
            dateConfig: {
                type: "string",
                mask: "YYYY-MM-DD",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
            today:moment().format("YYYY/MM/DD")
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            this.loading = true;

            let data = await axios.post(`/api/v1/patient_system/admission/list_service_activity_date`,{service_id:this.service_id,service_activity_id:this.service_activity_id,date:this.today})
            this.loading = false;

            this.consultation_id=data.id
            this.items=data.data
        },
        search_by_date(){

        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
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
