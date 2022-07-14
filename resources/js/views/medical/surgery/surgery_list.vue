<template>
    <div class="container">
       <v-card>
           <v-card-title>
               LIST OF CONFIRMED SURGERY
               <v-btn class=" ml-2 float-right" @click="export_data">
                   <v-icon class="text-success">mdi-file-excel</v-icon>
               </v-btn>
           </v-card-title>
           <v-card-text>
               <v-row>
                   <v-container>
                       Filter by date
                       <date-picker
                           v-model="today"
                           mode="date"
                           :model-config="dateConfig"
                           :masks="dateConfig.masks"
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
               <v-text-field
                   v-model="search"
                   append-icon="mdi-magnify"
                   label="Search"
                   single-line
                   hide-details
               ></v-text-field>
               <v-data-table :headers="headers" :items="filtered_list" :search="search" :loading="loading">
                   <template v-slot:item.actions="{ item }">
<!--                       <v-icon small class="mr-2" @click="show_modal( item)" v-if="item.status!=='DONE'">-->
<!--                           mdi-pencil-->
<!--                       </v-icon>-->
                       <div class="dropdown">
                           <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Option
                           </button>
                           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                               <a class="dropdown-item" href="#" @click="process(item)" v-if="item.status==='CONFIRMED'">Process</a>
                               <a class="dropdown-item" href="#" @click="edit(item)" v-if="item.status!=='CONFIRMED'">Edit</a>
                           </div>
                       </div>
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
    </div>
</template>

<script>
import Patient_list from "../../../components/patient_list";
import moment from "moment";
export default {
    name: "surgery_list",
    components: {Patient_list},
    data(){
        return{
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "admission.patient.firstName" },
                { text: "Last Name", value: "admission.patient.lastName" },
                { text:"Diagnostic", value: "reason_for_surgery" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            list:[],
            search:'',
            loading:false,
            today:moment().format("YYYY/MM/DD"),
            search_date:'',
            dateConfig: {
                type: "string",
                mask: "YYYY-MM-DD",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            axios.get('/api/v1/patient_system/surgery/resource').then(r=>this.list=r.data)
        },

        process(item) {
            this.$router.push({
                name: "surgery_form",
                params: {
                    surgery:item
                },
            });
        },
        edit(item){
            this.$router.push(`/surgery/form/${item.id}`);
        },
        getColor(status) {
            if (status === "CONFIRMED") return "blue";
            else if (status === "DONE") return "green";
            else return "green";
        },
        getTypeColor(code) {
            if (code === "A") return "yellow";
            else if (code === "IR") return "orange";
            else return "purple";
        },
        export_data(){
            window.location.href='/surgery/export'
        }
    },
    computed:{
        filtered_list(){
            return this.list.filter(l=>moment(l.created_at).isSame(moment(this.today),'date'))
        }
    }
}
</script>

<style scoped>

</style>
