<template>
    <div class="container-fluid">
        <v-app>
            <v-card class="p-4">
                <v-card-title>
                    Laboratory Request
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="headers" :items="filtered_list" :search="search" :loading="loading">
                    <template v-slot:item.actions="{ item }">
                        <v-icon small class="mr-2" @click="$emit('open', item)" v-if="item.lab_work_step_id===3">
                            mdi-eye
                        </v-icon>
                        <v-icon small class="mr-2" @click="process(item)" v-if="item.lab_work_step_id !== 3 && is_admin">
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.lab_work_step.description="{ item }">
                        <v-chip :color="statusColor(item.lab_work_step.id)" dark x-small>
                            {{ item.lab_work_step.description }}
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "internal_lab_list",
    props:['is_admin','service_id'],
    data(){
        return{
            search:'',
            loading:false,
            list:[],
            headers:[
                { text: "Id", value: "admission.patient_id" },
                { text: "First Name", value: "admission.patient.firstName" },
                { text: "Last Name", value: "admission.patient.lastName" },
                { text: "Orderer", value: "orderer" },
                { text: "Status", value: "lab_work_step.description" },
                { text: "Actions", value: "actions", sortable: false },
            ]

        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
                axios.get('/api/v1/patient_system/internal_lab/resource').then(response=>{
                    this.list=response.data
                    this.list.forEach(item=>{
                        item.orderer= item.admission.service.name+"/"+item.admission.service_activity.name
                    })
                })
        },
        process(request){
            this.$router.push({name:'internal_lab_form',params:{request:request}})
        },
        statusColor(status){
            switch (parseInt(status)){
                case 1:
                    return "grey"
                break;
                case 2:
                    return "warning"
                break;
                case 3:
                    return "green"
                break;
            }
        }
    },
    computed:{
        filtered_list(){
            if(this.service_id !=='' && this.service_id !==undefined){
                return this.list.filter(item=>item.admission.service_id===this.service_id)
            }else return this.list
        }
    }
}
</script>

<style scoped>

</style>
