<template>
<div class="container">
    <v-app>
        <v-card min-height="90vh">
            <v-card-title>
                <div class="row">
                    <div class="col-8">
                        Plan for {{fullName}}
                    </div>
                    <div class="col-4">
                        Date: <input type="date" v-model="formData.when"/>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <div class="row">
                    <div class="col-md-12 col-lg-6 ">
                        <div class="card action-container">
                            <div class="card-body">
                                <h5>Treatments</h5>
                                <table class="table-sm table">
                                    <tr>
                                        <td>
                                            <div class="form-group">
<!--                                                <label>Medicine</label>-->
<!--                                                <input type="text" class="form-control form-control-sm" v-model="temp_medicine.med"/>-->
                                                <multiselect
                                                    v-model="temp_row.to_do"
                                                    :custom-label="nameWithCode"
                                                    track-by="description"
                                                    placeholder="search medicines here"
                                                    :options="avalaible_medicines"
                                                    :hide-selected="true"
                                                    class="multiSelect"
                                                    autocomplete="off"
                                                    style="margin-top: 20px"
                                                >
                                                </multiselect>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>Dosage/Frequency</label>
                                                <input type="text" class="form-control form-control-sm" v-model="temp_row.frequency"/>
                                            </div>
                                        </td>
                                        <td>
                                            <v-btn x-small dark color="purple" style="margin-top:30px" @click="push_row(1)">Add</v-btn>
                                        </td>
                                    </tr>
                                    <tr v-for="row in tasks.medicines">
                                        <td>[{{row.to_do.code}}] - {{row.to_do.description}}</td>
                                        <td>{{row.frequency}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card action-container">
                            <div class="card-body">
                                <h5>Actions</h5>
                                <table class="table-sm table">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <!--                                                    <label>Action</label>-->
                                                <!--                                                    <input type="text" class="form-control form-control-sm" v-model="temp_action.action"/>-->
                                                <v-autocomplete
                                                    v-model="temp_row.to_do"
                                                    :items="list_of_actions"
                                                    item-text="description"
                                                    item-value="description"
                                                    style="margin-top:30px"
                                                    dense
                                                    label="Action">
                                                </v-autocomplete>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>Dosage/Frequency</label>
                                                <input type="text" class="form-control form-control-sm" v-model="temp_row.frequency"/>
                                            </div>
                                        </td>
                                        <td style="width:5%">
                                            <v-btn x-small dark color="purple" style="margin-top:30px" @click="push_row(2)">Add</v-btn>
                                        </td>
                                    </tr>
                                    <tr v-for="row in tasks.actions">
                                        <td>{{row.to_do}}</td>
                                        <td>{{row.frequency}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <v-textarea label="Comment" v-model="formData.comment"/>
                    </div>
                </div>
                <v-btn color="primary" small @click="submit" :loading="is_loading" class="mt-2">Submit</v-btn>
                <div class="card mt-2">
                    <div class="card-body">
                        <h6>Data in the system</h6>
                        <div class="table-responsive">
                            <table class="table table-sm ">
                                <tr>
                                    <td>#</td>
                                    <td>Date</td>
                                    <td>Details</td>
                                </tr>
                                <tr v-for="(row,id) in data_in_system">
                                    <td>{{id+1}}</td>
                                    <td>{{ moment(row.created_at).format("MMM Do YY")}}</td>
                                    <td>
                                        <div class="row" v-for="det in row.stork_plan_details">
                                            <div class="col-6">
                                                {{det.to_do}}
                                            </div>
                                            <div class="col-6">
                                                {{det.to_do_frequency}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </v-card-text>
<!--            <v-card-actions class="text-right">-->
<!--                <v-btn color="primary" @click="submit" :loading="is_loading">Submit</v-btn>-->
<!--            </v-card-actions>-->
        </v-card>
    </v-app>
</div>
</template>

<script>
import moment from "moment";
export default {
    name: "stork_plan_for_patient",
    data(){
        return{
            temp_medicine:{med:'',dosage:''},
            temp_row:{to_do:"",frequency:""},
            temp_action:{action:'',frequency:''},
            list_of_actions:[],
            avalaible_medicines:[],
            is_loading:false,
            to_do:[],
            formData:{
                to_do:[],
                when:'',
                stork_admission_id:'',
                user_id:''
            },
            data_in_system:[]
        }
    },
    created(){
        axios.get('/api/v1/extra/stork_action_group').then(response=>this.list_of_actions=response.data)
        this.formData.stork_admission_id= this.$route.params.stork_admission.id
        this.formData.user_id = window.auth.user.id
        this.load_medicines()
        axios.get(`/api/v1/patient_system/in_patient/stork/plan/${this.formData.stork_admission_id}`).then(
            response=>{
                this.data_in_system=response.data
            }
        )
    },
    methods:{
        async load_medicines(){
            await axios.get('/api/v1/inventory_system/item/authorized_service/stork').then(response=>{
                this.avalaible_medicines=response.data
            })
        },
        push_row(type){
            this.temp_row.type=type
            if(this.temp_row.to_do !=='' && this.temp_row.frequency !==''){
                this.formData.to_do.push(this.temp_row)
            }
            this.temp_row={to_do:'',frequency:''}
        },
        null_to_str(str){
            return str?str:""
        },
        nameWithCode ({ code, description }) {
            return `${code} — [${description}]`
        },
        submit(){
            this.is_loading=true
            this.formData.to_do.forEach(l=>{
                if(l.type===1){
                    l.to_do= `[${l.to_do.code}]-${l.to_do.description}`
                }
            })
            axios.post('/api/v1/patient_system/in_patient/stork/plan',this.formData).then(
                response=>{
                    if(response.data.success){
                        this.$router.push({name:'stork_patient_list'})
                    }
                }
            )
        }

    },
    computed:{
        fullName(){
           if(this.$route.params.stork_admission) return this.null_to_str(this.$route.params.stork_admission.patient.firstName) +" "+ this.null_to_str(this.$route.params.stork_admission.patient.lastName)
            return
        },
        tasks(){
            return {
                medicines: this.formData.to_do.filter(item=>item.type===1),
                actions:this.formData.to_do.filter(item=>item.type===2),
            }

        }
    }
}
</script>

<style scoped>
.action-container{
    min-height: 50vh;
}
</style>
