<template>
    <div class="container">
        <div class="table-responsive">
            <table class="table-sm table">
                <tr>
                    <td>
                        <select class="form-control" v-model="formData.stork_action_group_id">
                            <option value="">Chose the action you want to perform</option>
                            <option v-for="action in filtered_actions" :value="action.id">{{action.description}}</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Value/Remark" v-model="formData.value"/>
                    </td>
                    <td>
                        <v-btn @click="submit" color="indigo" dark>Submit</v-btn>
                    </td>
                </tr>
            </table>
        </div>
        <h4>Data in the system</h4>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
        ></v-text-field>
        <v-data-table
            :headers="headers"
            :items="data_in_system"
            :items-per-page="30"
            class="elevation-1 mt-2"
            :search="search"
        ></v-data-table>
    </div>
</template>

<script>
export default {
    name: "stork_actions_form",
    props:['action_type','stork_admission_id'],
    created(){
        this.init()
        this.load_data_in_system()
    },
    data(){
        return{
            raw_result:[],
            data_in_system:[],
            formData:{
                stork_admission_id:'',
                stork_action_group_id:'',
                value:'',
                remark:''
            },
            search:'',
            headers:[
                {
                    text: 'Date',
                    align: 'start',
                    sortable: false,
                    value: 'created_at',
                },
                {
                    text:'Actions',
                    value:'stork_action_group.description'
                },
                {
                    text:'Value/remark',
                    value:'value'
                },
            ]
        }
    },
    methods:{
        init(){
            axios.get('/api/v1/extra/stork_action_group').then(response=>this.raw_result=response.data)
        },
        load_data_in_system(){
            axios.get(`/api/v1/patient_system/in_patient/stork/show_action/${this.stork_admission_id}/${this.action_type}`).then(response=>{

               response.data.forEach(data=>{
                   if(data.stork_action_group){
                       this.data_in_system.push(data)
                   }
               })


            })
        },
        submit(){
            if(this.formData.stork_action_group_id!==''){
                this.formData.stork_admission_id= this.stork_admission_id
                axios.post('/api/v1/patient_system/in_patient/stork/store_action',this.formData).then(response=>{
                    if(response.data.success){
                        this.formData={
                            stork_admission_id:'',
                            stork_action_group_id:'',
                            value:'',
                            remark:''
                        }
                        this.load_data_in_system()
                    }
                })
            }
        }
    },
    computed:{
        filtered_actions(){
            return this.raw_result.filter(result=>result.type===this.action_type)
        }
    }
}
</script>

<style scoped>

</style>
