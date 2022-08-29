<template>
    <div class="container-fluid vh-100">
        <div class="d-inline mb-2">
            List of CPN admission:
            <span class="font-weight-bold"> ({{patient.id}})-{{patient.firstName}} {{patient.lastName}}</span>
        </div>
        <div class="table-responsive mt-2">
            <table class="table">
                <thead>
                <th>Year-month</th>
                <th>CPN Admission ID</th>
                <th>Status</th>
                <th>Action</th>
                </thead>
                <tbody>
                <tr v-for="adm in cpn_admission_list">
                    <td>{{moment(adm.created_at).format("YYYY-MM")}}</td>
                    <td>{{adm.id}}</td>
                    <td>
                        <v-chip
                            class="ma-2"
                            label
                            color="orange"
                            v-if="adm.status==='open'"
                        >
                            {{adm.status}}
                        </v-chip>
                        <v-chip
                            class="ma-2"
                            label
                            color="grey"
                            v-if="adm.status==='closed'"
                        >
                            {{adm.status}}
                        </v-chip>
                    </td>
                    <td>
                        <v-btn x-small @click="process(adm)" :disabled="adm.status==='closed'">View</v-btn>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "delivery_patient_list_of_cpn",
    data(){
        return{
            patient:{},
            cpn_admission_list:[],
            dialog:false,
            process_options:[
                {title:'process'},
                {title:'Close exam'},
                {title:'Delete exam'},
            ]
        }
    },
    created(){
        let patient=this.$route.params.data
        this.patient={
            id:patient.id,
            firstName:patient.firstName,
            lastName:patient.lastName
        }
        this.cpn_admission_list =patient.cpn_admissions

    },
    methods:{
        process(admission){
            this.$router.push({name:'delivery_pregnancy_card',params:{data:admission}})
        },
    }
}
</script>

<style scoped>

</style>
