<template>
    <div class="container">
        <internal_lab_list :is_admin="true" @open="open_request"/>
    </div>
</template>

<script>
import Internal_lab_list from "../labwork/internal/internal_lab_list";
export default {
    name: "labwork_list",
    components: {Internal_lab_list},
    // props:['headers'],
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
        open_request(request){
            this.$router.push({name:'nurse_view_internal_lab_result',params:{request:request}})
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
    }
}
</script>

<style scoped>

</style>
