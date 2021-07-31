<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control form-control-sm" v-model="new_data.action_date"/>
                </div>
            </div>
            <div class="col">
                <label>Time</label>
                <input type="time" class="form-control form-control-sm" v-model="new_data.action_time"/>
            </div>
            <div class="col">
                <label>Actions</label>
                <select class="form-control form-control-sm" v-model="new_data.maternity_action_list_id" >
                    <option v-for="action in actions" :value="action.id">{{action.description}}</option>
                </select>
            </div>
            <div class="col">
                <label>Value</label>
                <input type="text" class="form-control form-control-sm" v-model="new_data.value" @keydown.enter.prevent="add_data"/>
            </div>
        </div>
        <v-data-table
            :headers="headers"
            :items="list"
            sort-by="action_date"
            :sort-desc=true
            class="elevation-1"
            dense
        ></v-data-table>
    </div>
</template>

<script>
export default {
    name: "in_actions",
    props:['maternity_admission_id'],
    data(){
        return {
            new_data:{action_date:'',action_time:'',maternity_action_list_id:''},
            headers:[
                {text:'date',value:'action_date'},
                {text:'time',value:'action_time'},
                {text:'actions',value:'maternity_action_list.description'},
                {text:'value',value:'value'},
                {text:'responsible',value:'responsible'},
            ],
            list:[],
            actions:[
            ]
        }
    },
    created(){
        this.init()
        this.bootstrap_list()
    },
    methods:{
        async add_data(){
            if(this.new_data.date !=='' && this.new_data.time !=='' && this.new_data.action !==''){
                this.new_data.maternity_admission_id= this.maternity_admission_id
                this.new_data.responsible= window.auth.user.name
               await axios.post('/api/maternity/actions',this.new_data)
                this.new_data={action_date:'',action_time:'',maternity_action_list_id:''}
                this.bootstrap_list()
            }
        },
        init(){
            axios.get('/api/maternity_action_list').then(response=>{this.actions=response.data})

        },
        bootstrap_list(){
            axios.get(`/api/maternity/actions/${this.maternity_admission_id}`).then(response=>{
                this.list= response.data.maternity_actions
            })
        }
    }
}
</script>

<style scoped>

</style>
