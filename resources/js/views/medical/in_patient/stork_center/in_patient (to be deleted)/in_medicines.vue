<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control form-control-sm" v-model="new_data.date"/>
                </div>
            </div>
            <div class="col">
                <label>Time</label>
                <input type="time" class="form-control form-control-sm" v-model="new_data.time"/>
            </div>
            <div class="col">
                <label>Medicine</label>
                <select class="form-control form-control-sm" v-model="new_data.action" >
                    <option v-for="action in actions">{{action}}</option>
                </select>
            </div>
            <div class="col">
                <label>Value</label>
                <input type="number" class="form-control form-control-sm" v-model="new_data.value" @keydown.enter.prevent="add_data"/>
            </div>
        </div>
        <v-data-table
            :headers="headers"
            :items="list"
            class="elevation-1"
            dense
        ></v-data-table>
    </div>
</template>

<script>
export default {
    name: "in_medicines",
    data(){
        return {
            new_data:{date:'',time:'',action:'',value:''},
            headers:[
                {text:'date',value:'date'},
                {text:'time',value:'time'},
                {text:'Medicine',value:'medicine_id'},
                {text:'value',value:'action_value'},
            ],
            list:[],
            actions:[
                '',
                'test 1',
                'test 2'
            ]
        }
    },
    methods:{
        add_data(){
            if(this.new_data.date !=='' && this.new_data.time !=='' && this.new_data.medicine_id !==''){
                this.list.unshift(this.new_data)
                this.new_data={date:'',time:'',action:''}
            }

        }
    }
}
</script>

<style scoped>

</style>
