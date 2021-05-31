<template>
    <div class="container">
        <v-app>
            <v-card class="p-4">
                <v-card-title>
                    List of patient
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="headers" :items="items" :search="search">
                    <template v-slot:item.actions="{ item }">
                        <v-icon small class="mr-2" @click="editItem(item)">
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
</template>

<script>
export default {
    name: "baby_checkup_list",
    data(){
        return{
            search: "",
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "FirstName", value: "patient.firstName" },
                { text: "LastName", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            items: [],
        }
    },
    created(){
        this.init()
    },
    methods:{
        editItem(item) {
            this.$router.push({
                name: "baby_vaccination_card",
                params: {
                    patient_id: item.patient_id,
                    consultation_id: item.id,
                },
            });
        },
        async init() {
            let response = await axios.get("/api/obstetrics/baby_vaccination/todayList");
            this.items = [...response.data];
        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else return "green";
        },
    }
}
</script>

<style scoped>

</style>
