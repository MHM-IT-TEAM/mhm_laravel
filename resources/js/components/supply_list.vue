<template>
    <div class="container">
        <v-app>
            <v-card class="p-4">
                <v-card-title>
                    List of supply Orders
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
                        <v-icon small class="mr-2" @click="process(item)">
                            mdi-eye
                        </v-icon>
<!--                        <v-icon small class="mr-2" @click="process(item)" v-if="item.status !== 3">-->
<!--                            mdi-pencil-->
<!--                        </v-icon>-->
                    </template>
                    <template v-slot:item.status="{ item }">
                        <v-chip :color="statusColor(item.status)" dark x-small>
                            {{ item.status }}
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card>
            <v-dialog
                v-model="dialog"
               max-width="500px"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Order N-{{item.code}}
                    </v-card-title>

                    <v-card-text>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless" id="out_details">
                                <thead>
                                <th colspan="2">Item</th>
                                <th>Quantity</th>
                                </thead>
                                <tbody>
                                <tr v-for="(line,i) in item.out_details" v-if="item.out_details.length>0">
                                    <td colspan="2">
                                        [ &nbsp {{line.item.code}} &nbsp] {{line.item.description}}
                                    </td>
                                    <td>
                                        {{line.quantity}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="dialog = false"
                        >
                            Close
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "supply_list",
    props:['orderer_id','headers'],
    data(){
        return{
            search:'',
            loading:false,
            list:[],
            dialog:false,
            item:{
                out_details:''
            }
            // headers:[
            //     { text: "Id", value: "admission.patient_id" },
            //     { text: "First Name", value: "admission.patient.firstName" },
            //     { text: "Last Name", value: "admission.patient.lastName" },
            //     { text: "Orderer", value: "orderer" },
            //     { text: "Status", value: "lab_work_step.description" },
            //     { text: "Actions", value: "actions", sortable: false },
            // ]

        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            axios.get(`/api/v1/inventory_system/out/show_by_service_id/${this.orderer_id}`).then(response=>{
                this.list=response.data
                this.list.forEach(item=>{
                    item.status= item.status===1?'Waiting':'Delivered'
                })
            })
        },
        process(request){
            // this.$router.push({name:'stork_order',params:{data:request}})
            axios.get(`/api/v1/inventory_system/out/${request.id}`).then(response=>{
                this.item=response.data
            })
            this.dialog=true
        },
        statusColor(status){
            switch(status) {
                case 'Waiting':
                    return "grey"
                    break;
                case 'Delivered':
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
