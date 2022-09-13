<template>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-text">
                <div class="card-title title">Lunch order form- ({{$route.params.stork_admission.patient_id}})- {{fullName}}</div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Choose the menu</label>
                                <select class="form-control form-control-sm" v-model="formData.menu">
                                    <option v-for="menu in menu_option" :value="menu">{{menu.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                           <div class="form-group">
                               <label>Price</label>
                               <input type="text" disabled class="form-control form-control-sm" :value="formData.menu.price"/>
                           </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" v-model="formData.qty" class="form-control form-control-sm" placeholder="Qty"/>
                            </div>
                        </div>
                        <div class="col">
                            <v-btn @click="submit"  color="indigo" class="mt-4" dark :loading="form_is_submitting">Submit</v-btn>
                        </div>
                    </div>
                    <div class="row">
                        <h6>Data in system</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <td>Date</td>
                                    <td>Menu</td>
                                    <td>Qty</td>
                                    <td>Status</td>
                                </tr>
                                <tr v-for="row in data_in_system">
                                    <td>
                                        {{row.created_at}}
                                    </td>
                                    <td>
                                        {{row.lunch_menu.name}}
                                    </td>
                                    <td>
                                        {{row.qty}}
                                    </td>
                                    <td>
                                        {{row.status}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import moment from "moment";

export default {
    name: "stork_pay_lunch",
    data(){
        return{
            formData:{
                admission_id:'',
                patient_id:'',
                status:'',
                price:'',
                menu:'',
                value:'',
            },
            data_in_system:[],
            menu_option:[],
            form_is_submitting:false
        }
    },
    created(){
        axios.get('/api/v1/extra/lunch_menu').then(response=>this.menu_option=response.data)
        this.load_data_in_system()
        this.formData.admission_id=this.$route.params.admission.id
        this.formData.patient_id=this.$route.params.admission.patient_id

    },
    methods:{
        null_to_str(str){
            return str?str:""
        },
        date_format(date){
            return moment(date).format("MMM Do YY");
        },
        submit(){
            this.form_is_submitting=true
            axios.post('/api/v1/patient_system/in_patient/stork/pay_lunch',this.formData).then(response=>{
                this.$router.push({name:'stork_patient_list'})
            })
        },
        load_data_in_system() {
            axios.get(`/api/v1/patient_system/in_patient/stork/lunch_list/${this.$route.params.admission.id}`).then(response=>{
                this.data_in_system=response.data
                this.data_in_system.forEach(data=>{
                    data.created_at= this.date_format(data.created_at)
                })
            })
        }
    },
    computed:{
        fullName(){
            return this.null_to_str(this.$route.params.stork_admission.patient.firstName) +" "+ this.null_to_str(this.$route.params.stork_admission.patient.lastName)
        }
    }
}
</script>

<style scoped>

</style>
